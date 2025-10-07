<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_currency',
        'to_currency',
        'rate',
        'date',
        'source',
    ];

    protected $casts = [
        'rate' => 'decimal:6',
        'date' => 'date',
    ];

    /**
     * Relations
     */
    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency', 'code');
    }

    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency', 'code');
    }

    /**
     * Scopes
     */
    public function scopeForPair($query, $from, $to)
    {
        return $query->where('from_currency', $from)
            ->where('to_currency', $to);
    }

    public function scopeLatest($query, $column = 'date')
    {
        return $query->orderBy($column, 'desc');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Méthodes utilitaires
     */
    public static function getRate($from, $to, $date = null)
    {
        $query = static::forPair($from, $to);

        if ($date) {
            $query->forDate($date);
        }

        $rate = $query->latest('date')->first();

        return $rate ? $rate->rate : null;
    }

    public static function convert($amount, $from, $to, $date = null)
    {
        if ($from === $to) {
            return $amount;
        }

        $rate = static::getRate($from, $to, $date);

        if (!$rate) {
            return null;
        }

        return $amount * $rate;
    }

    public static function updateOrCreateRate($from, $to, $rate, $source = 'manual', $date = null)
    {
        return static::updateOrCreate(
            [
                'from_currency' => $from,
                'to_currency' => $to,
                'date' => $date ?? Carbon::today(),
            ],
            [
                'rate' => $rate,
                'source' => $source,
            ]
        );
    }
}
