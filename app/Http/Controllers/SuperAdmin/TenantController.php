<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::withTrashed();

        // Filtres
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('plan') && $request->get('plan') !== '') {
            $query->where('plan', $request->get('plan'));
        }

        if ($request->has('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_active', true)->whereNull('deleted_at');
            } elseif ($status === 'inactive') {
                $query->where('is_active', false)->whereNull('deleted_at');
            } elseif ($status === 'deleted') {
                $query->onlyTrashed();
            }
        }

        $tenants = $query->latest()->paginate(15);

        // Statistiques pour le dashboard
        $stats = [
            'total_tenants' => Tenant::count(),
            'active_tenants' => Tenant::where('is_active', true)->count(),
            'inactive_tenants' => Tenant::where('is_active', false)->count(),
            'deleted_tenants' => Tenant::onlyTrashed()->count(),
            'total_users' => \DB::table('users')->count(),
            'total_products' => \DB::table('products')->count(),
            'total_orders' => \DB::table('orders')->count(),
            'monthly_revenue' => Tenant::where('is_active', true)->sum('monthly_fee')
        ];

        return view('superadmin.tenants.index', compact('tenants', 'stats'));
    }

    public function create()
    {
        return view('superadmin.tenants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'domain' => 'nullable|string|unique:tenants,domain',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'required|string',
            'plan' => 'required|in:starter,pro,enterprise',
            'max_users' => 'required|integer|min:1',
            'max_products' => 'required|integer|min:1',
            'monthly_fee' => 'required|numeric|min:0',
            'enabled_modules' => 'array',
            'trial_ends_at' => 'nullable|date|after:today',
        ]);

        // Ajouter les valeurs par défaut si nécessaire
        if (!isset($validated['country']) || empty($validated['country'])) {
            $validated['country'] = 'TN';
        }

        // Générer un slug unique
        $validated['slug'] = $this->generateUniqueSlug($validated['name']);

        $tenant = Tenant::create($validated);

        return redirect()->route('superadmin.tenants.show', $tenant)
                        ->with('success', 'Tenant créé avec succès!');
    }

    public function show(Tenant $tenant)
    {
        $tenant->loadCount(['users', 'products', 'orders']);

        // Statistiques du tenant
        $stats = [
            'users_count' => $tenant->users_count,
            'products_count' => $tenant->products_count,
            'orders_count' => $tenant->orders_count,
            'quota_users_used' => round(($tenant->users_count / $tenant->max_users) * 100, 1),
            'quota_products_used' => round(($tenant->products_count / $tenant->max_products) * 100, 1),
            'last_login' => $tenant->users()->latest('updated_at')->first()?->updated_at,
        ];

        return view('superadmin.tenants.show', compact('tenant', 'stats'));
    }

    public function edit(Tenant $tenant)
    {
        return view('superadmin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email,' . $tenant->id,
            'domain' => 'nullable|string|unique:tenants,domain,' . $tenant->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'required|string',
            'plan' => 'required|in:starter,pro,enterprise',
            'max_users' => 'required|integer|min:1',
            'max_products' => 'required|integer|min:1',
            'monthly_fee' => 'required|numeric|min:0',
            'enabled_modules' => 'array',
            'is_active' => 'boolean',
            'trial_ends_at' => 'nullable|date',
        ]);

        $tenant->update($validated);

        return redirect()->route('superadmin.tenants.show', $tenant)
                        ->with('success', 'Tenant mis à jour avec succès!');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return redirect()->route('superadmin.tenants.index')
                        ->with('success', 'Tenant supprimé avec succès!');
    }

    public function suspend(Tenant $tenant)
    {
        $tenant->update(['is_active' => false]);

        return back()->with('success', 'Tenant suspendu avec succès!');
    }

    public function activate(Tenant $tenant)
    {
        $tenant->update(['is_active' => true]);

        return back()->with('success', 'Tenant activé avec succès!');
    }

    public function restore($id)
    {
        $tenant = Tenant::onlyTrashed()->findOrFail($id);
        $tenant->restore();

        return back()->with('success', 'Tenant restauré avec succès!');
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Tenant::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
