<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\ProductImage;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'description_ar',
        'category_id',
        'brand',
        'unit',
        'base_price',
        'price',
        'currency',
        'stock_quantity',
        'min_order_quantity',
        'order_multiple',
        'stock_alert_threshold',
        'images',
        'attributes',
        'is_active',
        'tenant_id',
        // SEO Fields
        'meta_title',
        'meta_description',
        'meta_keywords',
        'short_description',
        // Product Identity
        'manufacturer',
        'supplier_reference',
        'ean13',
        'upc',
        'isbn',
        // Physical Properties
        'weight',
        'width',
        'height',
        'depth',
        // Advanced Stock
        'min_quantity',
        'low_stock_threshold',
        'available_for_order',
        'availability',
        'available_date',
        // Advanced Pricing
        'wholesale_price',
        'tax_rate',
        'on_sale',
        'sale_price',
        'sale_start_date',
        'sale_end_date',
        // Display Options
        'show_price',
        'featured',
        'new_arrival',
        'position',
        'condition',
        // Technical Information
        'features',
        'technical_specs',
        'additional_info',
        // Shipping
        'free_shipping',
        'delivery_time',
        'additional_shipping_cost',
        // Customization
        'customizable',
        'customization_text',
        'text_fields',
        // Media
        'video_url',
        'attachments',
    ];

    protected $casts = [
        'base_price' => 'decimal:3',
        'price' => 'decimal:3',
        'images' => 'array',
        'attributes' => 'array',
        'is_active' => 'boolean',
        'features' => 'array',
        'technical_specs' => 'array',
        'attachments' => 'array',
        'available_for_order' => 'boolean',
        'on_sale' => 'boolean',
        'show_price' => 'boolean',
        'featured' => 'boolean',
        'new_arrival' => 'boolean',
        'free_shipping' => 'boolean',
        'customizable' => 'boolean',
        'available_date' => 'date',
        'sale_start_date' => 'date',
        'sale_end_date' => 'date',
    ];

    public $translatable = ['name', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function customPrices()
    {
        return $this->hasMany(CustomPrice::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_products');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Alias pour la relation images (plus court)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(ProductAttributeValue::class, 'product_attribute_product')
            ->withPivot('price_impact')
            ->withTimestamps();
    }

    public function currencyModel()
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('on_sale', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('new_arrival', true);
    }

    public function getEffectivePrice()
    {
        if ($this->on_sale && $this->sale_price) {
            $now = now();
            $saleActive = true;

            if ($this->sale_start_date && $now->lt($this->sale_start_date)) {
                $saleActive = false;
            }

            if ($this->sale_end_date && $now->gt($this->sale_end_date)) {
                $saleActive = false;
            }

            if ($saleActive) {
                return $this->sale_price;
            }
        }

        return $this->price ?? $this->base_price;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    public function isLowStock()
    {
        return $this->stock_quantity <= $this->stock_alert_threshold;
    }

    public function getFormattedPrice($price = null)
    {
        $amount = $price ?? $this->getEffectivePrice();
        $currency = $this->currencyModel;

        if ($currency) {
            return $currency->formatAmount($amount);
        }

        return number_format($amount, 3) . ' ' . ($this->currency ?? 'TND');
    }

    public function convertPrice($targetCurrency)
    {
        return ExchangeRate::convert($this->getEffectivePrice(), $this->currency, $targetCurrency);
    }

    public function getPriceForUser(User $user)
    {
        if ($user->isVendeur()) {
            return $user->getCustomPriceForProduct($this);
        }

        return $this->price ?? $this->base_price;
    }

    public function getPriceAttribute($value)
    {
        return $value ?? $this->base_price;
    }

    public function scopeForUserGroup($query, User $user)
    {
        if ($user->role === 'grossiste') {
            return $query;
        }

        if ($user->role === 'vendeur') {
            $userGroups = $user->customerGroups->pluck('id');

            if ($userGroups->isEmpty()) {
                return $query->where('is_active', true);
            }

            return $query->where('is_active', true)
                ->where(function ($q) use ($userGroups, $user) {
                    // Produits avec tarifs personnalisés pour l'utilisateur
                    $q->whereHas('customPrices', function ($subQuery) use ($user) {
                        $subQuery->where('user_id', $user->id)
                                ->where('is_active', true)
                                ->valid();
                    })
                    // OU produits avec tarifs pour ses groupes
                    ->orWhereHas('customPrices', function ($subQuery) use ($userGroups) {
                        $subQuery->whereIn('customer_group_id', $userGroups)
                                ->where('is_active', true)
                                ->valid();
                    })
                    // OU tous les produits sans restrictions spécifiques
                    ->orWhereDoesntHave('customPrices', function ($subQuery) {
                        $subQuery->where('is_active', true);
                    });
                });
        }

        return $query->where('is_active', true);
    }

    public function decrementStock($quantity)
    {
        if ($this->stock_quantity >= $quantity) {
            $this->decrement('stock_quantity', $quantity);
            return true;
        }

        return false;
    }

    public function incrementStock($quantity)
    {
        $this->increment('stock_quantity', $quantity);
    }

    public function getFirstImageAttribute()
    {
        return $this->images ? $this->images[0] : null;
    }

    public function getRouteKeyName()
    {
        return 'sku';
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            if (app()->bound('current.tenant')) {
                $product->tenant_id = app('current.tenant')->id;
            }
        });
    }
}