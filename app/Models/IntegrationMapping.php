<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_id',
        'tenant_id',
        'entity_type',
        'internal_id',
        'external_id',
        'metadata',
        'last_synced_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'last_synced_at' => 'datetime',
    ];

    // Relations
    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Scopes
    public function scopeForIntegration($query, $integrationId)
    {
        return $query->where('integration_id', $integrationId);
    }

    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeByEntityType($query, $entityType)
    {
        return $query->where('entity_type', $entityType);
    }

    public function scopeRecentlySynced($query, $hours = 24)
    {
        return $query->where('last_synced_at', '>=', now()->subHours($hours));
    }

    // Helper methods
    public function needsSync($hours = 24)
    {
        if (!$this->last_synced_at) return true;
        return $this->last_synced_at->diffInHours(now()) >= $hours;
    }

    public function markSynced()
    {
        $this->last_synced_at = now();
        $this->save();
    }
}
