<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Message;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $orderStats = [
            'total' => Order::where('user_id', $user->id)->count(),
            'pending' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'confirmed' => Order::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'delivered' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
        ];

        // Total des achats (30 derniers jours)
        $totalSpent = Order::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('total_amount');

        // Commande moyenne
        $averageOrder = Order::where('user_id', $user->id)
            ->avg('total_amount');

        // Graphique des commandes par mois (12 derniers mois)
        $ordersPerMonth = Order::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Top 5 produits les plus commandés
        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.user_id', $user->id)
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * order_items.unit_price) as total_amount')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // Statistiques par statut (pour graphique donut)
        $ordersByStatus = Order::where('user_id', $user->id)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $unreadMessages = Message::where('to_user_id', $user->id)
            ->where('is_read', false)
            ->count();

        $featuredProducts = Product::active()
            ->inStock()
            ->limit(8)
            ->get()
            ->map(function ($product) use ($user) {
                $product->user_price = $product->getPriceForUser($user);
                return $product;
            });

        return view('dashboard.index', compact(
            'recentOrders',
            'orderStats',
            'unreadMessages',
            'featuredProducts',
            'totalSpent',
            'averageOrder',
            'ordersPerMonth',
            'topProducts',
            'ordersByStatus'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }
}