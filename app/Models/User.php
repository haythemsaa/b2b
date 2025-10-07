<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_name',
        'phone',
        'address',
        'city',
        'postal_code',
        'is_active',
        'preferred_language',
        'tenant_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function isGrossiste()
    {
        return $this->role === 'grossiste';
    }

    public function isVendeur()
    {
        return $this->role === 'vendeur';
    }

    public function customerGroups()
    {
        return $this->belongsToMany(CustomerGroup::class, 'customer_group_users');
    }

    public function customPrices()
    {
        return $this->hasMany(CustomPrice::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function productReturns()
    {
        return $this->hasMany(ProductReturn::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (app()->bound('current.tenant')) {
                $user->tenant_id = app('current.tenant')->id;
            }
        });
    }

    public function getCustomPriceForProduct(Product $product)
    {
        $customPrice = $this->customPrices()
            ->where('product_id', $product->id)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->first();

        if ($customPrice) {
            return $customPrice->price;
        }

        foreach ($this->customerGroups as $group) {
            $groupPrice = CustomPrice::where('product_id', $product->id)
                ->where('customer_group_id', $group->id)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('valid_from')
                        ->orWhere('valid_from', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('valid_until')
                        ->orWhere('valid_until', '>=', now());
                })
                ->first();

            if ($groupPrice) {
                return $groupPrice->price;
            }
        }

        return $product->base_price;
    }
}