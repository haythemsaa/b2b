<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices for the authenticated user
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
                      $oq->where('order_number', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }

        $invoices = $query->latest('invoice_date')->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Display the specified invoice
     */
    public function show($id)
    {
        $invoice = Invoice::with(['order.items.product', 'order.user'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Download invoice as PDF
     */
    public function download($id)
    {
        $invoice = Invoice::with(['order.items.product', 'order.user'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download($invoice->invoice_number . '.pdf');
    }

    /**
     * Generate invoice from order (Admin only)
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
                'invoice_number' => $this->generateInvoiceNumber(),
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
                'total' => $order->total,
                'status' => 'pending',
                'notes' => 'Facture générée automatiquement depuis la commande #' . $order->order_number,
            ]);

            // Update order
            $order->update(['invoice_generated' => true]);

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
            'paid_at' => $request->status === 'paid' ? now() : null,
        ]);

        return redirect()->back()
            ->with('success', 'Statut de la facture mis à jour avec succès.');
    }

    /**
     * Send invoice by email
     */
    public function send($id)
    {
        $invoice = Invoice::with(['order.user'])
            ->where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        // TODO: Implement email sending logic
        // Mail::to($invoice->order->user->email)->send(new InvoiceMail($invoice));

        $invoice->update(['sent_at' => now()]);

        return redirect()->back()
            ->with('success', 'Facture envoyée par email avec succès.');
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

        $invoices = $query->latest('invoice_date')->get();

        $filename = 'invoices_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($invoices) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'Numéro Facture',
                'Numéro Commande',
                'Client',
                'Date Facture',
                'Date Échéance',
                'Sous-total',
                'TVA',
                'Total',
                'Statut',
                'Date Paiement'
            ]);

            // Data
            foreach ($invoices as $invoice) {
                fputcsv($file, [
                    $invoice->invoice_number,
                    $invoice->order->order_number ?? 'N/A',
                    $invoice->order->user->name ?? 'N/A',
                    $invoice->invoice_date->format('d/m/Y'),
                    $invoice->due_date->format('d/m/Y'),
                    number_format($invoice->subtotal, 2),
                    number_format($invoice->tax, 2),
                    number_format($invoice->total, 2),
                    $invoice->status,
                    $invoice->paid_at ? $invoice->paid_at->format('d/m/Y H:i') : 'Non payée'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate unique invoice number
     */
    private function generateInvoiceNumber()
    {
        $year = date('Y');
        $month = date('m');
        $tenant_id = Auth::user()->tenant_id;

        $lastInvoice = Invoice::where('tenant_id', $tenant_id)
            ->whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastInvoice ? ((int) substr($lastInvoice->invoice_number, -4)) + 1 : 1;

        return sprintf('INV-%s%s-%04d', $year, $month, $sequence);
    }
}
