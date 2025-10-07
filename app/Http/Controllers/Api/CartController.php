<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Get current user's cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = Cart::forUser($user->id)->with(['items.product.images'])->first();

        if (!$cart) {
            return response()->json([
                'success' => true,
                'data' => [
                    'cart' => null,
                    'items' => [],
                    'summary' => [
                        'subtotal' => 0,
                        'tax' => 0,
                        'total' => 0,
                        'items_count' => 0
                    ]
                ]
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'cart' => [
                    'id' => $cart->id,
                    'created_at' => $cart->created_at->toISOString(),
                    'updated_at' => $cart->updated_at->toISOString(),
                ],
                'items' => $cart->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'quantity' => $item->quantity,
                        'price' => (float) $item->price,
                        'subtotal' => (float) $item->subtotal,
                        'product' => [
                            'id' => $item->product->id,
                            'name' => $item->product->name,
                            'sku' => $item->product->sku,
                            'stock_quantity' => $item->product->stock_quantity,
                            'in_stock' => $item->product->stock_quantity > 0,
                            'main_image' => $item->product->images->where('is_cover', true)->first()
                                ? asset('storage/' . $item->product->images->where('is_cover', true)->first()->image_path)
                                : null,
                        ]
                    ];
                }),
                'summary' => [
                    'subtotal' => (float) $cart->subtotal,
                    'tax' => (float) $cart->tax,
                    'total' => (float) $cart->total,
                    'items_count' => $cart->getTotalItems(),
                    'discount' => $cart->discount ? (float) $cart->discount : 0,
                    'discount_code' => $cart->discount_code,
                ]
            ]
        ], 200);
    }

    /**
     * Add product to cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $product = Product::where('id', $request->product_id)
            ->where('tenant_id', $user->tenant_id)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available'
            ], 400);
        }

        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Available: ' . $product->stock_quantity
            ], 400);
        }

        // Get or create cart
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
        ]);

        // Check if product already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        // Get user-specific price
        $price = $product->price;
        if ($user->group_id) {
            $customPrice = $product->customPrices()
                ->where('group_id', $user->group_id)
                ->first();
            if ($customPrice) {
                $price = $customPrice->price;
            }
        }

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($product->stock_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $product->stock_quantity
                ], 400);
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $price,
            ]);
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $price,
            ]);
        }

        $cart->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'data' => [
                'cart_item' => [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->quantity,
                    'price' => (float) $cartItem->price,
                    'subtotal' => (float) $cartItem->subtotal,
                ],
                'cart_summary' => [
                    'subtotal' => (float) $cart->subtotal,
                    'tax' => (float) $cart->tax,
                    'total' => (float) $cart->total,
                    'items_count' => $cart->getTotalItems(),
                ]
            ]
        ], 200);
    }

    /**
     * Update cart item quantity
     *
     * @param int $itemId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($itemId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $cart = Cart::forUser($user->id)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }

        $cartItem = CartItem::where('id', $itemId)
            ->where('cart_id', $cart->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $product = $cartItem->product;

        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Available: ' . $product->stock_quantity
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        $cart->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Cart item updated successfully',
            'data' => [
                'cart_item' => [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => (float) $cartItem->subtotal,
                ],
                'cart_summary' => [
                    'subtotal' => (float) $cart->subtotal,
                    'tax' => (float) $cart->tax,
                    'total' => (float) $cart->total,
                    'items_count' => $cart->getTotalItems(),
                ]
            ]
        ], 200);
    }

    /**
     * Remove item from cart
     *
     * @param int $itemId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($itemId, Request $request)
    {
        $user = $request->user();
        $cart = Cart::forUser($user->id)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }

        $cartItem = CartItem::where('id', $itemId)
            ->where('cart_id', $cart->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->delete();
        $cart->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart successfully',
            'data' => [
                'cart_summary' => [
                    'subtotal' => (float) $cart->subtotal,
                    'tax' => (float) $cart->tax,
                    'total' => (float) $cart->total,
                    'items_count' => $cart->getTotalItems(),
                ]
            ]
        ], 200);
    }

    /**
     * Clear cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear(Request $request)
    {
        $user = $request->user();
        $cart = Cart::forUser($user->id)->first();

        if (!$cart) {
            return response()->json([
                'success' => true,
                'message' => 'Cart is already empty'
            ], 200);
        }

        $cart->items()->delete();
        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ], 200);
    }

    /**
     * Apply discount code
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $cart = Cart::forUser($user->id)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }

        // Placeholder for discount code validation
        // In real implementation, validate against discounts table
        $discountAmount = 0; // Calculate based on code

        $cart->update([
            'discount_code' => $request->code,
            'discount' => $discountAmount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Discount code applied successfully',
            'data' => [
                'cart_summary' => [
                    'subtotal' => (float) $cart->subtotal,
                    'discount' => (float) $cart->discount,
                    'tax' => (float) $cart->tax,
                    'total' => (float) $cart->total,
                    'items_count' => $cart->getTotalItems(),
                ]
            ]
        ], 200);
    }

    /**
     * Get cart count (number of items)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function count(Request $request)
    {
        $user = $request->user();
        $cart = Cart::forUser($user->id)->first();

        $count = $cart ? $cart->getTotalItems() : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'count' => $count
            ]
        ], 200);
    }
}
