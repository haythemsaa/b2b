<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'full_name',
        'company_name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
        'notes'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Relation avec User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Formater l'adresse complète
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address_line1,
            $this->address_line2,
            $this->postal_code . ' ' . $this->city,
            $this->state,
            $this->country
        ]);

        return implode(', ', $parts);
    }

    /**
     * Scope pour les adresses par défaut
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
