<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache duration in seconds (default: 1 hour)
     */
    protected int $defaultTtl = 3600;

    /**
     * Cache key prefix
     */
    protected string $prefix = 'b2b_';

    /**
     * Get cached data or execute callback
     */
    public function remember(string $key, callable $callback, ?int $ttl = null)
    {
        $cacheKey = $this->getCacheKey($key);
        $ttl = $ttl ?? $this->defaultTtl;

        return Cache::remember($cacheKey, $ttl, $callback);
    }

    /**
     * Get cached data with tags
     */
    public function rememberWithTags(array $tags, string $key, callable $callback, ?int $ttl = null)
    {
        $cacheKey = $this->getCacheKey($key);
        $ttl = $ttl ?? $this->defaultTtl;

        return Cache::tags($tags)->remember($cacheKey, $ttl, $callback);
    }

    /**
     * Put data in cache
     */
    public function put(string $key, $value, ?int $ttl = null): bool
    {
        $cacheKey = $this->getCacheKey($key);
        $ttl = $ttl ?? $this->defaultTtl;

        return Cache::put($cacheKey, $value, $ttl);
    }

    /**
     * Get data from cache
     */
    public function get(string $key, $default = null)
    {
        $cacheKey = $this->getCacheKey($key);
        return Cache::get($cacheKey, $default);
    }

    /**
     * Check if key exists in cache
     */
    public function has(string $key): bool
    {
        $cacheKey = $this->getCacheKey($key);
        return Cache::has($cacheKey);
    }

    /**
     * Forget cached data
     */
    public function forget(string $key): bool
    {
        $cacheKey = $this->getCacheKey($key);
        return Cache::forget($cacheKey);
    }

    /**
     * Flush cache by tags
     */
    public function flushTags(array $tags): bool
    {
        return Cache::tags($tags)->flush();
    }

    /**
     * Flush all cache
     */
    public function flush(): bool
    {
        return Cache::flush();
    }

    /**
     * Get full cache key with prefix
     */
    protected function getCacheKey(string $key): string
    {
        return $this->prefix . $key;
    }

    /**
     * Cache products list
     */
    public function cacheProducts(int $tenantId, callable $callback)
    {
        return $this->rememberWithTags(
            ['products', "tenant_{$tenantId}"],
            "products_tenant_{$tenantId}",
            $callback,
            3600 // 1 hour
        );
    }

    /**
     * Cache user's custom prices
     */
    public function cacheUserPrices(int $userId, callable $callback)
    {
        return $this->rememberWithTags(
            ['prices', "user_{$userId}"],
            "prices_user_{$userId}",
            $callback,
            1800 // 30 minutes
        );
    }

    /**
     * Cache categories
     */
    public function cacheCategories(callable $callback)
    {
        return $this->rememberWithTags(
            ['categories'],
            'categories_list',
            $callback,
            7200 // 2 hours
        );
    }

    /**
     * Cache customer groups
     */
    public function cacheCustomerGroups(int $tenantId, callable $callback)
    {
        return $this->rememberWithTags(
            ['customer_groups', "tenant_{$tenantId}"],
            "customer_groups_tenant_{$tenantId}",
            $callback,
            3600 // 1 hour
        );
    }

    /**
     * Clear product cache
     */
    public function clearProductCache(int $tenantId): bool
    {
        return $this->flushTags(['products', "tenant_{$tenantId}"]);
    }

    /**
     * Clear user price cache
     */
    public function clearUserPriceCache(int $userId): bool
    {
        return $this->flushTags(['prices', "user_{$userId}"]);
    }

    /**
     * Clear category cache
     */
    public function clearCategoryCache(): bool
    {
        return $this->flushTags(['categories']);
    }

    /**
     * Clear all tenant cache
     */
    public function clearTenantCache(int $tenantId): bool
    {
        return $this->flushTags(["tenant_{$tenantId}"]);
    }

    /**
     * Get cache statistics
     */
    public function getStats(): array
    {
        // This is a basic implementation
        // For detailed stats, you'd need Redis or Memcached
        return [
            'driver' => config('cache.default'),
            'prefix' => $this->prefix,
            'default_ttl' => $this->defaultTtl,
        ];
    }
}
