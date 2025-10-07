<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;

class CacheClear extends Command
{
    protected $signature = 'b2b:cache-clear
                            {type? : Cache type to clear (all, products, categories, prices, tenant)}
                            {--tenant= : Tenant ID for tenant-specific cache clearing}';

    protected $description = 'Clear B2B Platform cache with granular control';

    protected CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        parent::__construct();
        $this->cacheService = $cacheService;
    }

    public function handle()
    {
        $type = $this->argument('type') ?? 'all';
        $tenantId = $this->option('tenant');

        $this->info("🔄 Clearing {$type} cache...");

        switch ($type) {
            case 'all':
                $this->cacheService->flush();
                $this->info('✅ All cache cleared successfully!');
                break;

            case 'products':
                if ($tenantId) {
                    $this->cacheService->clearProductCache((int)$tenantId);
                    $this->info("✅ Products cache cleared for tenant {$tenantId}");
                } else {
                    $this->error('❌ Please specify --tenant option for products cache');
                    return 1;
                }
                break;

            case 'categories':
                $this->cacheService->clearCategoryCache();
                $this->info('✅ Categories cache cleared successfully!');
                break;

            case 'prices':
                $this->cacheService->flushTags(['prices']);
                $this->info('✅ Prices cache cleared successfully!');
                break;

            case 'tenant':
                if ($tenantId) {
                    $this->cacheService->clearTenantCache((int)$tenantId);
                    $this->info("✅ All cache cleared for tenant {$tenantId}");
                } else {
                    $this->error('❌ Please specify --tenant option');
                    return 1;
                }
                break;

            default:
                $this->error("❌ Unknown cache type: {$type}");
                $this->line('Available types: all, products, categories, prices, tenant');
                return 1;
        }

        // Show cache stats
        $stats = $this->cacheService->getStats();
        $this->newLine();
        $this->info('📊 Cache Statistics:');
        $this->table(
            ['Key', 'Value'],
            [
                ['Driver', $stats['driver']],
                ['Prefix', $stats['prefix']],
                ['Default TTL', $stats['default_ttl'] . ' seconds'],
            ]
        );

        return 0;
    }
}
