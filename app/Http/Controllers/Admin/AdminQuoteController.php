<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminQuoteController extends Controller
{
    /**
     * Display a listing of all quotes for admin/grossiste.
     */
    public function index(Request $request)
    {
        $query = Quote::with(['items', 'user', 'grossiste'])
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('quote_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $quotes = $query->paginate(20);

        // Pour les filtres
        $vendeurs = User::where('role', 'vendeur')->get();
        $statuses = ['draft', 'sent', 'viewed', 'accepted', 'rejected', 'expired', 'converted'];

        // Statistiques
        $stats = [
            'total' => Quote::count(),
            'draft' => Quote::where('status', 'draft')->count(),
            'sent' => Quote::where('status', 'sent')->count(),
            'accepted' => Quote::where('status', 'accepted')->count(),
            'rejected' => Quote::where('status', 'rejected')->count(),
            'converted' => Quote::where('status', 'converted')->count(),
            'total_amount' => Quote::whereIn('status', ['accepted', 'converted'])->sum('total'),
        ];

        return view('admin.quotes.index', compact('quotes', 'vendeurs', 'statuses', 'stats'));
    }

    /**
     * Show the form for creating a new quote.
     */
    public function create()
    {
        $vendeurs = User::where('role', 'vendeur')->where('is_active', true)->get();
        $products = \App\Models\Product::where('is_active', true)->get();

        return view('admin.quotes.create', compact('vendeurs', 'products'));
    }

    /**
     * Store a newly created quote.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:20',
            'valid_until' => 'required|date|after:today',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;
        $validated['grossiste_id'] = auth()->id();
        $validated['status'] = 'draft';
        $validated['quote_number'] = Quote::generateQuoteNumber();

        // Calculer les totaux
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $itemSubtotal = ($item['unit_price'] * $item['quantity']) - ($item['discount'] ?? 0);
            $subtotal += $itemSubtotal;
        }

        $validated['subtotal'] = $subtotal - ($validated['discount'] ?? 0);
        $validated['tax_amount'] = $validated['subtotal'] * ($validated['tax_rate'] / 100);
        $validated['discount_amount'] = $validated['discount'] ?? 0;
        $validated['total'] = $validated['subtotal'] + $validated['tax_amount'];
        $validated['terms_conditions'] = $validated['terms'] ?? null;

        $quote = Quote::create($validated);

        // Créer les items
        foreach ($validated['items'] as $item) {
            $product = \App\Models\Product::find($item['product_id']);

            $quote->items()->create([
                'product_id' => $item['product_id'],
                'product_name' => $product->name,
                'product_sku' => $product->sku ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount_amount' => $item['discount'] ?? 0,
                'subtotal' => ($item['unit_price'] * $item['quantity']) - ($item['discount'] ?? 0),
            ]);
        }

        return redirect()->route('admin.quotes.show', $quote)
            ->with('success', 'Devis créé avec succès.');
    }

    /**
     * Display the specified quote.
     */
    public function show(Quote $quote)
    {
        $quote->load(['items.product', 'user', 'grossiste', 'convertedOrder']);

        return view('admin.quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified quote.
     */
    public function edit(Quote $quote)
    {
        if ($quote->status !== 'draft') {
            return redirect()->route('admin.quotes.show', $quote)
                ->with('error', 'Seuls les devis en brouillon peuvent être modifiés.');
        }

        $vendeurs = User::where('role', 'vendeur')->where('is_active', true)->get();
        $products = \App\Models\Product::where('is_active', true)->get();

        $quote->load(['items.product', 'user']);

        return view('admin.quotes.edit', compact('quote', 'vendeurs', 'products'));
    }

    /**
     * Update the specified quote.
     */
    public function update(Request $request, Quote $quote)
    {
        if ($quote->status !== 'draft') {
            return back()->with('error', 'Seuls les devis en brouillon peuvent être modifiés.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:20',
            'valid_until' => 'required|date|after:today',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        // Calculer les totaux
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $itemSubtotal = ($item['unit_price'] * $item['quantity']) - ($item['discount'] ?? 0);
            $subtotal += $itemSubtotal;
        }

        $validated['subtotal'] = $subtotal - ($validated['discount'] ?? 0);
        $validated['tax_amount'] = $validated['subtotal'] * ($validated['tax_rate'] / 100);
        $validated['discount_amount'] = $validated['discount'] ?? 0;
        $validated['total'] = $validated['subtotal'] + $validated['tax_amount'];
        $validated['terms_conditions'] = $validated['terms'] ?? null;

        $quote->update($validated);

        // Supprimer les anciens items et recréer
        $quote->items()->delete();
        foreach ($validated['items'] as $item) {
            $product = \App\Models\Product::find($item['product_id']);

            $quote->items()->create([
                'product_id' => $item['product_id'],
                'product_name' => $product->name,
                'product_sku' => $product->sku ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount_amount' => $item['discount'] ?? 0,
                'subtotal' => ($item['unit_price'] * $item['quantity']) - ($item['discount'] ?? 0),
            ]);
        }

        return redirect()->route('admin.quotes.show', $quote)
            ->with('success', 'Devis mis à jour avec succès.');
    }

    /**
     * Send quote to customer.
     */
    public function send(Quote $quote)
    {
        if (!in_array($quote->status, ['draft', 'sent'])) {
            return back()->with('error', 'Ce devis ne peut pas être envoyé.');
        }

        $quote->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // TODO: Envoyer email au client

        return back()->with('success', 'Devis envoyé avec succès.');
    }

    /**
     * Accept a quote.
     */
    public function accept(Quote $quote)
    {
        if (!in_array($quote->status, ['sent', 'viewed'])) {
            return back()->with('error', 'Ce devis ne peut pas être accepté.');
        }

        $quote->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return back()->with('success', 'Devis accepté avec succès.');
    }

    /**
     * Reject a quote.
     */
    public function reject(Quote $quote)
    {
        if (!in_array($quote->status, ['sent', 'viewed'])) {
            return back()->with('error', 'Ce devis ne peut pas être rejeté.');
        }

        $quote->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Devis rejeté.');
    }

    /**
     * Convert quote to order.
     */
    public function convertToOrder(Quote $quote)
    {
        if ($quote->status !== 'accepted') {
            return back()->with('error', 'Seuls les devis acceptés peuvent être convertis en commande.');
        }

        if ($quote->converted_order_id) {
            return back()->with('error', 'Ce devis a déjà été converti en commande.');
        }

        // Créer la commande
        $order = \App\Models\Order::create([
            'tenant_id' => $quote->tenant_id,
            'user_id' => $quote->user_id,
            'order_number' => \App\Models\Order::generateOrderNumber(),
            'status' => 'pending',
            'subtotal' => $quote->subtotal,
            'tax_amount' => $quote->tax_amount,
            'discount_amount' => $quote->discount_amount ?? 0,
            'total' => $quote->total,
            'notes' => 'Créé depuis le devis ' . $quote->quote_number,
        ]);

        // Copier les items
        foreach ($quote->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'product_sku' => $item->product_sku,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total,
            ]);
        }

        // Mettre à jour le devis
        $quote->update([
            'status' => 'converted',
            'converted_order_id' => $order->id,
        ]);

        return redirect()->route('admin.orders.show', $order->order_number)
            ->with('success', 'Devis converti en commande avec succès.');
    }

    /**
     * Duplicate a quote.
     */
    public function duplicate(Quote $quote)
    {
        $newQuote = $quote->replicate();
        $newQuote->quote_number = Quote::generateQuoteNumber();
        $newQuote->status = 'draft';
        $newQuote->sent_at = null;
        $newQuote->viewed_at = null;
        $newQuote->accepted_at = null;
        $newQuote->rejected_at = null;
        $newQuote->converted_order_id = null;
        $newQuote->save();

        // Copier les items
        foreach ($quote->items as $item) {
            $newQuote->items()->create($item->only([
                'product_id', 'quantity', 'unit_price', 'discount', 'subtotal', 'notes'
            ]));
        }

        return redirect()->route('admin.quotes.edit', $newQuote)
            ->with('success', 'Devis dupliqué avec succès.');
    }

    /**
     * Download quote as PDF.
     */
    public function downloadPdf(Quote $quote)
    {
        // TODO: Implémenter la génération PDF
        return back()->with('info', 'Génération PDF en cours de développement.');
    }

    /**
     * Approve a quote.
     */
    public function approve(Quote $quote)
    {
        if ($quote->status !== 'sent' && $quote->status !== 'viewed') {
            return back()->with('error', 'Seuls les devis envoyés peuvent être approuvés.');
        }

        $quote->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        // TODO: Envoyer notification au vendeur

        return back()->with('success', 'Devis approuvé avec succès.');
    }

    /**
     * Delete a quote.
     */
    public function destroy(Quote $quote)
    {
        // Vérifier que le devis peut être supprimé
        if ($quote->status === 'converted') {
            return back()->with('error', 'Un devis converti en commande ne peut pas être supprimé.');
        }

        $quoteNumber = $quote->quote_number;
        $quote->delete();

        return redirect()->route('admin.quotes.index')
            ->with('success', "Devis {$quoteNumber} supprimé avec succès.");
    }

    /**
     * Export quotes to CSV.
     */
    public function export(Request $request)
    {
        $query = Quote::with(['items', 'user', 'grossiste']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $quotes = $query->get();

        $filename = 'devis_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($quotes) {
            $file = fopen('php://output', 'w');

            // Headers CSV
            fputcsv($file, [
                'Numéro',
                'Date',
                'Vendeur',
                'Client',
                'Email Client',
                'Statut',
                'Montant HT',
                'TVA',
                'Total TTC',
                'Nb Articles',
                'Valide jusqu\'au',
            ]);

            // Données
            foreach ($quotes as $quote) {
                fputcsv($file, [
                    $quote->quote_number,
                    $quote->created_at->format('d/m/Y H:i'),
                    $quote->user->name,
                    $quote->customer_name,
                    $quote->customer_email,
                    $quote->status,
                    $quote->subtotal,
                    $quote->tax_amount,
                    $quote->total,
                    $quote->items->count(),
                    $quote->valid_until ? $quote->valid_until->format('d/m/Y') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk actions on quotes.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,approve,reject',
            'quote_ids' => 'required|array',
            'quote_ids.*' => 'exists:quotes,id',
        ]);

        $quotes = Quote::whereIn('id', $request->quote_ids)->get();
        $count = 0;

        foreach ($quotes as $quote) {
            switch ($request->action) {
                case 'delete':
                    if ($quote->status !== 'converted') {
                        $quote->delete();
                        $count++;
                    }
                    break;

                case 'approve':
                    if (in_array($quote->status, ['sent', 'viewed'])) {
                        $quote->update([
                            'status' => 'accepted',
                            'accepted_at' => now(),
                        ]);
                        $count++;
                    }
                    break;

                case 'reject':
                    if (in_array($quote->status, ['sent', 'viewed'])) {
                        $quote->update([
                            'status' => 'rejected',
                            'rejected_at' => now(),
                        ]);
                        $count++;
                    }
                    break;
            }
        }

        $actionLabels = [
            'delete' => 'supprimés',
            'approve' => 'approuvés',
            'reject' => 'rejetés',
        ];

        return back()->with('success', "{$count} devis {$actionLabels[$request->action]}.");
    }
}
