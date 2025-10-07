<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'discount_amount',
        'total_amount',
        'tax_amount',
        'currency',
        'exchange_rate',
        'notes',
        'admin_notes',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:3',
        'discount_amount' => 'decimal:3',
        'total_amount' => 'decimal:3',
        'exchange_rate' => 'decimal:6',
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function returns()
    {
        return $this->hasMany(ProductReturn::class);
    }

    public function currencyModel()
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }

    public function getFormattedTotal()
    {
        $currency = $this->currencyModel;

        if ($currency) {
            return $currency->formatAmount($this->total_amount);
        }

        return number_format($this->total_amount, 3) . ' ' . ($this->currency ?? 'TND');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isShipped()
    {
        return $this->status === 'shipped';
    }

    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function calculateTotals()
    {
        $subtotal = $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });

        $this->subtotal = $subtotal;
        $this->total_amount = $subtotal - $this->discount_amount;
        $this->save();
    }

    public static function generateOrderNumber()
    {
        $year = date('Y');
        $month = date('m');

        // Chercher la dernière commande du mois en cours (sans scopes globaux)
        $lastOrder = self::withoutGlobalScopes()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastOrder ? intval(substr($lastOrder->order_number, -4)) + 1 : 1;

        return 'CMD-' . $year . $month . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'order_number';
    }
}