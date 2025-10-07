<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('is_active', true)->count();
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $monthlyRevenue = Tenant::where('is_active', true)->sum('monthly_fee');

        // Croissance (comparaison avec le mois dernier)
        $lastMonthTenants = Tenant::where('created_at', '<', Carbon::now()->startOfMonth())->count();
        $tenantGrowth = $totalTenants - $lastMonthTenants;

        // Top tenants par revenus
        $topTenants = Tenant::where('is_active', true)
            ->withCount(['users', 'products'])
            ->orderBy('monthly_fee', 'desc')
            ->limit(5)
            ->get();

        // Statistiques par plan
        $planStats = Tenant::select('plan', DB::raw('COUNT(*) as count'), DB::raw('SUM(monthly_fee) as revenue'))
            ->where('is_active', true)
            ->groupBy('plan')
            ->get();

        // Tenants récents
        $recentTenants = Tenant::with('users')
            ->latest()
            ->limit(10)
            ->get();

        // Quotas utilisés (moyennes)
        $quotaStats = [
            'users_avg' => Tenant::whereHas('users')
                ->withCount('users')
                ->get()
                ->average(function ($tenant) {
                    return ($tenant->users_count / $tenant->max_users) * 100;
                }),
            'products_avg' => Tenant::whereHas('products')
                ->withCount('products')
                ->get()
                ->average(function ($tenant) {
                    return ($tenant->products_count / $tenant->max_products) * 100;
                })
        ];

        // Données pour le graphique des revenus (12 derniers mois)
        $revenueChart = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyData = Tenant::where('created_at', '<=', $date->endOfMonth())
                ->where('is_active', true)
                ->sum('monthly_fee');

            $revenueChart[] = [
                'month' => $date->format('M Y'),
                'revenue' => $monthlyData
            ];
        }

        // Alertes système
        $alerts = [];

        // Tenants avec quotas élevés
        $highQuotaTenants = Tenant::with('users', 'products')
            ->get()
            ->filter(function ($tenant) {
                $userQuota = ($tenant->users->count() / $tenant->max_users) * 100;
                $productQuota = ($tenant->products->count() / $tenant->max_products) * 100;
                return $userQuota > 80 || $productQuota > 80;
            });

        if ($highQuotaTenants->count() > 0) {
            $alerts[] = [
                'type' => 'warning',
                'message' => $highQuotaTenants->count() . ' tenant(s) proche(s) de leur quota',
                'action' => 'Voir les tenants'
            ];
        }

        // Tenants inactifs depuis longtemps
        $inactiveTenants = Tenant::where('is_active', false)
            ->where('updated_at', '<', Carbon::now()->subDays(30))
            ->count();

        if ($inactiveTenants > 0) {
            $alerts[] = [
                'type' => 'info',
                'message' => $inactiveTenants . ' tenant(s) inactif(s) depuis plus de 30 jours',
                'action' => 'Nettoyer'
            ];
        }

        return view('superadmin.dashboard', compact(
            'totalTenants',
            'activeTenants',
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'monthlyRevenue',
            'tenantGrowth',
            'topTenants',
            'planStats',
            'recentTenants',
            'quotaStats',
            'revenueChart',
            'alerts'
        ));
    }

    public function analytics()
    {
        // Données analytiques plus détaillées
        $analytics = [
            'daily_signups' => $this->getDailySignups(),
            'churn_rate' => $this->getChurnRate(),
            'ltv' => $this->getLifetimeValue(),
            'conversion_funnel' => $this->getConversionFunnel()
        ];

        return view('superadmin.analytics', compact('analytics'));
    }

    private function getDailySignups()
    {
        return Tenant::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as signups')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();
    }

    private function getChurnRate()
    {
        $totalTenants = Tenant::count();
        $churnedTenants = Tenant::onlyTrashed()
            ->where('deleted_at', '>=', Carbon::now()->subMonth())
            ->count();

        return $totalTenants > 0 ? ($churnedTenants / $totalTenants) * 100 : 0;
    }

    private function getLifetimeValue()
    {
        return Tenant::where('is_active', true)
            ->avg('monthly_fee') * 12; // Estimation LTV = prix moyen * 12 mois
    }

    private function getConversionFunnel()
    {
        return [
            'trials' => Tenant::whereNotNull('trial_ends_at')->count(),
            'converted' => Tenant::whereNull('trial_ends_at')->where('is_active', true)->count(),
            'churned' => Tenant::onlyTrashed()->count()
        ];
    }
}