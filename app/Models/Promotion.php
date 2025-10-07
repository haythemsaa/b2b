<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'value',
        'valid_from',
        'valid_until',
        'is_active',
        'usage_limit',
        'used_count',
    ];

    protected $casts = [
        'value' => 'decimal:3',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_products');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'promotion_users');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now());
    }

    public function isValid()
    {
        $now = now();

        if (!$this->is_active) {
            return false;
        }

        if ($this->valid_from->gt($now) || $this->valid_until->lt($now)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function canBeUsedByUser(User $user)
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($this->users->isNotEmpty()) {
            return $this->users->contains($user);
        }

        return true;
    }

    public function getDiscountAmount($originalPrice)
    {
        if ($this->type === 'percentage') {
            return $originalPrice * ($this->value / 100);
        }

        return min($this->value, $originalPrice);
    }

    public function getDiscountedPrice($originalPrice)
    {
        return $originalPrice - $this->getDiscountAmount($originalPrice);
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}