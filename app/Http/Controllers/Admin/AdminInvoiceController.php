<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminInvoiceController extends Controller
{
    /**
     * Display a listing of all invoices
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['order.user'])
            ->where('tenant_id', Auth::user()->tenant_id);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('order', function($oq) use ($search) {
                      $oq->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function($uq) use ($search) {
                            $uq->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                        });
                  });
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }

        $invoices = $query->latest('invoice_date')->paginate(20);

        // Statistics
        $stats = [
            'total' => Invoice::where('tenant_id', Auth::user()->tenant_id)->count(),
            'pending' => Invoice::where('tenant_id', Auth::user()->tenant_id)->where('status', 'pending')->count(),
            'paid' => Invoice::where('tenant_id', Auth::user()->tenant_id)->where('status', 'paid')->count(),
            'overdue' => Invoice::where('tenant_id', Auth::user()->tenant_id)->where('status', 'overdue')->count(),
            'total_revenue' => Invoice::where('tenant_id', Auth::user()->tenant_id)->where('status', 'paid')->sum('total'),
            'pending_amount' => Invoice::where('tenant_id', Auth::user()->tenant_id)->where('status', 'pending')->sum('total'),
        ];

        return view('admin.invoices.index', compact('invoices', 'stats'));
    }

    /**
     * Display the specified invoice
     */
    public function show($id)
    {
        $invoice = Invoice::with(['order.items.product', 'order.user'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Generate invoice from order
     */
    public function generateFromOrder($orderId)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($orderId);

        // Check if invoice already exists
        if ($order->invoice) {
            return redirect()->route('admin.invoices.show', $order->invoice->id)
                ->with('info', 'Une facture existe déjà pour cette commande.');
        }

        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'tenant_id' => $order->tenant_id,
                'order_id' => $order->id,
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
                'total' => $order->total,
                'status' => 'pending',
                'notes' => 'Facture générée automatiquement depuis la commande #' . $order->order_number,
            ]);

            DB::commit();

            return redirect()->route('admin.invoices.show', $invoice->id)
                ->with('success', 'Facture générée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la génération de la facture: ' . $e->getMessage());
        }
    }

    /**
     * Update invoice status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,overdue,cancelled',
        ]);

        $invoice = Invoice::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $invoice->update([
            'status' => $request->status,
            'paid_at' => $request->status === 'paid' ? now() : $invoice->paid_at,
        ]);

        return redirect()->back()
            ->with('success', 'Statut de la facture mis à jour avec succès.');
    }

    /**
     * Export invoices to CSV
     */
    public function export(Request $request)
    {
        $query = Invoice::with(['order.user'])
            ->where('tenant_id', Auth::user()->tenant_id);

        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest('invoice_date')->get();

        $filename = 'factures_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($invoices) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Numéro Facture',
                'Numéro Commande',
                'Client',
                'Email',
                'Date Facture',
                'Date Échéance',
                'Sous-total (TND)',
                'TVA (TND)',
                'Total (TND)',
                'Statut',
                'Date Paiement',
                'Date Envoi'
            ], ';');

            // Data
            foreach ($invoices as $invoice) {
                fputcsv($file, [
                    $invoice->invoice_number,
                    $invoice->order->order_number ?? 'N/A',
                    $invoice->order->user->name ?? 'N/A',
                    $invoice->order->user->email ?? 'N/A',
                    $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y') : 'N/A',
                    $invoice->due_date->format('d/m/Y'),
                    number_format($invoice->subtotal, 2, ',', ' '),
                    number_format($invoice->tax, 2, ',', ' '),
                    number_format($invoice->total, 2, ',', ' '),
                    ucfirst($invoice->status),
                    $invoice->paid_at ? $invoice->paid_at->format('d/m/Y H:i') : 'Non payée',
                    $invoice->sent_at ? $invoice->sent_at->format('d/m/Y H:i') : 'Non envoyée'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Mark invoice as sent
     */
    public function markAsSent($id)
    {
        $invoice = Invoice::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $invoice->update(['sent_at' => now()]);

        return redirect()->back()
            ->with('success', 'Facture marquée comme envoyée.');
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid($id)
    {
        $invoice = Invoice::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Facture marquée comme payée.');
    }

    /**
     * Download invoice as PDF
     */
    public function downloadPDF($id)
    {
        $invoice = Invoice::with(['order.items.product', 'order.user'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif',
                'dpi' => 150,
                'enable_php' => false,
            ]);

        return $pdf->download('facture-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Stream invoice PDF in browser
     */
    public function streamPDF($id)
    {
        $invoice = Invoice::with(['order.items.product', 'order.user'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif',
                'dpi' => 150,
                'enable_php' => false,
            ]);

        return $pdf->stream('facture-' . $invoice->invoice_number . '.pdf');
    }
}
