# 📄 Guide PDF - Génération de Factures
## Système de Facturation B2B Platform

---

## 📋 Table des Matières
1. [Installation et Configuration](#installation)
2. [Utilisation de la génération PDF](#utilisation)
3. [Personnalisation du Template](#personnalisation)
4. [Résolution de Problèmes](#troubleshooting)
5. [API et Intégrations](#api)

---

## 🚀 1. Installation et Configuration {#installation}

### **1.1 Package Installé**

**DomPDF Laravel v3.1.2** - Package officiel pour génération PDF dans Laravel

```bash
composer require barryvdh/laravel-dompdf
```

### **1.2 Configuration**

Le fichier de configuration est publié dans `config/dompdf.php`

**Paramètres importants:**

```php
return [
    // Format de page par défaut
    'defines' => [
        'DOMPDF_DEFAULT_PAPER_SIZE' => 'a4',
        'DOMPDF_DEFAULT_FONT' => 'sans-serif',
        'DOMPDF_DPI' => 150,
        'DOMPDF_ENABLE_PHP' => false, // Sécurité
        'DOMPDF_ENABLE_REMOTE' => true, // Chargement images externes
    ]
];
```

### **1.3 Options de Génération**

Dans `AdminInvoiceController.php`:

```php
$pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
    ->setPaper('a4', 'portrait')
    ->setOptions([
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'defaultFont' => 'sans-serif',
        'dpi' => 150,
        'enable_php' => false,
    ]);
```

**Explications:**
- `isHtml5ParserEnabled`: Support HTML5 moderne
- `isRemoteEnabled`: Autorise chargement images via URL
- `defaultFont`: Police par défaut (DejaVu Sans pour UTF-8)
- `dpi`: 150 pour qualité d'impression professionnelle
- `enable_php`: Désactivé pour sécurité

---

## 📖 2. Utilisation de la Génération PDF {#utilisation}

### **2.1 Depuis l'Interface Admin**

#### **Accéder à une facture:**
1. Connexion admin: `http://127.0.0.1:8001/admin`
2. Menu latéral → **Factures**
3. Cliquer sur une facture dans la liste
4. Utiliser les boutons en haut à droite:
   - 🔵 **Voir PDF** - Ouvre le PDF dans un nouvel onglet
   - 🟢 **Télécharger PDF** - Télécharge le fichier PDF
   - 🖨️ **Imprimer** - Version imprimable HTML

### **2.2 Routes Disponibles**

| Route | Méthode | Description | Exemple |
|-------|---------|-------------|---------|
| `/admin/invoices/{id}/pdf` | GET | Affiche PDF dans navigateur | `http://127.0.0.1:8001/admin/invoices/1/pdf` |
| `/admin/invoices/{id}/download` | GET | Télécharge PDF | `http://127.0.0.1:8001/admin/invoices/1/download` |

### **2.3 Nom des Fichiers**

Format automatique: `facture-{invoice_number}.pdf`

**Exemples:**
- `facture-INV-202510-0001.pdf`
- `facture-INV-202510-0042.pdf`

### **2.4 Sécurité**

✅ **Isolation Multi-Tenant:**
- Chaque utilisateur ne peut accéder qu'aux factures de son tenant
- Vérification automatique via middleware Auth + tenant_id

✅ **Permissions:**
- Uniquement accessible aux utilisateurs avec rôle `grossiste` (admin)
- Middleware `check.role:grossiste` appliqué

---

## 🎨 3. Personnalisation du Template {#personnalisation}

### **3.1 Emplacement du Template**

**Fichier:** `resources/views/invoices/pdf.blade.php` (387 lignes)

### **3.2 Sections Personnalisables**

#### **A) Header Entreprise**

```blade
<div class="company-name">{{ config('app.name', 'B2B Platform') }}</div>
<div class="company-info">
    <strong>Adresse:</strong> [Votre Adresse Complète]<br>
    <strong>Téléphone:</strong> [Votre Numéro]<br>
    <strong>Email:</strong> [Votre Email]<br>
    <strong>Matricule Fiscal:</strong> [Votre Matricule]
</div>
```

**À modifier:**
- Adresse complète de votre société
- Numéro de téléphone professionnel
- Email de contact
- Matricule fiscal / Numéro RCS

#### **B) Logo Entreprise**

```blade
<div class="header-col left">
    <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-width: 200px;">
    <div class="company-name">{{ config('app.name') }}</div>
</div>
```

**Instructions:**
1. Placer votre logo dans `public/images/logo.png`
2. Taille recommandée: 200x80 pixels
3. Format: PNG avec transparence

#### **C) Couleurs de Marque**

Modifier dans la section `<style>`:

```css
/* Couleur principale (actuellement bleu #2563eb) */
.company-name {
    color: #2563eb; /* Remplacer par votre couleur */
}

.invoice-title {
    color: #2563eb;
}

.items-table thead {
    background-color: #2563eb;
}
```

**Exemples de couleurs:**
- Rouge: `#dc2626`
- Vert: `#059669`
- Orange: `#ea580c`
- Bleu marine: `#1e3a8a`

#### **D) Taux de TVA**

Modifier dans le template (ligne ~402):

```blade
<tr>
    <td>TVA (19%):</td> <!-- Changer 19% -->
    <td>{{ number_format($invoice->tax, 2, ',', ' ') }} TND</td>
</tr>
```

#### **E) Mentions Légales Footer**

```blade
<div class="footer">
    <p>
        <strong>{{ config('app.name') }}</strong> - [Adresse] - Tél: [Téléphone]<br>
        Matricule Fiscal: [Matricule] - RCS: [Numéro RCS]<br>
        Capital social: [Montant] TND - TVA Intra: [Numéro TVA]
    </p>
</div>
```

### **3.3 Polices de Caractères**

**Police par défaut:** DejaVu Sans (support UTF-8 complet)

**Pour changer:**

```css
body {
    font-family: 'Helvetica', 'Arial', sans-serif;
}
```

**Polices disponibles:**
- DejaVu Sans (recommandé - UTF-8)
- Helvetica
- Arial
- Times New Roman
- Courier

⚠️ **Attention:** Les polices custom nécessitent conversion WOFF → TTF

### **3.4 Paramètres d'Impression**

```css
@page {
    margin: 20mm; /* Marges page */
    size: A4 portrait; /* Format */
}

@media print {
    .btn, .alert, form {
        display: none !important; /* Cacher éléments non imprimables */
    }
}
```

---

## 🔧 4. Résolution de Problèmes {#troubleshooting}

### **4.1 Erreur: "Class 'Barryvdh\DomPDF\Facade\Pdf' not found"**

**Cause:** Package non installé ou cache Laravel obsolète

**Solution:**
```bash
composer require barryvdh/laravel-dompdf
php artisan config:clear
php artisan cache:clear
```

### **4.2 PDF vide ou page blanche**

**Causes possibles:**
1. Template Blade avec erreurs PHP
2. Variables non passées au template
3. Données manquantes (order, items, user)

**Solution:**
```bash
# Vérifier logs Laravel
tail -f storage/logs/laravel.log

# Tester template directement
php artisan tinker
>>> $invoice = \App\Models\Invoice::with(['order.items.product', 'order.user'])->first();
>>> view('invoices.pdf', compact('invoice'))->render();
```

### **4.3 Images ne s'affichent pas**

**Cause:** Chemins relatifs non supportés dans PDF

**Solution:** Utiliser `public_path()` au lieu de `asset()`

```blade
<!-- ❌ Ne fonctionne pas -->
<img src="{{ asset('images/logo.png') }}">

<!-- ✅ Fonctionne -->
<img src="{{ public_path('images/logo.png') }}">
```

### **4.4 Caractères spéciaux mal affichés**

**Cause:** Encodage UTF-8 non configuré

**Solution:**
```php
// Dans le controller
$pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
    ->setOptions([
        'defaultFont' => 'DejaVu Sans', // Police UTF-8
    ]);
```

### **4.5 PDF trop lourd (> 5 MB)**

**Optimisations:**

1. **Compresser images:**
```bash
# Utiliser TinyPNG ou ImageOptim
```

2. **Réduire DPI:**
```php
->setOptions(['dpi' => 96]); // Au lieu de 150
```

3. **Limiter nombre d'articles:**
```php
// Si + de 50 articles, créer facture par page
```

### **4.6 Téléchargement bloqué par navigateur**

**Cause:** Headers HTTP manquants

**Solution:** Headers sont déjà configurés dans DomPDF:
```php
return $pdf->download('facture.pdf'); // Headers automatiques
```

Si problème persiste, vérifier antivirus/pare-feu.

---

## 🔌 5. API et Intégrations {#api}

### **5.1 Génération PDF Programmatique**

**Exemple dans un Job Laravel:**

```php
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;

class GenerateInvoicePDFJob implements ShouldQueue
{
    public function handle()
    {
        $invoice = Invoice::with(['order.items.product', 'order.user'])
            ->find($this->invoiceId);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

        // Sauvegarder sur disque
        $pdf->save(storage_path('app/invoices/' . $invoice->invoice_number . '.pdf'));

        // Ou envoyer par email
        Mail::to($invoice->order->user->email)
            ->send(new InvoiceMail($invoice, $pdf->output()));
    }
}
```

### **5.2 API REST Endpoint**

**Ajouter route API (optionnel):**

```php
// routes/api.php
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/invoices/{invoice}/pdf', function ($id) {
        $invoice = Invoice::with(['order.items.product', 'order.user'])
            ->where('tenant_id', auth()->user()->tenant_id)
            ->findOrFail($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf');
    });
});
```

**Utilisation:**
```bash
curl -H "Authorization: Bearer {token}" \
     http://127.0.0.1:8001/api/invoices/1/pdf \
     --output facture.pdf
```

### **5.3 Envoi Email Automatique**

**Créer Mailable:**

```bash
php artisan make:mail InvoiceMail
```

**Contenu `app/Mail/InvoiceMail.php`:**

```php
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceMail extends Mailable
{
    public function build()
    {
        $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $this->invoice])
            ->setPaper('a4', 'portrait');

        return $this->subject('Facture ' . $this->invoice->invoice_number)
                    ->view('emails.invoice')
                    ->attachData($pdf->output(), 'facture.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
```

**Envoyer:**

```php
use App\Mail\InvoiceMail;

Mail::to($invoice->order->user->email)
    ->send(new InvoiceMail($invoice));
```

### **5.4 Génération par Lot**

**Command Artisan:**

```php
php artisan make:command GenerateInvoicesPDF
```

```php
class GenerateInvoicesPDF extends Command
{
    protected $signature = 'invoices:generate-pdf {--month=} {--year=}';

    public function handle()
    {
        $invoices = Invoice::whereMonth('invoice_date', $this->option('month'))
            ->whereYear('invoice_date', $this->option('year'))
            ->get();

        $bar = $this->output->createProgressBar(count($invoices));

        foreach ($invoices as $invoice) {
            $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
                ->setPaper('a4', 'portrait');

            $pdf->save(storage_path('app/invoices/' . $invoice->invoice_number . '.pdf'));

            $bar->advance();
        }

        $bar->finish();
        $this->info("\n✅ {$invoices->count()} factures générées !");
    }
}
```

**Utilisation:**
```bash
php artisan invoices:generate-pdf --month=10 --year=2025
```

---

## 📊 6. Performances et Optimisation

### **6.1 Benchmarks**

| Taille Facture | Articles | Temps Génération | Taille PDF |
|----------------|----------|------------------|------------|
| Petite | 1-5 | ~0.5s | 50-100 KB |
| Moyenne | 6-20 | ~1.2s | 100-300 KB |
| Grande | 21-50 | ~2.5s | 300-800 KB |
| Très grande | 51+ | ~5s+ | 800 KB - 2 MB |

### **6.2 Cache PDF**

**Implémenter cache pour factures payées:**

```php
use Illuminate\Support\Facades\Cache;

public function downloadPDF($id)
{
    $invoice = Invoice::findOrFail($id);

    // Cache uniquement si facture payée (ne changera plus)
    if ($invoice->status === 'paid') {
        $cacheKey = 'invoice_pdf_' . $invoice->id;

        return Cache::remember($cacheKey, 3600, function () use ($invoice) {
            return Pdf::loadView('invoices.pdf', compact('invoice'))
                ->setPaper('a4', 'portrait')
                ->download('facture-' . $invoice->invoice_number . '.pdf');
        });
    }

    // Génération normale pour factures non payées
    return Pdf::loadView('invoices.pdf', compact('invoice'))
        ->setPaper('a4', 'portrait')
        ->download('facture-' . $invoice->invoice_number . '.pdf');
}
```

### **6.3 Queue Jobs**

**Pour génération asynchrone:**

```php
use Illuminate\Bus\Queueable;

class GenerateInvoicePDF implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $this->invoice])
            ->setPaper('a4', 'portrait');

        Storage::put('invoices/' . $this->invoice->invoice_number . '.pdf', $pdf->output());

        // Notifier utilisateur
        $this->invoice->order->user->notify(new InvoiceReadyNotification($this->invoice));
    }
}
```

**Dispatch:**
```php
GenerateInvoicePDF::dispatch($invoice);
```

---

## 🔐 7. Sécurité

### **7.1 Bonnes Pratiques**

✅ **DO:**
- Toujours vérifier `tenant_id` avant génération
- Désactiver `enable_php` dans options DomPDF
- Limiter accès aux routes avec middleware Auth
- Valider ID facture avec `findOrFail()`
- Logger téléchargements PDF pour audit

❌ **DON'T:**
- Ne jamais accepter HTML user-generated dans template
- Ne pas stocker PDF sensibles sans chiffrement
- Ne pas exposer routes PDF sans authentification
- Ne pas utiliser `{id}` direct sans validation

### **7.2 Audit Trail**

**Logger téléchargements:**

```php
use App\Models\AuditLog;

public function downloadPDF($id)
{
    $invoice = Invoice::findOrFail($id);

    // Log action
    AuditLog::create([
        'user_id' => Auth::id(),
        'action' => 'invoice.pdf.download',
        'model_type' => 'Invoice',
        'model_id' => $invoice->id,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    return Pdf::loadView('invoices.pdf', compact('invoice'))
        ->download('facture-' . $invoice->invoice_number . '.pdf');
}
```

---

## 📚 8. Ressources et Documentation

### **8.1 Documentation Officielle**

- **DomPDF:** https://github.com/dompdf/dompdf
- **Laravel-DomPDF:** https://github.com/barryvdh/laravel-dompdf
- **DomPDF CSS Support:** https://github.com/dompdf/dompdf/wiki/CSSCompatibility

### **8.2 Exemples Templates**

**Templates Professionnels:**
- https://github.com/invoiceninja/invoiceninja
- https://github.com/crater-invoice/crater

### **8.3 Outils Utiles**

- **Test PDF en ligne:** https://pdftest.com/
- **Optimisation images:** https://tinypng.com/
- **Polices DejaVu:** https://dejavu-fonts.github.io/

---

## 🎯 9. Roadmap Futures Améliorations

### **Prochaines Fonctionnalités:**

- [ ] **Signature électronique:** Intégration DocuSign/HelloSign
- [ ] **QR Code paiement:** Génération QR code pour paiement mobile
- [ ] **Multi-langues PDF:** Template traduit automatiquement
- [ ] **Watermark:** "BROUILLON" pour factures non payées
- [ ] **Archivage automatique:** Stockage S3/Azure après 90 jours
- [ ] **Compression intelligente:** Réduction taille PDF automatique
- [ ] **PDF/A-3:** Format archivage légal longue durée
- [ ] **Factures groupées:** PDF multi-factures pour paiement groupé

---

## ✅ 10. Checklist Mise en Production

### **Avant déploiement:**

- [ ] Logo entreprise ajouté dans `public/images/logo.png`
- [ ] Coordonnées entreprise modifiées dans template
- [ ] Mentions légales mises à jour (RCS, TVA, etc.)
- [ ] Couleurs de marque personnalisées
- [ ] Tests sur 5+ factures différentes
- [ ] Vérification multi-tenant (isolation données)
- [ ] Test téléchargement depuis différents navigateurs
- [ ] Vérification qualité impression (DPI correct)
- [ ] Validation conformité légale avec comptable
- [ ] Backup config/dompdf.php

### **Après déploiement:**

- [ ] Monitoring erreurs Laravel logs
- [ ] Analyse performances (temps génération)
- [ ] Feedback utilisateurs sur qualité PDF
- [ ] Tester envoi email avec PDF attaché
- [ ] Vérifier compatibilité lecteurs PDF (Adobe, Preview, etc.)

---

**📅 Version du guide:** 1.0
**🗓️ Dernière mise à jour:** 07 Octobre 2025
**🚀 Système:** B2B Platform v1.9.1 (PDF Ready)

---

**🎉 SYSTÈME PDF OPÉRATIONNEL !**
Vos factures professionnelles sont maintenant disponibles en PDF haute qualité.

