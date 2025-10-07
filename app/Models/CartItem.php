<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    /**
     * Get the cart that owns the item
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product associated with the cart item
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the total price for this cart item
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * Update the unit price based on current product price
     */
    public function updatePrice()
    {
        if ($this->product) {
            $this->update(['unit_price' => $this->product->price]);
        }
    }

    /**
     * Check if the requested quantity is available in stock
     */
    public function isQuantityAvailable($requestedQuantity = null)
    {
        $quantity = $requestedQuantity ?? $this->quantity;
        return $this->product && $this->product->stock >= $quantity;
    }
}