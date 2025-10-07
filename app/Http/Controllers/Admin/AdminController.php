<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductReturn;
use App\Models\Message;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Ajouter un middleware pour vérifier le rôle admin/grossiste
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role, ['grossiste', 'superadmin'])) {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $tenantId = $user->tenant_id;

        // Statistiques pour le tenant
        $stats = [
            'total_users' => User::where('tenant_id', $tenantId)->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::whereHas('user', function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })->count(),
            'pending_orders' => Order::whereHas('user', function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })->where('status', 'pending')->count(),
            'total_revenue' => Order::whereHas('user', function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })->sum('total'),
            'monthly_revenue' => Order::whereHas('user', function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })->whereMonth('created_at', now()->month)->sum('total'),
            'low_stock_products' => Product::where('stock', '<', 10)->count(),
            'pending_returns' => ProductReturn::where('status', 'pending')->count(),
            'unread_messages' => Message::where('receiver_id', $user->id)->where('read', false)->count()
        ];

        // Dernières commandes
        $recent_orders = Order::whereHas('user', function($query) use ($tenantId) {
            $query->where('tenant_id', $tenantId);
        })->with('user')->latest()->take(5)->get();

        // Produits en stock faible
        $low_stock_products = Product::where('stock', '<', 10)->take(5)->get();

        // Top vendeurs du mois
        $top_sellers = User::where('tenant_id', $tenantId)
            ->where('role', 'vendeur')
            ->withCount(['orders' => function($query) {
                $query->whereMonth('created_at', now()->month);
            }])
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'low_stock_products',
            'top_sellers'
        ));
    }

    /**
     * Reports page
     */
    public function reports()
    {
        $user = Auth::user();
        $tenantId = $user->tenant_id;

        // Données pour les graphiques
        $monthlyOrders = [];
        $monthlyRevenue = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M Y');

            $orders = Order::whereHas('user', function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })->whereYear('created_at', $date->year)
              ->whereMonth('created_at', $date->month)
              ->count();

            $revenue = Order::whereHas('user', function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })->whereYear('created_at', $date->year)
              ->whereMonth('created_at', $date->month)
              ->sum('total');

            $monthlyOrders[$month] = $orders;
            $monthlyRevenue[$month] = $revenue;
        }

        // Top produits
        $topProducts = Product::withCount(['orderItems' => function($query) use ($tenantId) {
            $query->whereHas('order.user', function($q) use ($tenantId) {
                $q->where('tenant_id', $tenantId);
            });
        }])->orderBy('order_items_count', 'desc')->take(10)->get();

        return view('admin.reports', compact(
            'monthlyOrders',
            'monthlyRevenue',
            'topProducts'
        ));
    }

    /**
     * Settings page
     */
    public function settings()
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        return view('admin.settings', compact('tenant'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'timezone' => 'required|string',
            'currency' => 'required|string|size:3'
        ]);

        $user = Auth::user();
        $tenant = $user->tenant;

        if ($tenant) {
            $tenant->update([
                'name' => $request->company_name,
                'settings' => array_merge($tenant->settings ?? [], [
                    'contact_email' => $request->contact_email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'timezone' => $request->timezone,
                    'currency' => $request->currency
                ])
            ]);
        }

        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }

    /**
     * Export data
     */
    public function export(Request $request, $type)
    {
        $user = Auth::user();
        $tenantId = $user->tenant_id;
        $format = $request->get('format', 'csv');

        switch ($type) {
            case 'users':
                return $this->exportUsers($tenantId, $format);
            case 'orders':
                return $this->exportOrders($tenantId, $format);
            case 'products':
                return $this->exportProducts($format);
            default:
                abort(404);
        }
    }

    private function exportUsers($tenantId, $format)
    {
        $users = User::where('tenant_id', $tenantId)->get();

        if ($format === 'json') {
            return response()->json($users);
        }

        $filename = 'users_export_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nom', 'Email', 'Rôle', 'Date création']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportOrders($tenantId, $format)
    {
        $orders = Order::whereHas('user', function($query) use ($tenantId) {
            $query->where('tenant_id', $tenantId);
        })->with('user')->get();

        if ($format === 'json') {
            return response()->json($orders);
        }

        $filename = 'orders_export_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Client', 'Statut', 'Total', 'Date']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->user->name,
                    $order->status,
                    $order->total,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportProducts($format)
    {
        $products = Product::with('category')->get();

        if ($format === 'json') {
            return response()->json($products);
        }

        $filename = 'products_export_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nom', 'Prix', 'Stock', 'Catégorie']);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->price,
                    $product->stock,
                    $product->category->name ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}