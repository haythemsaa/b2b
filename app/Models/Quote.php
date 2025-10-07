<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id', 'quote_number', 'user_id', 'grossiste_id',
        'customer_name', 'customer_email', 'customer_phone', 'customer_address',
        'subtotal', 'tax_amount', 'discount_amount', 'total',
        'status', 'valid_until', 'accepted_at', 'rejected_at', 'converted_order_id',
        'notes', 'terms_conditions', 'internal_notes',
        'currency', 'exchange_rate', 'tax_rate', 'payment_terms'
    ];

    protected $casts = [
        'valid_until' => 'date',
        'accepted_at' => 'date',
        'rejected_at' => 'date',
        'subtotal' => 'decimal:3',
        'tax_amount' => 'decimal:3',
        'discount_amount' => 'decimal:3',
        'total' => 'decimal:3',
        'tax_rate' => 'decimal:2',
        'exchange_rate' => 'decimal:6',
    ];

    // Relations
    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grossiste()
    {
        return $this->belongsTo(User::class, 'grossiste_id');
    }

    public function convertedOrder()
    {
        return $this->belongsTo(Order::class, 'converted_order_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function currencyModel()
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }

    public function getFormattedTotal()
    {
        $currency = $this->currencyModel;

        if ($currency) {
            return $currency->formatAmount($this->total);
        }

        return number_format($this->total, 3) . ' ' . ($this->currency ?? 'TND');
    }

    // Méthodes utilitaires
    public static function generateQuoteNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastQuote = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastQuote ? intval(substr($lastQuote->quote_number, -4)) + 1 : 1;

        return 'QT-' . $year . $month . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->items->sum('subtotal');
        $this->tax_amount = $this->subtotal * ($this->tax_rate / 100);
        $this->total = $this->subtotal + $this->tax_amount - $this->discount_amount;
        $this->save();
    }

    public function isExpired()
    {
        return $this->valid_until && $this->valid_until < now();
    }

    public function canBeConverted()
    {
        return $this->status === 'accepted' && !$this->converted_order_id;
    }

    public function convertToOrder()
    {
        if (!$this->canBeConverted()) {
            return false;
        }

        // Créer la commande
        $order = Order::create([
            'tenant_id' => $this->tenant_id,
            'user_id' => $this->user_id,
            'order_number' => 'ORD-' . uniqid(),
            'subtotal' => $this->subtotal,
            'tax' => $this->tax_amount,
            'total' => $this->total,
            'status' => 'pending',
        ]);

        // Copier les items
        foreach ($this->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'product_sku' => $item->product_sku,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total,
            ]);
        }

        // Marquer le devis comme converti
        $this->update([
            'status' => 'converted',
            'converted_order_id' => $order->id,
        ]);

        return $order;
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now())
            ->whereIn('status', ['sent', 'viewed']);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            if (!$quote->quote_number) {
                $quote->quote_number = $quote->generateQuoteNumber();
            }
            if (app()->bound('current.tenant')) {
                $quote->tenant_id = app('current.tenant')->id;
            }
        });
    }
}
