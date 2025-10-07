<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'session_id'
    ];

    /**
     * Get the user that owns the cart
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tenant that owns the cart
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get all items in the cart
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the total number of items in the cart
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    /**
     * Get the subtotal of the cart
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->quantity * $item->unit_price;
        });
    }

    /**
     * Get the total of the cart including tax
     */
    public function getTotalAttribute()
    {
        $subtotal = $this->subtotal;
        $tax = $subtotal * 0.19; // 19% TVA
        return $subtotal + $tax;
    }

    /**
     * Clear all items from the cart
     */
    public function clear()
    {
        $this->items()->delete();
    }

    /**
     * Check if cart is empty
     */
    public function isEmpty()
    {
        return $this->items()->count() === 0;
    }
}