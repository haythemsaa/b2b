<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 'tenant_id', 'action', 'model_type', 'model_id',
        'old_values', 'new_values', 'ip_address', 'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public static function log($action, $model = null, $oldValues = null, $newValues = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'tenant_id' => auth()->user()?->tenant_id,
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}