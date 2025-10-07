<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'decimal_places',
        'format',
        'is_active',
        'is_default',
        'position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'decimal_places' => 'integer',
        'position' => 'integer',
    ];

    /**
     * Relations
     */
    public function exchangeRatesFrom()
    {
        return $this->hasMany(ExchangeRate::class, 'from_currency', 'code');
    }

    public function exchangeRatesTo()
    {
        return $this->hasMany(ExchangeRate::class, 'to_currency', 'code');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Méthodes utilitaires
     */
    public function formatAmount($amount)
    {
        $formatted = number_format($amount, $this->decimal_places, '.', ' ');
        return str_replace(
            ['{symbol}', '{amount}'],
            [$this->symbol, $formatted],
            $this->format
        );
    }

    public static function getDefault()
    {
        return static::where('is_default', true)->first();
    }

    public function getLatestRate($toCurrency)
    {
        return ExchangeRate::where('from_currency', $this->code)
            ->where('to_currency', $toCurrency)
            ->latest('date')
            ->first();
    }

    public function convert($amount, $toCurrency)
    {
        if ($this->code === $toCurrency) {
            return $amount;
        }

        $rate = $this->getLatestRate($toCurrency);
        if (!$rate) {
            return null;
        }

        return $amount * $rate->rate;
    }
}
