<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's cart
     */
    public function index()
    {
        $user = Auth::user();

        // Get or create cart for the user
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id
        ]);

        $cartItems = $cart->items()->with('product')->get();

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->unit_price;
        });

        $tax = $subtotal * 0.19; // 19% TVA
        $total = $subtotal + $tax;

        return view('cart.index', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        // Check minimum order quantity
        if ($product->min_order_quantity && $request->quantity < $product->min_order_quantity) {
            return redirect()->back()->with('error', "La quantité minimale pour ce produit est de {$product->min_order_quantity}.");
        }

        // Check order multiple
        if ($product->order_multiple && $request->quantity % $product->order_multiple !== 0) {
            return redirect()->back()->with('error', "Ce produit doit être commandé par multiples de {$product->order_multiple}.");
        }

        // Check stock availability
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        // Get or create cart
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id
        ]);

        // Check if item already exists in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                           ->where('product_id', $product->id)
                           ->first();

        if ($cartItem) {
            // Update existing item
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($product->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Stock insuffisant pour cette quantité.');
            }

            $cartItem->update([
                'quantity' => $newQuantity
            ]);
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès.');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Panier non trouvé.');
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
                           ->where('id', $itemId)
                           ->first();

        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Article non trouvé dans le panier.');
        }

        $product = $cartItem->product;

        // Check stock availability
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stock insuffisant pour cette quantité.');
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->route('cart.index')->with('success', 'Quantité mise à jour.');
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Panier non trouvé.');
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
                           ->where('id', $itemId)
                           ->first();

        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Article non trouvé dans le panier.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Article supprimé du panier.');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Panier vidé.');
    }

    /**
     * Get cart count for display
     */
    public function getCount()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return response()->json(['count' => 0]);
        }

        $count = $cart->items()->sum('quantity');

        return response()->json(['count' => $count]);
    }

    /**
     * Apply discount code
     */
    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount_code' => 'required|string'
        ]);

        // Basic discount logic - can be expanded
        $discountCodes = [
            'WELCOME10' => 10,
            'SAVE20' => 20,
            'BULK30' => 30
        ];

        $code = strtoupper($request->discount_code);

        if (isset($discountCodes[$code])) {
            session(['discount_code' => $code, 'discount_percentage' => $discountCodes[$code]]);
            return redirect()->route('cart.index')->with('success', "Code de réduction appliqué: {$discountCodes[$code]}% de remise.");
        }

        return redirect()->route('cart.index')->with('error', 'Code de réduction invalide.');
    }

    /**
     * Remove discount
     */
    public function removeDiscount()
    {
        session()->forget(['discount_code', 'discount_percentage']);
        return redirect()->route('cart.index')->with('success', 'Code de réduction supprimé.');
    }
}