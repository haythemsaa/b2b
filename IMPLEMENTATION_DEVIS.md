# 📋 Système de Devis/Quotations - Guide d'Implémentation

## ✅ **ÉTAPE 1 - Base de données (FAIT)**
- ✅ Migration créée et exécutée
- ✅ Tables `quotes` et `quote_items` créées
- ✅ Modèles générés

---

## 🔧 **ÉTAPE 2 - Modèles à compléter**

### **Fichier: `app/Models/Quote.php`**
```php
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
        'currency', 'tax_rate', 'payment_terms'
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

    // Méthodes utilitaires
    public function generateQuoteNumber()
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
                'quantity' => $item->quantity,
                'price' => $item->unit_price,
                'subtotal' => $item->subtotal,
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
```

### **Fichier: `app/Models/QuoteItem.php`**
```php
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
            if (!$item->subtotal || !$item->total) {
                $item->calculateTotals();
            }
        });

        static::saved(function ($item) {
            $item->quote->calculateTotals();
        });

        static::deleted(function ($item) {
            $item->quote->calculateTotals();
        });
    }
}
```

---

## 🎮 **ÉTAPE 3 - Routes à ajouter**

### **Fichier: `routes/web.php`**
Ajouter dans la section vendeur:
```php
// Routes pour les devis (Vendeurs)
Route::prefix('quotes')->name('quotes.')->group(function () {
    Route::get('/', [QuoteController::class, 'index'])->name('index');
    Route::get('/create', [QuoteController::class, 'create'])->name('create');
    Route::post('/', [QuoteController::class, 'store'])->name('store');
    Route::get('/{quote}', [QuoteController::class, 'show'])->name('show');
    Route::get('/{quote}/pdf', [QuoteController::class, 'downloadPdf'])->name('pdf');
    Route::post('/{quote}/send', [QuoteController::class, 'send'])->name('send');
    Route::post('/{quote}/accept', [QuoteController::class, 'accept'])->name('accept');
    Route::post('/{quote}/reject', [QuoteController::class, 'reject'])->name('reject');
    Route::post('/{quote}/convert', [QuoteController::class, 'convertToOrder'])->name('convert');
});
```

Ajouter dans la section admin/grossiste:
```php
// Routes pour la gestion des devis (Admin)
Route::prefix('admin/quotes')->name('admin.quotes.')->group(function () {
    Route::get('/', [Admin\AdminQuoteController::class, 'index'])->name('index');
    Route::get('/{quote}', [Admin\AdminQuoteController::class, 'show'])->name('show');
    Route::post('/{quote}/approve', [Admin\AdminQuoteController::class, 'approve'])->name('approve');
    Route::delete('/{quote}', [Admin\AdminQuoteController::class, 'destroy'])->name('destroy');
});
```

---

## 📊 **ÉTAPE 4 - Menu Navigation**

### **Ajouter dans le menu vendeur**
```html
<li class="nav-item">
    <a class="nav-link" href="{{ route('quotes.index') }}">
        <i class="fas fa-file-invoice me-2"></i>Devis
    </a>
</li>
```

### **Ajouter dans le menu admin**
```html
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.quotes.index') }}">
        <i class="fas fa-file-contract me-2"></i>Devis
    </a>
</li>
```

---

## 📈 **FONCTIONNALITÉS DISPONIBLES**

### ✅ **Pour les Vendeurs:**
1. Créer un nouveau devis
2. Ajouter des produits au devis
3. Calculer automatiquement les totaux
4. Envoyer le devis au client
5. Télécharger en PDF
6. Suivre le statut (draft, sent, viewed, accepted, rejected)
7. Convertir un devis accepté en commande

### ✅ **Pour les Grossistes/Admin:**
1. Voir tous les devis
2. Approuver/rejeter des devis
3. Statistiques sur les devis
4. Exporter les devis

### ✅ **Automatisations:**
1. Numérotation automatique (QT-202510-0001)
2. Calcul automatique des totaux
3. Détection des devis expirés
4. Conversion automatique en commande
5. Historique complet

---

## 🎨 **PROCHAINES AMÉLIORATIONS POSSIBLES**

1. **PDF personnalisable** avec logo entreprise
2. **Envoi email automatique** au client
3. **Signature électronique** sur le devis
4. **Versioning** des devis (v1, v2, v3...)
5. **Templates de devis** pré-remplis
6. **Rappels automatiques** pour devis en attente
7. **Analytics** sur les taux d'acceptation
8. **Multi-devises** avancé

---

## 📝 **STATUS IMPLEMENTATION**

- [x] Migration base de données
- [x] Modèles Quote et QuoteItem
- [ ] Controller QuoteController
- [ ] Vues (index, create, show)
- [ ] Routes
- [ ] Tests

---

**Date de création:** 6 Octobre 2025
**Statut:** Modèles créés, à finaliser
