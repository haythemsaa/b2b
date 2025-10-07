<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Integration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'name',
        'type',
        'status',
        'credentials',
        'settings',
        'sync_direction',
        'sync_products',
        'sync_orders',
        'sync_customers',
        'sync_invoices',
        'sync_inventory',
        'sync_frequency',
        'last_sync_at',
        'next_sync_at',
        'total_syncs',
        'successful_syncs',
        'failed_syncs',
        'last_error',
    ];

    protected $casts = [
        'credentials' => 'array',
        'settings' => 'array',
        'sync_products' => 'boolean',
        'sync_orders' => 'boolean',
        'sync_customers' => 'boolean',
        'sync_invoices' => 'boolean',
        'sync_inventory' => 'boolean',
        'last_sync_at' => 'datetime',
        'next_sync_at' => 'datetime',
        'total_syncs' => 'integer',
        'successful_syncs' => 'integer',
        'failed_syncs' => 'integer',
    ];

    // Relations
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function logs()
    {
        return $this->hasMany(IntegrationLog::class);
    }

    public function mappings()
    {
        return $this->hasMany(IntegrationMapping::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors & Mutators
    public function setCredentialsAttribute($value)
    {
        // Encrypt credentials before storing
        $this->attributes['credentials'] = $value ? json_encode(Crypt::encrypt($value)) : null;
    }

    public function getCredentialsAttribute($value)
    {
        // Decrypt credentials when accessing
        if (!$value) return null;

        try {
            return Crypt::decrypt(json_decode($value, true));
        } catch (\Exception $e) {
            return null;
        }
    }

    // Helper methods
    public function getTypeName()
    {
        $types = [
            'sap_b1' => 'SAP Business One',
            'dynamics_365' => 'Microsoft Dynamics 365',
            'sage' => 'Sage Accounting',
            'quickbooks' => 'QuickBooks',
            'odoo' => 'Odoo ERP',
            'xero' => 'Xero Accounting',
            'netsuite' => 'Oracle NetSuite',
            'custom_api' => 'Custom API',
        ];

        return $types[$this->type] ?? $this->type;
    }

    public function getStatusBadge()
    {
        $badges = [
            'active' => 'success',
            'inactive' => 'secondary',
            'error' => 'danger',
            'testing' => 'warning',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getSuccessRate()
    {
        if ($this->total_syncs == 0) return 0;
        return round(($this->successful_syncs / $this->total_syncs) * 100, 2);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function canSync()
    {
        return $this->status === 'active' || $this->status === 'testing';
    }

    public function needsSync()
    {
        if ($this->sync_frequency === 'manual') return false;
        if (!$this->next_sync_at) return true;

        return now()->greaterThanOrEqualTo($this->next_sync_at);
    }

    public function updateNextSync()
    {
        $intervals = [
            'hourly' => '+1 hour',
            'daily' => '+1 day',
            'weekly' => '+1 week',
        ];

        if ($this->sync_frequency === 'manual') {
            $this->next_sync_at = null;
        } else {
            $interval = $intervals[$this->sync_frequency] ?? '+1 day';
            $this->next_sync_at = now()->modify($interval);
        }

        $this->save();
    }

    public function recordSync($success = true, $error = null)
    {
        $this->total_syncs++;

        if ($success) {
            $this->successful_syncs++;
            $this->last_error = null;
        } else {
            $this->failed_syncs++;
            $this->last_error = $error;
            $this->status = 'error';
        }

        $this->last_sync_at = now();
        $this->updateNextSync();
        $this->save();
    }

    // ID Mapping helpers
    public function getExternalId($entityType, $internalId)
    {
        $mapping = $this->mappings()
            ->where('entity_type', $entityType)
            ->where('internal_id', $internalId)
            ->first();

        return $mapping ? $mapping->external_id : null;
    }

    public function getInternalId($entityType, $externalId)
    {
        $mapping = $this->mappings()
            ->where('entity_type', $entityType)
            ->where('external_id', $externalId)
            ->first();

        return $mapping ? $mapping->internal_id : null;
    }

    public function mapIds($entityType, $internalId, $externalId, $metadata = null)
    {
        return $this->mappings()->updateOrCreate(
            [
                'entity_type' => $entityType,
                'internal_id' => $internalId,
            ],
            [
                'tenant_id' => $this->tenant_id,
                'external_id' => $externalId,
                'metadata' => $metadata,
                'last_synced_at' => now(),
            ]
        );
    }
}
