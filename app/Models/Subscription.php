<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id', 'plan', 'billing_cycle', 'amount', 'status',
        'start_date', 'end_date', 'next_billing_date', 'auto_renew', 'features'
    ];

    protected $casts = [
        'features' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'next_billing_date' => 'date',
        'auto_renew' => 'boolean',
        'amount' => 'decimal:2'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && (!$this->end_date || $this->end_date->isFuture());
    }
}