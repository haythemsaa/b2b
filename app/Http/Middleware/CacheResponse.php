<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request and cache the response
     */
    public function handle(Request $request, Closure $next, int $ttl = 3600): Response
    {
        // Only cache GET requests
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        // Don't cache authenticated user-specific pages
        if (auth()->check() && !$this->isCacheable($request)) {
            return $next($request);
        }

        // Generate cache key from request
        $cacheKey = $this->generateCacheKey($request);

        // Return cached response if exists
        if (Cache::has($cacheKey)) {
            $cachedResponse = Cache::get($cacheKey);
            return response($cachedResponse['content'], $cachedResponse['status'])
                ->withHeaders($cachedResponse['headers'])
                ->header('X-Cache', 'HIT');
        }

        // Get fresh response
        $response = $next($request);

        // Cache successful responses only
        if ($response->status() === 200) {
            Cache::put($cacheKey, [
                'content' => $response->getContent(),
                'status' => $response->status(),
                'headers' => $this->getHeaders($response),
            ], $ttl);

            $response->header('X-Cache', 'MISS');
        }

        return $response;
    }

    /**
     * Generate unique cache key for request
     */
    protected function generateCacheKey(Request $request): string
    {
        $key = 'response_' . md5(
            $request->fullUrl() .
            json_encode($request->query()) .
            ($request->user() ? $request->user()->id : 'guest')
        );

        return $key;
    }

    /**
     * Check if request is cacheable
     */
    protected function isCacheable(Request $request): bool
    {
        // List of cacheable patterns
        $cacheablePatterns = [
            'products',
            'categories',
            'api/products',
        ];

        foreach ($cacheablePatterns as $pattern) {
            if ($request->is($pattern . '*')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get headers to cache
     */
    protected function getHeaders(Response $response): array
    {
        return [
            'Content-Type' => $response->headers->get('Content-Type'),
        ];
    }
}
