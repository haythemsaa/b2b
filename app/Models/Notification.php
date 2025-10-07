<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'type',
        'title',
        'message',
        'data',
        'icon',
        'link',
        'is_read',
        'read_at',
        'priority'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    // Méthodes helper
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function getIconClass()
    {
        if ($this->icon) {
            return $this->icon;
        }

        return match($this->type) {
            'order' => 'bi-cart-check',
            'product' => 'bi-box-seam',
            'return' => 'bi-arrow-return-left',
            'message' => 'bi-chat-dots',
            'system' => 'bi-gear',
            default => 'bi-bell',
        };
    }

    public function getPriorityBadgeClass()
    {
        return match($this->priority) {
            'urgent' => 'danger',
            'high' => 'warning',
            'normal' => 'info',
            'low' => 'secondary',
            default => 'info',
        };
    }
}
