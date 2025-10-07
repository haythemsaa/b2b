<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomPrice;
use App\Models\CustomerGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    /**
     * Page principale des rapports
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Rapport des ventes
     */
    public function sales(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth();

        // Ventes totales par période
        $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('AVG(total_amount) as average_order')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Top vendeurs
        $topSellers = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('users.role', 'vendeur')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(orders.total_amount) as total_sales')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        // Produits les plus vendus
        $topProducts = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                DB::raw('SUM(order_items.quantity) as quantity_sold'),
                DB::raw('SUM(order_items.quantity * order_items.unit_price) as revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderBy('revenue', 'desc')
            ->limit(10)
            ->get();

        // Statistiques globales
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount');
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $averageOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return view('admin.reports.sales', compact(
            'salesData',
            'topSellers',
            'topProducts',
            'totalRevenue',
            'totalOrders',
            'averageOrder',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Rapport des stocks
     */
    public function inventory()
    {
        $lowStockProducts = Product::where(function($query) {
                $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                      ->orWhere('stock_quantity', '<=', 10);
            })
            ->orderBy('stock_quantity', 'asc')
            ->get();

        $outOfStockProducts = Product::where('stock_quantity', 0)->get();

        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $inactiveProducts = Product::where('is_active', false)->count();

        $stockValue = Product::select(
                DB::raw('SUM(stock_quantity * price) as total_value'),
                DB::raw('SUM(stock_quantity) as total_items')
            )
            ->first();

        // Produits par catégorie
        $productsByCategory = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category',
                DB::raw('COUNT(products.id) as products_count'),
                DB::raw('SUM(products.stock_quantity) as total_stock'),
                DB::raw('SUM(products.stock_quantity * products.price) as total_value')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_value', 'desc')
            ->get();

        return view('admin.reports.inventory', compact(
            'lowStockProducts',
            'outOfStockProducts',
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'stockValue',
            'productsByCategory'
        ));
    }

    /**
     * Rapport des clients
     */
    public function customers()
    {
        // Top clients par CA
        $topCustomers = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.role', 'vendeur')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(orders.total_amount) as total_spent'),
                DB::raw('AVG(orders.total_amount) as average_order'),
                DB::raw('MAX(orders.created_at) as last_order')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->limit(20)
            ->get();

        // Clients par groupe
        $customersByGroup = CustomerGroup::withCount('users')
            ->with(['users' => function($query) {
                $query->select('users.id', 'customer_groups.id as group_id')
                      ->join('customer_group_users', 'users.id', '=', 'customer_group_users.user_id');
            }])
            ->get();

        // Nouveaux clients (30 derniers jours)
        $newCustomers = User::where('role', 'vendeur')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $totalCustomers = User::where('role', 'vendeur')->count();
        $activeCustomers = User::where('role', 'vendeur')
            ->where('is_active', true)
            ->count();

        return view('admin.reports.customers', compact(
            'topCustomers',
            'customersByGroup',
            'newCustomers',
            'totalCustomers',
            'activeCustomers'
        ));
    }

    /**
     * Export rapport en CSV
     */
    public function export(Request $request, $type)
    {
        $filename = "rapport_{$type}_" . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($type, $request) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $this->getHeaders($type));

            $data = $this->getData($type, $request);

            foreach ($data as $row) {
                fputcsv($file, (array)$row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getHeaders($type)
    {
        switch ($type) {
            case 'sales':
                return ['Date', 'Commandes', 'CA Total', 'Panier Moyen'];
            case 'products':
                return ['Produit', 'SKU', 'Quantité', 'CA'];
            case 'customers':
                return ['Client', 'Email', 'Commandes', 'CA Total', 'Panier Moyen'];
            default:
                return [];
        }
    }

    private function getData($type, $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth();

        switch ($type) {
            case 'sales':
                return Order::whereBetween('created_at', [$startDate, $endDate])
                    ->select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('COUNT(*) as orders'),
                        DB::raw('SUM(total_amount) as total'),
                        DB::raw('AVG(total_amount) as average')
                    )
                    ->groupBy('date')
                    ->get();

            case 'products':
                return OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
                    ->select(
                        'products.name',
                        'products.sku',
                        DB::raw('SUM(order_items.quantity) as quantity'),
                        DB::raw('SUM(order_items.quantity * order_items.unit_price) as revenue')
                    )
                    ->groupBy('products.id', 'products.name', 'products.sku')
                    ->get();

            case 'customers':
                return Order::join('users', 'orders.user_id', '=', 'users.id')
                    ->select(
                        'users.name',
                        'users.email',
                        DB::raw('COUNT(orders.id) as orders'),
                        DB::raw('SUM(orders.total_amount) as total'),
                        DB::raw('AVG(orders.total_amount) as average')
                    )
                    ->groupBy('users.id', 'users.name', 'users.email')
                    ->get();

            default:
                return [];
        }
    }
}
