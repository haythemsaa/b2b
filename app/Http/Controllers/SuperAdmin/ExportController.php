<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function tenants(Request $request)
    {
        $format = $request->get('format', 'csv');

        $tenants = Tenant::withCount(['users', 'products', 'orders'])
            ->with(['users' => function($query) {
                $query->latest('created_at')->take(1);
            }])
            ->get();

        $data = $tenants->map(function($tenant) {
            return [
                'ID' => $tenant->id,
                'Nom' => $tenant->name,
                'Slug' => $tenant->slug,
                'Email' => $tenant->email,
                'Domaine' => $tenant->domain,
                'Téléphone' => $tenant->phone,
                'Adresse' => $tenant->address,
                'Ville' => $tenant->city,
                'Pays' => $tenant->country,
                'Plan' => ucfirst($tenant->plan),
                'Max Utilisateurs' => $tenant->max_users,
                'Utilisateurs Actuels' => $tenant->users_count,
                'Max Produits' => $tenant->max_products,
                'Produits Actuels' => $tenant->products_count,
                'Commandes' => $tenant->orders_count,
                'Tarif Mensuel' => $tenant->monthly_fee,
                'Modules Activés' => implode(', ', $tenant->enabled_modules ?? []),
                'Actif' => $tenant->is_active ? 'Oui' : 'Non',
                'Période d\'Essai' => $tenant->trial_ends_at?->format('d/m/Y'),
                'Créé le' => $tenant->created_at->format('d/m/Y H:i'),
                'Dernière Connexion' => $tenant->users->first()?->updated_at?->format('d/m/Y H:i'),
            ];
        });

        return $this->downloadData($data, "tenants_export_" . now()->format('Y-m-d'), $format);
    }

    public function tenantDetails(Request $request, Tenant $tenant)
    {
        $format = $request->get('format', 'csv');

        $users = $tenant->users()->withCount('orders')->get();
        $products = $tenant->products()->withCount('orderItems')->get();
        $orders = $tenant->orders()->with(['user', 'orderItems.product'])->get();

        // Export détaillé du tenant
        $tenantData = [
            'tenant_info' => [
                [
                    'Nom' => $tenant->name,
                    'Email' => $tenant->email,
                    'Plan' => ucfirst($tenant->plan),
                    'Créé le' => $tenant->created_at->format('d/m/Y'),
                    'Statut' => $tenant->is_active ? 'Actif' : 'Inactif',
                    'Revenus Mensuels' => $tenant->monthly_fee . '€',
                ]
            ],
            'users' => $users->map(function($user) {
                return [
                    'Nom' => $user->name,
                    'Email' => $user->email,
                    'Rôle' => $user->role,
                    'Société' => $user->company_name,
                    'Téléphone' => $user->phone,
                    'Ville' => $user->city,
                    'Commandes' => $user->orders_count,
                    'Actif' => $user->is_active ? 'Oui' : 'Non',
                    'Créé le' => $user->created_at->format('d/m/Y'),
                ];
            }),
            'products' => $products->map(function($product) {
                return [
                    'Nom' => $product->name,
                    'SKU' => $product->sku,
                    'Prix de Base' => $product->base_price,
                    'Prix Actuel' => $product->price,
                    'Stock' => $product->stock_quantity,
                    'Commandes' => $product->order_items_count,
                    'Catégorie' => $product->category?->name,
                    'Actif' => $product->is_active ? 'Oui' : 'Non',
                ];
            }),
            'orders' => $orders->map(function($order) {
                return [
                    'Numéro' => $order->order_number,
                    'Client' => $order->user->name,
                    'Date' => $order->created_at->format('d/m/Y'),
                    'Statut' => $order->status,
                    'Total' => $order->total_amount,
                    'Articles' => $order->orderItems->count(),
                ];
            })
        ];

        if ($format === 'json') {
            return Response::json($tenantData, 200, [
                'Content-Disposition' => 'attachment; filename="tenant_' . $tenant->slug . '_export.json"'
            ]);
        }

        // Pour CSV, on exporte chaque section séparément
        return $this->downloadMultipleSheets($tenantData, "tenant_" . $tenant->slug . "_export", $format);
    }

    public function analytics(Request $request)
    {
        $format = $request->get('format', 'csv');

        // Analytics sur 12 mois
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();

            $monthlyData[] = [
                'Mois' => $date->format('M Y'),
                'Nouveaux Tenants' => Tenant::whereBetween('created_at', [$startDate, $endDate])->count(),
                'Tenants Actifs' => Tenant::where('created_at', '<=', $endDate)->where('is_active', true)->count(),
                'Revenus' => Tenant::where('created_at', '<=', $endDate)->where('is_active', true)->sum('monthly_fee'),
                'Nouveaux Utilisateurs' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
                'Nouvelles Commandes' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            ];
        }

        return $this->downloadData(collect($monthlyData), "analytics_export_" . now()->format('Y-m-d'), $format);
    }

    public function financialReport(Request $request)
    {
        $format = $request->get('format', 'csv');

        $tenants = Tenant::where('is_active', true)
            ->withCount('users', 'products', 'orders')
            ->get();

        $data = $tenants->map(function($tenant) {
            $annualRevenue = $tenant->monthly_fee * 12;
            $estimatedLTV = $tenant->monthly_fee * 24; // Estimation 2 ans

            return [
                'Tenant' => $tenant->name,
                'Plan' => ucfirst($tenant->plan),
                'Tarif Mensuel' => $tenant->monthly_fee . '€',
                'Revenus Annuels' => $annualRevenue . '€',
                'LTV Estimée' => $estimatedLTV . '€',
                'Utilisateurs' => $tenant->users_count . '/' . $tenant->max_users,
                'Produits' => $tenant->products_count . '/' . $tenant->max_products,
                'Taux Utilisation Users' => round(($tenant->users_count / $tenant->max_users) * 100, 1) . '%',
                'Taux Utilisation Products' => round(($tenant->products_count / $tenant->max_products) * 100, 1) . '%',
                'Commandes Total' => $tenant->orders_count,
                'Début Contrat' => $tenant->created_at->format('d/m/Y'),
                'Durée (mois)' => $tenant->created_at->diffInMonths(now()),
            ];
        });

        // Ajouter les totaux
        $data->push([
            'Tenant' => 'TOTAL',
            'Plan' => '',
            'Tarif Mensuel' => $tenants->sum('monthly_fee') . '€',
            'Revenus Annuels' => ($tenants->sum('monthly_fee') * 12) . '€',
            'LTV Estimée' => ($tenants->sum('monthly_fee') * 24) . '€',
            'Utilisateurs' => $tenants->sum('users_count'),
            'Produits' => $tenants->sum('products_count'),
            'Taux Utilisation Users' => '',
            'Taux Utilisation Products' => '',
            'Commandes Total' => $tenants->sum('orders_count'),
            'Début Contrat' => '',
            'Durée (mois)' => '',
        ]);

        return $this->downloadData($data, "financial_report_" . now()->format('Y-m-d'), $format);
    }

    private function downloadData($data, $filename, $format)
    {
        if ($format === 'json') {
            return Response::json($data, 200, [
                'Content-Disposition' => 'attachment; filename="' . $filename . '.json"'
            ]);
        }

        // CSV par défaut
        $csv = $this->arrayToCsv($data);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ]);
    }

    private function downloadMultipleSheets($data, $filename, $format)
    {
        if ($format === 'json') {
            return Response::json($data, 200, [
                'Content-Disposition' => 'attachment; filename="' . $filename . '.json"'
            ]);
        }

        // Pour CSV, créer un fichier avec toutes les données
        $csvContent = '';
        foreach ($data as $sheetName => $sheetData) {
            $csvContent .= strtoupper($sheetName) . "\n";
            $csvContent .= $this->arrayToCsv($sheetData) . "\n\n";
        }

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ]);
    }

    private function arrayToCsv($data)
    {
        if ($data->isEmpty()) {
            return '';
        }

        $output = fopen('php://temp', 'w');

        // Headers
        $headers = array_keys($data->first());
        fputcsv($output, $headers, ';');

        // Data
        foreach ($data as $row) {
            fputcsv($output, array_values($row), ';');
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}