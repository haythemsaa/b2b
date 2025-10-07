<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::with(['items', 'user', 'grossiste'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('is_active', true)->get();
        $grossistes = User::where('role', 'grossiste')->get();

        return view('quotes.create', compact('products', 'grossistes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'grossiste_id' => 'required|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string',
            'valid_until' => 'nullable|date',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        // Créer le devis
        $quote = Quote::create([
            'user_id' => Auth::id(),
            'grossiste_id' => $validated['grossiste_id'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
            'valid_until' => $validated['valid_until'] ?? now()->addDays(30),
            'notes' => $validated['notes'] ?? null,
            'terms_conditions' => $validated['terms_conditions'] ?? null,
            'status' => 'draft',
        ]);

        // Créer les items
        foreach ($validated['items'] as $itemData) {
            $product = Product::find($itemData['product_id']);

            QuoteItem::create([
                'quote_id' => $quote->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'product_description' => $product->description,
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'discount_percent' => $itemData['discount_percent'] ?? 0,
                'tax_rate' => 19, // TVA par défaut
            ]);
        }

        // Recalculer les totaux
        $quote->calculateTotals();

        return redirect()->route('quotes.show', $quote)->with('success', 'Devis créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        // Vérifier que l'utilisateur a accès à ce devis
        if ($quote->user_id !== Auth::id() && $quote->grossiste_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $quote->load(['items.product', 'user', 'grossiste']);

        return view('quotes.show', compact('quote'));
    }

    /**
     * Download PDF version of the quote.
     */
    public function downloadPdf(Quote $quote)
    {
        // Vérifier que l'utilisateur a accès à ce devis
        if ($quote->user_id !== Auth::id() && $quote->grossiste_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $quote->load(['items.product', 'user', 'grossiste']);

        // TODO: Implémenter génération PDF avec DomPDF ou similaire
        // Pour l'instant, retourner une vue simple
        return view('quotes.pdf', compact('quote'));
    }

    /**
     * Send the quote to customer.
     */
    public function send(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $quote->update([
            'status' => 'sent',
        ]);

        // TODO: Envoyer email au client

        return redirect()->route('quotes.show', $quote)->with('success', 'Devis envoyé avec succès.');
    }

    /**
     * Accept the quote.
     */
    public function accept(Quote $quote)
    {
        if ($quote->grossiste_id !== Auth::id()) {
            abort(403, 'Seul le grossiste peut accepter ce devis.');
        }

        $quote->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return redirect()->route('quotes.show', $quote)->with('success', 'Devis accepté avec succès.');
    }

    /**
     * Reject the quote.
     */
    public function reject(Quote $quote)
    {
        if ($quote->grossiste_id !== Auth::id()) {
            abort(403, 'Seul le grossiste peut rejeter ce devis.');
        }

        $quote->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        return redirect()->route('quotes.show', $quote)->with('warning', 'Devis rejeté.');
    }

    /**
     * Convert quote to order.
     */
    public function convertToOrder(Quote $quote)
    {
        if ($quote->user_id !== Auth::id() && $quote->grossiste_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        if (!$quote->canBeConverted()) {
            return redirect()->route('quotes.show', $quote)->with('error', 'Ce devis ne peut pas être converti en commande.');
        }

        $order = $quote->convertToOrder();

        if ($order) {
            return redirect()->route('orders.show', $order)->with('success', 'Devis converti en commande avec succès.');
        }

        return redirect()->route('quotes.show', $quote)->with('error', 'Erreur lors de la conversion du devis.');
    }
}
