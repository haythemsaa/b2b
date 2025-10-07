<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = [
        'user_id', 'allowed_modules', 'allowed_categories', 'blocked_categories',
        'allowed_products', 'blocked_products', 'can_view_prices', 'can_place_orders',
        'can_request_returns', 'can_chat', 'credit_limit'
    ];

    protected $casts = [
        'allowed_modules' => 'array',
        'allowed_categories' => 'array',
        'blocked_categories' => 'array',
        'allowed_products' => 'array',
        'blocked_products' => 'array',
        'can_view_prices' => 'boolean',
        'can_place_orders' => 'boolean',
        'can_request_returns' => 'boolean',
        'can_chat' => 'boolean',
        'credit_limit' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasModule($module)
    {
        return in_array($module, $this->allowed_modules ?? []);
    }

    public function canAccessProduct($productId)
    {
        if ($this->blocked_products && in_array($productId, $this->blocked_products)) {
            return false;
        }
        if ($this->allowed_products && !in_array($productId, $this->allowed_products)) {
            return false;
        }
        return true;
    }
}