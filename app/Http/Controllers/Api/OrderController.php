<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = $request->input('per_page', 20);

        $query = Order::where('user_id', $user->id)
            ->where('tenant_id', $user->tenant_id)
            ->with(['items.product.images']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by date range
        if ($request->has('from_date')) {
            $query->where('created_at', '>=', $request->input('from_date'));
        }
        if ($request->has('to_date')) {
            $query->where('created_at', '<=', $request->input('to_date'));
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (in_array($sortBy, ['created_at', 'total_amount', 'status'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $orders = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'orders' => $orders->map(function ($order) {
                    return $this->formatOrder($order);
                }),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'total_pages' => $orders->lastPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                ]
            ]
        ], 200);
    }

    /**
     * Display the specified order
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, Request $request)
    {
        $user = $request->user();

        $order = Order::where('id', $id)
            ->where('user_id', $user->id)
            ->where('tenant_id', $user->tenant_id)
            ->with(['items.product.images'])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order' => $this->formatOrder($order, true)
            ]
        ], 200);
    }

    /**
     * Create a new order from cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_postal_code' => 'required|string',
            'shipping_phone' => 'required|string',
            'payment_method' => 'required|in:credit_card,bank_transfer,cash,check',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $cart = Cart::forUser($user->id)->with(['items.product'])->first();

        if (!$cart || $cart->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        // Check stock availability for all items
        foreach ($cart->items as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Insufficient stock for product: {$item->product->name}. Available: {$item->product->stock_quantity}"
                ], 400);
            }
        }

        DB::beginTransaction();

        try {
            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'tenant_id' => $user->tenant_id,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'subtotal' => $cart->subtotal,
                'tax' => $cart->tax,
                'shipping_cost' => 0, // Calculate if needed
                'discount' => $cart->discount ?? 0,
                'total_amount' => $cart->total,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_phone' => $request->shipping_phone,
                'notes' => $request->notes,
            ]);

            // Create order items and update stock
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->subtotal,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
            }

            // Clear cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            $order->load(['items.product.images']);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => $this->formatOrder($order, true)
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel an order
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($id, Request $request)
    {
        $user = $request->user();

        $order = Order::where('id', $id)
            ->where('user_id', $user->id)
            ->where('tenant_id', $user->tenant_id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled in current status'
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Restore product stock
            foreach ($order->items as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }

            // Update order status
            $order->update(['status' => 'cancelled']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully',
                'data' => [
                    'order' => $this->formatOrder($order)
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order statistics
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('user_id', $user->id)->where('status', 'cancelled')->count(),
            'total_spent' => Order::where('user_id', $user->id)
                ->whereIn('status', ['completed', 'shipped', 'delivered'])
                ->sum('total_amount'),
            'recent_orders' => Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($order) {
                    return $this->formatOrder($order);
                }),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ], 200);
    }

    /**
     * Format order data for API response
     *
     * @param Order $order
     * @param bool $detailed
     * @return array
     */
    private function formatOrder($order, $detailed = false)
    {
        $data = [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'payment_method' => $order->payment_method,
            'subtotal' => (float) $order->subtotal,
            'tax' => (float) $order->tax,
            'shipping_cost' => (float) $order->shipping_cost,
            'discount' => (float) $order->discount,
            'total_amount' => (float) $order->total_amount,
            'created_at' => $order->created_at->toISOString(),
            'status_label' => ucfirst($order->status),
        ];

        if ($detailed) {
            $data['shipping_address'] = $order->shipping_address;
            $data['shipping_city'] = $order->shipping_city;
            $data['shipping_postal_code'] = $order->shipping_postal_code;
            $data['shipping_phone'] = $order->shipping_phone;
            $data['notes'] = $order->notes;
            $data['items'] = $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => (float) $item->price,
                    'subtotal' => (float) $item->subtotal,
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'sku' => $item->product->sku,
                        'main_image' => $item->product->images->where('is_cover', true)->first()
                            ? asset('storage/' . $item->product->images->where('is_cover', true)->first()->image_path)
                            : null,
                    ]
                ];
            });
            $data['updated_at'] = $order->updated_at->toISOString();
        } else {
            $data['items_count'] = $order->items->count();
        }

        return $data;
    }
}
