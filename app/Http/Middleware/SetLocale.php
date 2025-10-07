<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = null;

        if (auth()->check()) {
            $locale = auth()->user()->preferred_language;
        }

        if (!$locale) {
            $locale = Session::get('locale', config('app.locale'));
        }

        if (!in_array($locale, config('app.supported_locales'))) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}