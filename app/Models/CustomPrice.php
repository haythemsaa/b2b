<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'customer_group_id',
        'price',
        'min_quantity',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:3',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where(function ($query) {
            $query->whereNull('valid_from')
                ->orWhere('valid_from', '<=', now());
        })->where(function ($query) {
            $query->whereNull('valid_until')
                ->orWhere('valid_until', '>=', now());
        });
    }

    public function isValid()
    {
        $now = now();

        if ($this->valid_from && $this->valid_from->gt($now)) {
            return false;
        }

        if ($this->valid_until && $this->valid_until->lt($now)) {
            return false;
        }

        return $this->is_active;
    }
}