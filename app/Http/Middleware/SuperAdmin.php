<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Vérifier que l'utilisateur a le rôle superadmin
        // Pour l'instant, on utilise l'email comme identifiant super-admin
        // Plus tard, on pourra ajouter un champ 'is_superadmin' ou utiliser Spatie Permissions
        $superadminEmails = [
            'admin@b2bplatform.com',
            'superadmin@b2b.com',
            'support@b2bplatform.com'
        ];

        if (!in_array($user->email, $superadminEmails)) {
            abort(403, 'Accès réservé aux super-administrateurs');
        }

        return $next($request);
    }
}