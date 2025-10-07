<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Protection contre le clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Protection contre le MIME-sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Protection XSS pour navigateurs anciens
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Politique de référent stricte
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy - Désactiver fonctionnalités non utilisées
        $response->headers->set('Permissions-Policy',
            'geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), gyroscope=()'
        );

        // Content Security Policy (CSP)
        if (!app()->environment('local')) {
            $response->headers->set('Content-Security-Policy',
                "default-src 'self'; " .
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com; " .
                "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com; " .
                "img-src 'self' data: https: blob:; " .
                "font-src 'self' data: https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.gstatic.com; " .
                "connect-src 'self' https://api.exchangerate-api.com; " .
                "frame-ancestors 'self'; " .
                "base-uri 'self'; " .
                "form-action 'self';"
            );
        }

        // Strict Transport Security (HTTPS uniquement)
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Supprimer le header X-Powered-By si présent
        $response->headers->remove('X-Powered-By');

        // Ajouter header Server personnalisé
        $response->headers->set('Server', 'B2B-Platform');

        return $response;
    }
}
