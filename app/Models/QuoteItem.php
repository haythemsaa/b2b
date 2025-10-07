<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $fillable = [
        'quote_id', 'product_id',
        'product_name', 'product_sku', 'product_description',
        'quantity', 'unit_price', 'discount_percent', 'discount_amount',
        'tax_rate', 'subtotal', 'total', 'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:3',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:3',
        'tax_rate' => 'decimal:2',
        'subtotal' => 'decimal:3',
        'total' => 'decimal:3',
    ];

    // Relations
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Calcul automatique
    public function calculateTotals()
    {
        $this->subtotal = $this->quantity * $this->unit_price;

        if ($this->discount_percent > 0) {
            $this->discount_amount = $this->subtotal * ($this->discount_percent / 100);
        }

        $subtotalAfterDiscount = $this->subtotal - $this->discount_amount;
        $tax = $subtotalAfterDiscount * ($this->tax_rate / 100);
        $this->total = $subtotalAfterDiscount + $tax;

        $this->save();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            // Calculer le total seulement si non défini
            if (!$item->total) {
                $subtotalAfterDiscount = $item->subtotal - ($item->discount_amount ?? 0);
                $tax = $subtotalAfterDiscount * (($item->tax_rate ?? 0) / 100);
                $item->total = $subtotalAfterDiscount + $tax;
            }
        });

        static::saved(function ($item) {
            if ($item->quote) {
                $item->quote->calculateTotals();
            }
        });

        static::deleted(function ($item) {
            if ($item->quote) {
                $item->quote->calculateTotals();
            }
        });
    }
}
