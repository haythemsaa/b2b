<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_vendeurs' => User::where('role', 'vendeur')->count(),
            'active_vendeurs' => User::where('role', 'vendeur')->where('is_active', true)->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'low_stock_products' => Product::whereRaw('stock_quantity <= stock_alert_threshold')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'monthly_orders' => Order::whereMonth('created_at', now()->month)->count(),
            'unread_messages' => Message::where('to_user_id', auth()->id())->where('is_read', false)->count(),
        ];

        $recentOrders = Order::with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $lowStockProducts = Product::whereRaw('stock_quantity <= stock_alert_threshold')
            ->where('is_active', true)
            ->orderBy('stock_quantity')
            ->limit(10)
            ->get();

        $monthlyOrdersChart = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereMonth('created_at', now()->month)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        $topCustomers = User::where('role', 'vendeur')
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'lowStockProducts',
            'monthlyOrdersChart',
            'topCustomers'
        ));
    }
}