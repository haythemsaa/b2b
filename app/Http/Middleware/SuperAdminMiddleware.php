<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Vérifier si l'utilisateur est un super admin
        if (auth()->user()->role !== 'superadmin' && auth()->user()->email !== 'admin@b2bplatform.com') {
            abort(403, 'Accès non autorisé. Vous devez être super administrateur.');
        }

        return $next($request);
    }
}
