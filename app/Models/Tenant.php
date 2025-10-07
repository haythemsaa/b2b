<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'domain', 'email', 'phone', 'address', 'city', 'country',
        'logo_url', 'brand_colors', 'favicon_url',
        'default_currency', 'default_language', 'supported_languages', 'timezone',
        'plan', 'max_users', 'max_products', 'monthly_fee',
        'enabled_modules', 'is_active', 'trial_ends_at', 'last_payment_at', 'settings'
    ];

    protected $casts = [
        'brand_colors' => 'array',
        'supported_languages' => 'array',
        'enabled_modules' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'trial_ends_at' => 'datetime',
        'last_payment_at' => 'datetime',
        'monthly_fee' => 'decimal:2'
    ];

    // Relations
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function customerGroups(): HasMany
    {
        return $this->hasMany(CustomerGroup::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPlan($query, $plan)
    {
        return $query->where('plan', $plan);
    }

    // Helpers
    public function isModuleEnabled(string $module): bool
    {
        return in_array($module, $this->enabled_modules ?? []);
    }

    public function canAddUser(): bool
    {
        return $this->users()->count() < $this->max_users;
    }

    public function canAddProduct(): bool
    {
        return $this->products()->count() < $this->max_products;
    }

    public function isTrialExpired(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isPast();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
