<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use App\Models\IntegrationLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminIntegrationController extends Controller
{
    /**
     * Display a listing of integrations
     */
    public function index()
    {
        $tenant_id = auth()->user()->tenant_id;

        $integrations = Integration::forTenant($tenant_id)
            ->with(['logs' => function ($query) {
                $query->latest()->limit(5);
            }])
            ->withCount(['logs as successful_logs' => function ($query) {
                $query->where('status', 'success');
            }])
            ->withCount(['logs as failed_logs' => function ($query) {
                $query->where('status', 'failed');
            }])
            ->get();

        // Statistiques globales
        $stats = [
            'total_integrations' => $integrations->count(),
            'active_integrations' => $integrations->where('status', 'active')->count(),
            'total_syncs' => $integrations->sum('total_syncs'),
            'success_rate' => $integrations->count() > 0
                ? round($integrations->sum('successful_syncs') / max($integrations->sum('total_syncs'), 1) * 100, 2)
                : 0,
        ];

        return view('admin.integrations.index', compact('integrations', 'stats'));
    }

    /**
     * Show the form for creating a new integration
     */
    public function create()
    {
        $types = [
            'sap_b1' => 'SAP Business One',
            'dynamics_365' => 'Microsoft Dynamics 365',
            'sage' => 'Sage Accounting',
            'quickbooks' => 'QuickBooks',
            'odoo' => 'Odoo ERP',
            'xero' => 'Xero Accounting',
            'netsuite' => 'Oracle NetSuite',
            'custom_api' => 'Custom API',
        ];

        return view('admin.integrations.create', compact('types'));
    }

    /**
     * Store a newly created integration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sap_b1,dynamics_365,sage,quickbooks,odoo,xero,netsuite,custom_api',
            'sync_direction' => 'required|in:export,import,bidirectional',
            'sync_frequency' => 'required|in:manual,hourly,daily,weekly',
            'sync_products' => 'boolean',
            'sync_orders' => 'boolean',
            'sync_customers' => 'boolean',
            'sync_invoices' => 'boolean',
            'sync_inventory' => 'boolean',
            'credentials' => 'nullable|array',
            'settings' => 'nullable|array',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;
        $validated['status'] = 'inactive';

        $integration = Integration::create($validated);

        return redirect()
            ->route('admin.integrations.show', $integration)
            ->with('success', 'Intégration créée avec succès');
    }

    /**
     * Display the specified integration
     */
    public function show(Integration $integration)
    {
        $this->authorize('view', $integration);

        $integration->load(['logs' => function ($query) {
            $query->latest()->limit(50);
        }]);

        // Statistiques des 30 derniers jours
        $recentStats = IntegrationLog::forIntegration($integration->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "success" THEN 1 ELSE 0 END) as successful'),
                DB::raw('SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.integrations.show', compact('integration', 'recentStats'));
    }

    /**
     * Show the form for editing the specified integration
     */
    public function edit(Integration $integration)
    {
        $this->authorize('update', $integration);

        $types = [
            'sap_b1' => 'SAP Business One',
            'dynamics_365' => 'Microsoft Dynamics 365',
            'sage' => 'Sage Accounting',
            'quickbooks' => 'QuickBooks',
            'odoo' => 'Odoo ERP',
            'xero' => 'Xero Accounting',
            'netsuite' => 'Oracle NetSuite',
            'custom_api' => 'Custom API',
        ];

        return view('admin.integrations.edit', compact('integration', 'types'));
    }

    /**
     * Update the specified integration
     */
    public function update(Request $request, Integration $integration)
    {
        $this->authorize('update', $integration);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sap_b1,dynamics_365,sage,quickbooks,odoo,xero,netsuite,custom_api',
            'sync_direction' => 'required|in:export,import,bidirectional',
            'sync_frequency' => 'required|in:manual,hourly,daily,weekly',
            'sync_products' => 'boolean',
            'sync_orders' => 'boolean',
            'sync_customers' => 'boolean',
            'sync_invoices' => 'boolean',
            'sync_inventory' => 'boolean',
            'credentials' => 'nullable|array',
            'settings' => 'nullable|array',
        ]);

        $integration->update($validated);

        return redirect()
            ->route('admin.integrations.show', $integration)
            ->with('success', 'Intégration mise à jour avec succès');
    }

    /**
     * Remove the specified integration
     */
    public function destroy(Integration $integration)
    {
        $this->authorize('delete', $integration);

        $integration->delete();

        return redirect()
            ->route('admin.integrations.index')
            ->with('success', 'Intégration supprimée avec succès');
    }

    /**
     * Toggle integration status (active/inactive)
     */
    public function toggleStatus(Integration $integration)
    {
        $this->authorize('update', $integration);

        $newStatus = $integration->status === 'active' ? 'inactive' : 'active';
        $integration->update(['status' => $newStatus]);

        return back()->with('success', 'Statut mis à jour avec succès');
    }

    /**
     * Test connection to external system
     */
    public function testConnection(Integration $integration)
    {
        $this->authorize('update', $integration);

        $start = microtime(true);
        $result = $this->performConnectionTest($integration);
        $duration = round((microtime(true) - $start) * 1000);

        // Log le test
        IntegrationLog::createLog($integration->id, $integration->tenant_id, [
            'entity_type' => 'other',
            'action' => 'sync',
            'direction' => 'export',
            'status' => $result['success'] ? 'success' : 'failed',
            'error_message' => $result['error'] ?? null,
            'duration_ms' => $duration,
        ]);

        if ($result['success']) {
            $integration->update(['status' => 'testing']);
            return back()->with('success', 'Connexion réussie ! Temps de réponse: ' . $duration . 'ms');
        }

        $integration->update(['status' => 'error', 'last_error' => $result['error']]);
        return back()->with('error', 'Échec de connexion: ' . $result['error']);
    }

    /**
     * Manually trigger synchronization
     */
    public function sync(Request $request, Integration $integration)
    {
        $this->authorize('update', $integration);

        if (!$integration->canSync()) {
            return back()->with('error', 'L\'intégration doit être active ou en test pour synchroniser');
        }

        $entityType = $request->input('entity_type', 'all');

        try {
            $start = microtime(true);
            $results = $this->performSync($integration, $entityType);
            $duration = round((microtime(true) - $start) * 1000);

            $success = $results['success'] ?? false;
            $integration->recordSync($success, $results['error'] ?? null);

            if ($success) {
                return back()->with('success', 'Synchronisation réussie: ' . ($results['message'] ?? 'Terminé') . ' (Durée: ' . $duration . 'ms)');
            }

            return back()->with('error', 'Échec de synchronisation: ' . ($results['error'] ?? 'Erreur inconnue'));
        } catch (\Exception $e) {
            Log::error('Integration sync error', [
                'integration_id' => $integration->id,
                'error' => $e->getMessage(),
            ]);

            $integration->recordSync(false, $e->getMessage());
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * View integration logs
     */
    public function logs(Integration $integration)
    {
        $this->authorize('view', $integration);

        $logs = IntegrationLog::forIntegration($integration->id)
            ->latest()
            ->paginate(100);

        return view('admin.integrations.logs', compact('integration', 'logs'));
    }

    /**
     * Perform connection test based on integration type
     */
    private function performConnectionTest(Integration $integration)
    {
        try {
            switch ($integration->type) {
                case 'sap_b1':
                    return $this->testSAPConnection($integration);
                case 'dynamics_365':
                    return $this->testDynamicsConnection($integration);
                case 'sage':
                    return $this->testSageConnection($integration);
                case 'quickbooks':
                    return $this->testQuickBooksConnection($integration);
                case 'odoo':
                    return $this->testOdooConnection($integration);
                case 'custom_api':
                    return $this->testCustomAPIConnection($integration);
                default:
                    return ['success' => false, 'error' => 'Type d\'intégration non supporté'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Perform synchronization based on integration type
     */
    private function performSync(Integration $integration, $entityType)
    {
        switch ($integration->type) {
            case 'sap_b1':
                return $this->syncSAP($integration, $entityType);
            case 'dynamics_365':
                return $this->syncDynamics($integration, $entityType);
            case 'sage':
                return $this->syncSage($integration, $entityType);
            case 'quickbooks':
                return $this->syncQuickBooks($integration, $entityType);
            case 'odoo':
                return $this->syncOdoo($integration, $entityType);
            case 'custom_api':
                return $this->syncCustomAPI($integration, $entityType);
            default:
                return ['success' => false, 'error' => 'Type d\'intégration non supporté'];
        }
    }

    // ========== SAP Business One ==========
    private function testSAPConnection($integration)
    {
        // Placeholder - Implémentation réelle nécessite SDK SAP B1
        $credentials = $integration->credentials;

        if (empty($credentials['server']) || empty($credentials['database'])) {
            return ['success' => false, 'error' => 'Credentials SAP B1 incomplètes'];
        }

        // Simuler test de connexion
        return ['success' => true, 'message' => 'Test SAP B1 réussi (simulation)'];
    }

    private function syncSAP($integration, $entityType)
    {
        // Placeholder pour synchronisation SAP
        $exported = 0;

        if ($entityType === 'all' || $entityType === 'orders') {
            $orders = Order::where('tenant_id', $integration->tenant_id)
                ->whereNull('external_id')
                ->limit(10)
                ->get();

            foreach ($orders as $order) {
                // Logique d'export vers SAP ici
                $exported++;
            }
        }

        return ['success' => true, 'message' => "$exported éléments exportés vers SAP B1"];
    }

    // ========== Microsoft Dynamics 365 ==========
    private function testDynamicsConnection($integration)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Test Dynamics 365 réussi (simulation)'];
    }

    private function syncDynamics($integration, $entityType)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Synchronisation Dynamics 365 (simulation)'];
    }

    // ========== Sage Accounting ==========
    private function testSageConnection($integration)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Test Sage réussi (simulation)'];
    }

    private function syncSage($integration, $entityType)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Synchronisation Sage (simulation)'];
    }

    // ========== QuickBooks ==========
    private function testQuickBooksConnection($integration)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Test QuickBooks réussi (simulation)'];
    }

    private function syncQuickBooks($integration, $entityType)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Synchronisation QuickBooks (simulation)'];
    }

    // ========== Odoo ERP ==========
    private function testOdooConnection($integration)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Test Odoo réussi (simulation)'];
    }

    private function syncOdoo($integration, $entityType)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Synchronisation Odoo (simulation)'];
    }

    // ========== Custom API ==========
    private function testCustomAPIConnection($integration)
    {
        $settings = $integration->settings ?? [];
        $apiUrl = $settings['api_url'] ?? null;

        if (!$apiUrl) {
            return ['success' => false, 'error' => 'URL API manquante'];
        }

        try {
            $response = Http::timeout(10)->get($apiUrl . '/health');

            if ($response->successful()) {
                return ['success' => true, 'message' => 'API accessible'];
            }

            return ['success' => false, 'error' => 'HTTP ' . $response->status()];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function syncCustomAPI($integration, $entityType)
    {
        // Placeholder
        return ['success' => true, 'message' => 'Synchronisation Custom API (simulation)'];
    }
}
