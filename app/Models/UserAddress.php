<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id', 'label', 'type', 'address_line1', 'address_line2',
        'city', 'state', 'postal_code', 'country', 'phone', 'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
}