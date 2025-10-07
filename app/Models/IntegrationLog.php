<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_id',
        'tenant_id',
        'entity_type',
        'entity_id',
        'external_id',
        'action',
        'direction',
        'status',
        'request_data',
        'response_data',
        'error_message',
        'duration_ms',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'duration_ms' => 'integer',
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

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByEntityType($query, $entityType)
    {
        return $query->where('entity_type', $entityType);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // Helper methods
    public function getStatusBadge()
    {
        $badges = [
            'success' => 'success',
            'failed' => 'danger',
            'pending' => 'warning',
            'partial' => 'info',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function isSuccessful()
    {
        return $this->status === 'success';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function getDurationInSeconds()
    {
        return $this->duration_ms ? round($this->duration_ms / 1000, 2) : 0;
    }

    // Static helper pour créer un log
    public static function createLog($integrationId, $tenantId, $data)
    {
        return self::create(array_merge([
            'integration_id' => $integrationId,
            'tenant_id' => $tenantId,
        ], $data));
    }
}
