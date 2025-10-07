<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pour les routes super-admin, login, logout, pas besoin de tenant
        if ($request->is('superadmin/*') || $request->is('login') || $request->is('logout')) {
            return $next($request);
        }

        // Pour les routes d'authentification, laisser passer sans tenant
        if ($request->is('forgot-password') || $request->is('password/*')) {
            return $next($request);
        }

        $tenant = $this->resolveTenant($request);

        // Si pas de tenant trouvé, utiliser le tenant par défaut pour les utilisateurs connectés
        if (!$tenant && Auth::check()) {
            $tenant = Tenant::where('slug', 'demo')->first();
        }

        if (!$tenant) {
            // Si toujours pas de tenant, rediriger vers login
            return redirect('/login');
        }

        // Vérifier que le tenant est actif seulement si c'est nécessaire
        if (!$tenant->is_active && !$request->is('login')) {
            return redirect('/login')->with('error', 'Tenant suspendu');
        }

        // Stocker le tenant actuel dans le container
        app()->instance('current.tenant', $tenant);

        // Ajouter un scope global pour toutes les requêtes sauf les super-admins
        if (Auth::check() && Auth::user()->tenant_id !== null) {
            $this->addGlobalScope($tenant);
        }

        return $next($request);
    }

    private function resolveTenant(Request $request): ?Tenant
    {
        // 1. Vérifier si c'est un domaine personnalisé
        $host = $request->getHost();
        if ($host !== '127.0.0.1' && $host !== 'localhost') {
            $tenant = Tenant::where('domain', $host)->first();
            if ($tenant) return $tenant;
        }

        // 2. Vérifier le slug dans l'URL (/t/{slug}/...)
        if ($request->is('t/*')) {
            $slug = $request->segment(2);
            return Tenant::where('slug', $slug)->first();
        }

        // 3. Si utilisateur connecté, prendre son tenant
        if (Auth::check() && Auth::user()->tenant_id) {
            return Tenant::find(Auth::user()->tenant_id);
        }

        // 4. Tenant par défaut (pour développement)
        return Tenant::where('slug', 'demo')->first();
    }

    private function addGlobalScope(Tenant $tenant): void
    {
        // Ajouter automatiquement tenant_id à toutes les requêtes Eloquent
        $models = [
            \App\Models\User::class,
            \App\Models\Category::class,
            \App\Models\Product::class,
            \App\Models\CustomerGroup::class,
            \App\Models\CustomPrice::class,
            \App\Models\Order::class,
            \App\Models\OrderItem::class,
            \App\Models\Message::class,
            \App\Models\Promotion::class,
            \App\Models\ProductReturn::class,
        ];

        foreach ($models as $model) {
            if (class_exists($model)) {
                $model::addGlobalScope('tenant', function ($builder) use ($tenant, $model) {
                    // Obtenir le nom de la table du modèle
                    $table = (new $model)->getTable();
                    $builder->where($table . '.tenant_id', $tenant->id);
                });
            }
        }
    }
}
