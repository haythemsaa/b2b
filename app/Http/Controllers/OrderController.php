<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function cart()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $user = Auth::user();
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($cart as $productId => $quantity) {
                if (isset($products[$productId])) {
                    $product = $products[$productId];
                    $price = $product->getPriceForUser($user);
                    $subtotal = $price * $quantity;

                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal,
                    ];

                    $total += $subtotal;
                }
            }
        }

        return view('orders.cart', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return response()->json(['error' => 'Ce produit n\'est plus disponible.'], 400);
        }

        $quantity = $request->quantity;

        if ($quantity < $product->min_order_quantity) {
            $error = "La quantité minimale pour ce produit est de {$product->min_order_quantity}.";
            return $request->expectsJson()
                ? response()->json(['error' => $error], 400)
                : redirect()->back()->with('error', $error);
        }

        if ($product->order_multiple > 1 && $quantity % $product->order_multiple !== 0) {
            $error = "Ce produit doit être commandé par multiples de {$product->order_multiple}.";
            return $request->expectsJson()
                ? response()->json(['error' => $error], 400)
                : redirect()->back()->with('error', $error);
        }

        if ($product->stock_quantity < $quantity) {
            $error = 'Stock insuffisant.';
            return $request->expectsJson()
                ? response()->json(['error' => $error], 400)
                : redirect()->back()->with('error', $error);
        }

        $cart = Session::get('cart', []);
        $currentQuantity = $cart[$product->id] ?? 0;
        $newQuantity = $currentQuantity + $quantity;

        if ($product->stock_quantity < $newQuantity) {
            $error = 'Stock insuffisant.';
            return $request->expectsJson()
                ? response()->json(['error' => $error], 400)
                : redirect()->back()->with('error', $error);
        }

        $cart[$product->id] = $newQuantity;
        Session::put('cart', $cart);

        $cartCount = array_sum($cart);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Produit ajouté au panier.',
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès.');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $cart = Session::get('cart', []);

        if ($quantity === 0) {
            unset($cart[$product->id]);
        } else {
            if ($quantity < $product->min_order_quantity) {
                return response()->json([
                    'error' => "La quantité minimale pour ce produit est de {$product->min_order_quantity}."
                ], 400);
            }

            if ($product->order_multiple > 1 && $quantity % $product->order_multiple !== 0) {
                return response()->json([
                    'error' => "Ce produit doit être commandé par multiples de {$product->order_multiple}."
                ], 400);
            }

            if ($product->stock_quantity < $quantity) {
                return response()->json(['error' => 'Stock insuffisant.'], 400);
            }

            $cart[$product->id] = $quantity;
        }

        Session::put('cart', $cart);

        return response()->json(['message' => 'Panier mis à jour.']);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = Session::get('cart', []);
        unset($cart[$request->product_id]);
        Session::put('cart', $cart);

        return response()->json(['message' => 'Produit retiré du panier.']);
    }

    public function clearCart()
    {
        Session::forget('cart');

        return response()->json(['message' => 'Panier vidé.']);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'currency' => 'TND',
                'notes' => $request->notes,
            ]);

            $total = 0;

            foreach ($cart as $productId => $quantity) {
                $product = Product::findOrFail($productId);

                if (!$product->is_active) {
                    throw new \Exception("Le produit {$product->name} n'est plus disponible.");
                }

                if ($product->stock_quantity < $quantity) {
                    throw new \Exception("Stock insuffisant pour {$product->name}.");
                }

                $price = $product->getPriceForUser($user);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'total_price' => $price * $quantity,
                ]);

                $product->decrementStock($quantity);
                $total += $price * $quantity;
            }

            $order->update([
                'subtotal' => $total,
                'total_amount' => $total,
            ]);

            Session::forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order->order_number)
                ->with('success', 'Votre commande a été passée avec succès.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }
}