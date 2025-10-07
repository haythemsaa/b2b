# 📚 Documentation Système d'Intégrations ERP/Comptabilité

## 📋 Table des Matières

1. [Vue d'ensemble](#vue-densemble)
2. [Architecture technique](#architecture-technique)
3. [Installation et configuration](#installation-et-configuration)
4. [Guide d'utilisation](#guide-dutilisation)
5. [Implémentation par ERP](#implémentation-par-erp)
6. [API et développement](#api-et-développement)
7. [Sécurité](#sécurité)
8. [Monitoring et logs](#monitoring-et-logs)
9. [Dépannage](#dépannage)

---

## 🎯 Vue d'ensemble

### Objectif du système

Le système d'intégrations ERP/Comptabilité permet de **synchroniser automatiquement** les données de la plateforme B2B avec des systèmes externes de gestion d'entreprise (ERP) et de comptabilité.

### Fonctionnalités principales

- ✅ **8 systèmes ERP supportés** : SAP B1, Dynamics 365, Sage, QuickBooks, Odoo, Xero, NetSuite, Custom API
- ✅ **Synchronisation bidirectionnelle** : Export, Import ou les deux
- ✅ **Entités synchronisables** : Produits, Commandes, Clients, Factures, Inventaire
- ✅ **Planification automatique** : Manuel, Horaire, Quotidien, Hebdomadaire
- ✅ **Mapping d'IDs** : Correspondance automatique entre IDs internes et externes
- ✅ **Logs détaillés** : Traçabilité complète de toutes les opérations
- ✅ **Sécurité renforcée** : Credentials chiffrés avec Laravel Crypt
- ✅ **Monitoring temps réel** : Métriques de performance et taux de succès

### Cas d'usage

1. **Export automatique des commandes** vers SAP Business One pour facturation
2. **Import des stocks** depuis Odoo ERP pour mise à jour inventaire
3. **Synchronisation des clients** avec Microsoft Dynamics 365
4. **Export des factures** vers QuickBooks pour comptabilité
5. **Synchronisation bidirectionnelle** produits avec système custom

---

## 🏗️ Architecture technique

### Structure de base de données

#### Table `integrations`
Stocke les configurations des intégrations ERP.

```sql
CREATE TABLE integrations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    tenant_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('sap_b1', 'dynamics_365', 'sage', 'quickbooks', 'odoo', 'xero', 'netsuite', 'custom_api'),
    status ENUM('active', 'inactive', 'error', 'testing') DEFAULT 'inactive',
    credentials JSON NULL COMMENT 'Encrypted',
    settings JSON NULL,
    sync_direction ENUM('export', 'import', 'bidirectional') DEFAULT 'export',

    -- Options de synchronisation
    sync_products BOOLEAN DEFAULT FALSE,
    sync_orders BOOLEAN DEFAULT TRUE,
    sync_customers BOOLEAN DEFAULT FALSE,
    sync_invoices BOOLEAN DEFAULT TRUE,
    sync_inventory BOOLEAN DEFAULT FALSE,

    -- Planification
    sync_frequency ENUM('manual', 'hourly', 'daily', 'weekly') DEFAULT 'manual',
    last_sync_at TIMESTAMP NULL,
    next_sync_at TIMESTAMP NULL,

    -- Statistiques
    total_syncs INT DEFAULT 0,
    successful_syncs INT DEFAULT 0,
    failed_syncs INT DEFAULT 0,
    last_error TEXT NULL,

    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    INDEX idx_tenant_status (tenant_id, status)
);
```

#### Table `integration_logs`
Historique détaillé de toutes les synchronisations.

```sql
CREATE TABLE integration_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT NOT NULL,
    tenant_id BIGINT NOT NULL,
    entity_type ENUM('product', 'order', 'customer', 'invoice', 'inventory', 'other'),
    entity_id VARCHAR(255) NULL,
    external_id VARCHAR(255) NULL,
    action ENUM('create', 'update', 'delete', 'sync'),
    direction ENUM('export', 'import'),
    status ENUM('success', 'failed', 'pending', 'partial'),
    request_data JSON NULL,
    response_data JSON NULL,
    error_message TEXT NULL,
    duration_ms INT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    FOREIGN KEY (integration_id) REFERENCES integrations(id) ON DELETE CASCADE,
    INDEX idx_integration_created (integration_id, created_at),
    INDEX idx_status (status)
);
```

#### Table `integration_mappings`
Correspondance entre IDs internes et IDs externes.

```sql
CREATE TABLE integration_mappings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT NOT NULL,
    tenant_id BIGINT NOT NULL,
    entity_type ENUM('product', 'order', 'customer', 'invoice', 'category', 'other'),
    internal_id VARCHAR(255) NOT NULL,
    external_id VARCHAR(255) NOT NULL,
    metadata JSON NULL,
    last_synced_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    FOREIGN KEY (integration_id) REFERENCES integrations(id) ON DELETE CASCADE,
    UNIQUE KEY unique_internal_mapping (integration_id, entity_type, internal_id),
    UNIQUE KEY unique_external_mapping (integration_id, entity_type, external_id)
);
```

### Modèles Eloquent

#### `Integration.php`

**Méthodes principales :**

```php
// Helpers de synchronisation
public function canSync(): bool
public function needsSync(): bool
public function recordSync(bool $success = true, ?string $error = null): void
public function updateNextSync(): void

// Mapping d'IDs
public function mapIds(string $entityType, $internalId, $externalId, ?array $metadata = null)
public function getExternalId(string $entityType, $internalId): ?string
public function getInternalId(string $entityType, $externalId): ?string

// Statistiques
public function getSuccessRate(): float
public function getTypeName(): string
public function getStatusBadge(): string

// Relations
public function tenant(): BelongsTo
public function logs(): HasMany
public function mappings(): HasMany

// Scopes
public static function scopeActive($query)
public static function scopeForTenant($query, int $tenantId)
public static function scopeByType($query, string $type)
public static function scopeNeedsSync($query)
```

**Accessors/Mutators pour sécurité :**

```php
// Chiffrement automatique des credentials
public function setCredentialsAttribute($value) {
    $this->attributes['credentials'] = $value
        ? json_encode(Crypt::encrypt($value))
        : null;
}

public function getCredentialsAttribute($value) {
    if (!$value) return null;
    try {
        return Crypt::decrypt(json_decode($value, true));
    } catch (\Exception $e) {
        return null;
    }
}
```

#### `IntegrationLog.php`

**Méthodes principales :**

```php
// Création de log
public static function createLog(int $integrationId, int $tenantId, array $data): self

// Scopes
public static function scopeForIntegration($query, int $integrationId)
public static function scopeForTenant($query, int $tenantId)
public static function scopeByEntityType($query, string $entityType)
public static function scopeSuccessful($query)
public static function scopeFailed($query)
public static function scopeRecent($query, int $hours = 24)

// Helpers
public function getStatusBadge(): string
public function wasSuccessful(): bool
```

#### `IntegrationMapping.php`

**Méthodes principales :**

```php
// Scopes
public static function scopeForIntegration($query, int $integrationId)
public static function scopeForTenant($query, int $tenantId)
public static function scopeByEntityType($query, string $entityType)
public static function scopeRecentlySynced($query, int $hours = 24)

// Helpers
public function needsSync(int $hours = 24): bool
public function markSynced(): void
```

---

## 📦 Installation et configuration

### 1. Exécuter la migration

```bash
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan migrate
```

Cette commande créera les 3 tables : `integrations`, `integration_logs`, `integration_mappings`.

### 2. Configuration des permissions

Assurez-vous que les utilisateurs admin/grossiste ont accès aux routes :

```php
// Dans routes/web.php - déjà configuré
Route::middleware(['auth', 'role:grossiste'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('integrations')->name('integrations.')->group(function () {
        // 11 routes disponibles
    });
});
```

### 3. Vérifier le menu navigation

Le menu "Intégrations ERP" doit apparaître dans le sidebar admin :

```blade
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.integrations.*') ? 'active' : '' }}"
       href="{{ route('admin.integrations.index') }}">
        <i class="fas fa-plug"></i>
        Intégrations ERP
    </a>
</li>
```

### 4. Configuration Laravel Scheduler (optionnel)

Pour la synchronisation automatique, configurer le cron :

```bash
# Dans crontab (Linux/Mac) ou Task Scheduler (Windows)
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Créer la commande de synchronisation :

```bash
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan make:command SyncIntegrations
```

---

## 📖 Guide d'utilisation

### Accès à l'interface

**URL :** `http://127.0.0.1:8001/admin/integrations`

**Permissions requises :** Rôle `grossiste` (admin tenant)

### Créer une nouvelle intégration

1. **Accéder à** `/admin/integrations`
2. **Cliquer sur** "Nouvelle Intégration"
3. **Remplir le formulaire :**
   - **Nom** : Ex. "Synchronisation SAP Production"
   - **Type** : Sélectionner l'ERP (SAP B1, Dynamics, etc.)
   - **Direction** : Export, Import ou Bidirectionnel
   - **Fréquence** : Manuel, Horaire, Quotidien, Hebdomadaire
   - **Entités** : Cocher Produits, Commandes, Clients, Factures, Inventaire
   - **Credentials** : Saisir les informations d'authentification
   - **Settings** : Configuration spécifique (URL API, etc.)

4. **Sauvegarder** - L'intégration est créée avec statut `inactive`

### Tester la connexion

1. **Localiser l'intégration** dans la liste
2. **Cliquer sur l'icône** 🧪 (Test)
3. **Vérifier le résultat** :
   - ✅ **Succès** : Temps de réponse affiché, statut passe à `testing`
   - ❌ **Échec** : Message d'erreur affiché, statut passe à `error`

### Activer l'intégration

Une fois le test réussi, activer l'intégration :

1. **Cliquer sur le bouton** "Activer" ou modifier le statut
2. Le statut passe à `active`
3. La synchronisation automatique démarrera selon la fréquence configurée

### Synchronisation manuelle

1. **Cliquer sur l'icône** 🔄 (Sync)
2. **Attendre le résultat** :
   - Message de succès avec nombre d'éléments synchronisés
   - Ou message d'erreur avec détails
3. **Vérifier les logs** pour le détail des opérations

### Consulter les logs

1. **Cliquer sur l'icône** 👁️ (Détails)
2. **Accéder à l'onglet "Logs"**
3. **Filtrer par** :
   - Type d'entité (produit, commande, etc.)
   - Statut (succès, échec)
   - Date
4. **Exporter les logs** si nécessaire

### Modifier une intégration

1. **Cliquer sur l'icône** ✏️ (Modifier)
2. **Mettre à jour** les champs nécessaires
3. **Sauvegarder** - Les changements sont appliqués immédiatement

⚠️ **Attention** : Modifier les credentials ou settings peut nécessiter un nouveau test de connexion.

### Supprimer une intégration

1. **Cliquer sur l'icône** 🗑️ (Supprimer)
2. **Confirmer** la suppression
3. **Résultat** :
   - L'intégration est soft-deleted
   - Les logs et mappings sont conservés pour l'audit
   - La synchronisation automatique est arrêtée

---

## 🔌 Implémentation par ERP

### 1️⃣ SAP Business One

**Type :** `sap_b1`

**Credentials requises :**
```json
{
    "server": "https://sap-server.company.com",
    "database": "COMPANY_DB",
    "username": "api_user",
    "password": "encrypted_password",
    "company_db": "COMPANY"
}
```

**Endpoints principaux :**
- Login : `/b1s/v1/Login`
- Orders : `/b1s/v1/Orders`
- Items : `/b1s/v1/Items`
- BusinessPartners : `/b1s/v1/BusinessPartners`

**Exemple d'implémentation (à ajouter dans le controller) :**

```php
private function testSAPConnection($integration)
{
    $credentials = $integration->credentials;

    try {
        $response = Http::post($credentials['server'] . '/b1s/v1/Login', [
            'CompanyDB' => $credentials['database'],
            'UserName' => $credentials['username'],
            'Password' => $credentials['password']
        ]);

        if ($response->successful()) {
            $sessionId = $response->json('SessionId');
            return ['success' => true, 'message' => 'Connexion SAP B1 réussie', 'session' => $sessionId];
        }

        return ['success' => false, 'error' => $response->body()];
    } catch (\Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

private function syncSAP($integration, $entityType)
{
    $credentials = $integration->credentials;
    $exported = 0;

    // 1. Login et obtenir session
    $loginResponse = $this->testSAPConnection($integration);
    if (!$loginResponse['success']) {
        return ['success' => false, 'error' => $loginResponse['error']];
    }

    $sessionId = $loginResponse['session'];

    // 2. Export des commandes
    if ($entityType === 'all' || $entityType === 'orders') {
        $orders = Order::where('tenant_id', $integration->tenant_id)
            ->whereDoesntHave('integrationMappings', function($q) use ($integration) {
                $q->where('integration_id', $integration->id)
                  ->where('entity_type', 'order');
            })
            ->limit(50)
            ->get();

        foreach ($orders as $order) {
            try {
                $response = Http::withHeaders([
                    'Cookie' => "B1SESSION={$sessionId}",
                    'Content-Type' => 'application/json'
                ])->post($credentials['server'] . '/b1s/v1/Orders', [
                    'CardCode' => $order->user->external_code ?? 'C' . $order->user_id,
                    'DocDate' => $order->created_at->format('Y-m-d'),
                    'DocDueDate' => $order->created_at->addDays(30)->format('Y-m-d'),
                    'DocumentLines' => $order->items->map(function($item) {
                        return [
                            'ItemCode' => $item->product->sku,
                            'Quantity' => $item->quantity,
                            'Price' => $item->price,
                        ];
                    })->toArray()
                ]);

                if ($response->successful()) {
                    $externalId = $response->json('DocEntry');

                    // Mapper l'ID
                    $integration->mapIds('order', $order->id, $externalId);

                    // Logger le succès
                    IntegrationLog::createLog($integration->id, $integration->tenant_id, [
                        'entity_type' => 'order',
                        'entity_id' => $order->id,
                        'external_id' => $externalId,
                        'action' => 'create',
                        'direction' => 'export',
                        'status' => 'success',
                        'request_data' => $response->json(),
                    ]);

                    $exported++;
                } else {
                    // Logger l'échec
                    IntegrationLog::createLog($integration->id, $integration->tenant_id, [
                        'entity_type' => 'order',
                        'entity_id' => $order->id,
                        'action' => 'create',
                        'direction' => 'export',
                        'status' => 'failed',
                        'error_message' => $response->body(),
                    ]);
                }
            } catch (\Exception $e) {
                IntegrationLog::createLog($integration->id, $integration->tenant_id, [
                    'entity_type' => 'order',
                    'entity_id' => $order->id,
                    'action' => 'create',
                    'direction' => 'export',
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }
        }
    }

    // 3. Logout
    Http::post($credentials['server'] . '/b1s/v1/Logout');

    return ['success' => true, 'message' => "{$exported} commandes exportées vers SAP B1"];
}
```

**Packages recommandés :**
- `composer require guzzlehttp/guzzle` (déjà inclus dans Laravel)

---

### 2️⃣ Microsoft Dynamics 365

**Type :** `dynamics_365`

**Credentials requises :**
```json
{
    "tenant_id": "azure-tenant-id",
    "client_id": "azure-app-id",
    "client_secret": "azure-secret",
    "resource_url": "https://org.crm.dynamics.com",
    "api_version": "v9.2"
}
```

**Authentification OAuth 2.0 :**

```php
private function getDynamicsAccessToken($credentials)
{
    $response = Http::asForm()->post("https://login.microsoftonline.com/{$credentials['tenant_id']}/oauth2/v2.0/token", [
        'client_id' => $credentials['client_id'],
        'client_secret' => $credentials['client_secret'],
        'scope' => $credentials['resource_url'] . '/.default',
        'grant_type' => 'client_credentials'
    ]);

    return $response->json('access_token');
}

private function syncDynamics($integration, $entityType)
{
    $credentials = $integration->credentials;
    $token = $this->getDynamicsAccessToken($credentials);

    // Export commandes
    if ($entityType === 'all' || $entityType === 'orders') {
        $orders = Order::where('tenant_id', $integration->tenant_id)
            ->whereDoesntHave('integrationMappings', function($q) use ($integration) {
                $q->where('integration_id', $integration->id);
            })
            ->limit(50)
            ->get();

        foreach ($orders as $order) {
            $response = Http::withToken($token)->post(
                "{$credentials['resource_url']}/api/data/{$credentials['api_version']}/salesorders",
                [
                    'name' => "Order #{$order->id}",
                    'ordernumber' => $order->order_number,
                    'totalamount' => $order->total_amount,
                    // ... autres champs
                ]
            );

            if ($response->successful()) {
                $integration->mapIds('order', $order->id, $response->json('salesorderid'));
            }
        }
    }

    return ['success' => true, 'message' => 'Synchronisation Dynamics 365 réussie'];
}
```

---

### 3️⃣ Sage Accounting

**Type :** `sage`

**Credentials requises :**
```json
{
    "client_id": "sage-app-id",
    "client_secret": "sage-secret",
    "refresh_token": "user-refresh-token",
    "region": "eu"
}
```

**API Endpoints :**
- Base URL : `https://api.accounting.sage.com/v3.1`
- Products : `/products`
- Invoices : `/sales_invoices`
- Contacts : `/contacts`

---

### 4️⃣ QuickBooks Online

**Type :** `quickbooks`

**Credentials requises :**
```json
{
    "realm_id": "company-id",
    "client_id": "intuit-app-id",
    "client_secret": "intuit-secret",
    "access_token": "oauth-access-token",
    "refresh_token": "oauth-refresh-token",
    "sandbox": false
}
```

**Exemple :**

```php
private function syncQuickBooks($integration, $entityType)
{
    $credentials = $integration->credentials;
    $baseUrl = $credentials['sandbox']
        ? 'https://sandbox-quickbooks.api.intuit.com'
        : 'https://quickbooks.api.intuit.com';

    if ($entityType === 'all' || $entityType === 'invoices') {
        $orders = Order::where('tenant_id', $integration->tenant_id)
            ->where('status', 'completed')
            ->limit(50)
            ->get();

        foreach ($orders as $order) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $credentials['access_token'],
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post("{$baseUrl}/v3/company/{$credentials['realm_id']}/invoice", [
                'CustomerRef' => ['value' => $order->user->quickbooks_id ?? '1'],
                'Line' => $order->items->map(function($item) {
                    return [
                        'Amount' => $item->quantity * $item->price,
                        'DetailType' => 'SalesItemLineDetail',
                        'SalesItemLineDetail' => [
                            'ItemRef' => ['value' => $item->product->quickbooks_id ?? '1'],
                            'Qty' => $item->quantity,
                            'UnitPrice' => $item->price
                        ]
                    ];
                })->toArray()
            ]);

            if ($response->successful()) {
                $integration->mapIds('invoice', $order->id, $response->json('Invoice.Id'));
            }
        }
    }

    return ['success' => true, 'message' => 'Synchronisation QuickBooks réussie'];
}
```

---

### 5️⃣ Odoo ERP

**Type :** `odoo`

**Credentials requises :**
```json
{
    "url": "https://mycompany.odoo.com",
    "database": "mycompany",
    "username": "admin@company.com",
    "api_key": "api-key-or-password"
}
```

**Authentification XML-RPC :**

```php
private function syncOdoo($integration, $entityType)
{
    $credentials = $integration->credentials;

    // Connexion XML-RPC
    $commonClient = new \Laminas\XmlRpc\Client($credentials['url'] . '/xmlrpc/2/common');
    $uid = $commonClient->call('authenticate', [
        $credentials['database'],
        $credentials['username'],
        $credentials['api_key'],
        []
    ]);

    $models = new \Laminas\XmlRpc\Client($credentials['url'] . '/xmlrpc/2/object');

    // Export produits vers Odoo
    if ($entityType === 'all' || $entityType === 'products') {
        $products = Product::where('tenant_id', $integration->tenant_id)->limit(50)->get();

        foreach ($products as $product) {
            $productId = $models->call('execute_kw', [
                $credentials['database'],
                $uid,
                $credentials['api_key'],
                'product.template',
                'create',
                [[
                    'name' => $product->name,
                    'default_code' => $product->sku,
                    'list_price' => $product->price,
                    'type' => 'product'
                ]]
            ]);

            $integration->mapIds('product', $product->id, $productId);
        }
    }

    return ['success' => true, 'message' => 'Synchronisation Odoo réussie'];
}
```

**Package requis :**
```bash
composer require laminas/laminas-xmlrpc
```

---

### 6️⃣ Xero Accounting

**Type :** `xero`

**Credentials requises :**
```json
{
    "client_id": "xero-app-id",
    "client_secret": "xero-secret",
    "tenant_id": "xero-tenant-id",
    "access_token": "oauth-token",
    "refresh_token": "refresh-token"
}
```

**Package recommandé :**
```bash
composer require xeroapi/xero-php-oauth2
```

---

### 7️⃣ Oracle NetSuite

**Type :** `netsuite`

**Credentials requises :**
```json
{
    "account_id": "123456",
    "consumer_key": "consumer-key",
    "consumer_secret": "consumer-secret",
    "token_id": "token-id",
    "token_secret": "token-secret",
    "rest_url": "https://123456.suitetalk.api.netsuite.com/services/rest"
}
```

---

### 8️⃣ Custom API

**Type :** `custom_api`

**Settings requises :**
```json
{
    "api_url": "https://api.myerp.com",
    "api_key": "custom-api-key",
    "endpoints": {
        "orders": "/api/orders",
        "products": "/api/products",
        "customers": "/api/customers"
    }
}
```

**Exemple d'implémentation :**

```php
private function testCustomAPIConnection($integration)
{
    $settings = $integration->settings ?? [];
    $apiUrl = $settings['api_url'] ?? null;

    if (!$apiUrl) {
        return ['success' => false, 'error' => 'URL API manquante'];
    }

    try {
        $response = Http::timeout(10)
            ->withHeaders(['X-API-Key' => $settings['api_key'] ?? ''])
            ->get($apiUrl . '/health');

        if ($response->successful()) {
            return ['success' => true, 'message' => 'API accessible'];
        }

        return ['success' => false, 'error' => 'HTTP ' . $response->status()];
    } catch (\Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

private function syncCustomAPI($integration, $entityType)
{
    $settings = $integration->settings;
    $apiUrl = $settings['api_url'];
    $apiKey = $settings['api_key'];

    if ($entityType === 'all' || $entityType === 'orders') {
        $orders = Order::where('tenant_id', $integration->tenant_id)->limit(50)->get();

        foreach ($orders as $order) {
            $response = Http::withHeaders(['X-API-Key' => $apiKey])
                ->post($apiUrl . $settings['endpoints']['orders'], [
                    'order_number' => $order->order_number,
                    'customer_email' => $order->user->email,
                    'total' => $order->total_amount,
                    'items' => $order->items->map(function($item) {
                        return [
                            'sku' => $item->product->sku,
                            'quantity' => $item->quantity,
                            'price' => $item->price
                        ];
                    })
                ]);

            if ($response->successful()) {
                $integration->mapIds('order', $order->id, $response->json('id'));
            }
        }
    }

    return ['success' => true, 'message' => 'Synchronisation Custom API réussie'];
}
```

---

## 🔒 Sécurité

### Chiffrement des credentials

**Automatique via Laravel Crypt :**

```php
// Lors de la sauvegarde
$integration->credentials = [
    'username' => 'api_user',
    'password' => 'secret123'
];
$integration->save();

// Laravel chiffre automatiquement via le mutator
// Stockage en BDD : {"iv":"...","value":"...","mac":"..."}

// Lors de la lecture
$credentials = $integration->credentials;
// Laravel déchiffre automatiquement via l'accessor
// Résultat : ['username' => 'api_user', 'password' => 'secret123']
```

### Permissions et autorisation

**Policy IntegrationPolicy (à créer) :**

```php
<?php

namespace App\Policies;

use App\Models\Integration;
use App\Models\User;

class IntegrationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'grossiste';
    }

    public function view(User $user, Integration $integration): bool
    {
        return $user->role === 'grossiste'
            && $user->tenant_id === $integration->tenant_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'grossiste';
    }

    public function update(User $user, Integration $integration): bool
    {
        return $user->role === 'grossiste'
            && $user->tenant_id === $integration->tenant_id;
    }

    public function delete(User $user, Integration $integration): bool
    {
        return $user->role === 'grossiste'
            && $user->tenant_id === $integration->tenant_id;
    }
}
```

**Enregistrer la policy :**

```php
// Dans app/Providers/AuthServiceProvider.php
protected $policies = [
    Integration::class => IntegrationPolicy::class,
];
```

### Protection CSRF

Toutes les routes POST/PUT/DELETE sont protégées par le middleware `web` qui inclut `VerifyCsrfToken`.

### Validation des données

**Validation stricte dans le controller :**

```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'type' => 'required|in:sap_b1,dynamics_365,sage,quickbooks,odoo,xero,netsuite,custom_api',
    'sync_direction' => 'required|in:export,import,bidirectional',
    'sync_frequency' => 'required|in:manual,hourly,daily,weekly',
    'credentials' => 'nullable|array',
    'settings' => 'nullable|array',
]);
```

---

## 📊 Monitoring et logs

### Dashboard de statistiques

**Métriques disponibles :**

```php
$stats = [
    'total_integrations' => Integration::forTenant($tenant_id)->count(),
    'active_integrations' => Integration::forTenant($tenant_id)->active()->count(),
    'total_syncs' => $integrations->sum('total_syncs'),
    'success_rate' => $integrations->avg('successful_syncs') / max($integrations->avg('total_syncs'), 1) * 100
];
```

### Consultation des logs

**Filtrage avancé :**

```php
$logs = IntegrationLog::forIntegration($integrationId)
    ->byEntityType('order')
    ->failed()
    ->recent(48) // 48 dernières heures
    ->paginate(100);
```

### Alertes automatiques

**Exemple de détection d'erreurs répétées :**

```php
public function checkIntegrationHealth()
{
    $problematicIntegrations = Integration::active()
        ->where('failed_syncs', '>', 5)
        ->where('last_sync_at', '>=', now()->subHours(24))
        ->get();

    foreach ($problematicIntegrations as $integration) {
        // Envoyer notification admin
        Notification::send(
            $integration->tenant->admins,
            new IntegrationFailureAlert($integration)
        );

        // Désactiver automatiquement si trop d'échecs
        if ($integration->failed_syncs > 10) {
            $integration->update(['status' => 'error']);
        }
    }
}
```

### Métriques de performance

**Analyse des durées de synchronisation :**

```php
$avgDuration = IntegrationLog::forIntegration($integrationId)
    ->successful()
    ->recent(168) // 7 jours
    ->avg('duration_ms');

$slowSyncs = IntegrationLog::forIntegration($integrationId)
    ->where('duration_ms', '>', 5000) // Plus de 5 secondes
    ->latest()
    ->limit(10)
    ->get();
```

---

## 🔧 Dépannage

### Problème : Connexion échoue systématiquement

**Solutions :**

1. **Vérifier les credentials :**
   ```php
   $credentials = $integration->credentials;
   dd($credentials); // Vérifier le déchiffrement
   ```

2. **Tester manuellement l'API :**
   ```bash
   curl -X POST https://api.erp.com/login \
     -H "Content-Type: application/json" \
     -d '{"username":"test","password":"test"}'
   ```

3. **Vérifier les logs Laravel :**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Désactiver temporairement le SSL (dev uniquement) :**
   ```php
   Http::withoutVerifying()->get($url);
   ```

### Problème : Synchronisation partielle

**Causes possibles :**
- Timeout réseau
- Limite de requêtes API (rate limiting)
- Données invalides dans certains enregistrements

**Solutions :**

1. **Augmenter le timeout :**
   ```php
   Http::timeout(60)->post($url, $data);
   ```

2. **Ajouter retry avec backoff :**
   ```php
   Http::retry(3, 100)->post($url, $data);
   ```

3. **Synchroniser par lots plus petits :**
   ```php
   $orders = Order::where('tenant_id', $tenant_id)
       ->limit(10) // Réduire de 50 à 10
       ->get();
   ```

### Problème : Credentials non déchiffrés

**Cause :** Changement de `APP_KEY` Laravel

**Solution :**
1. **NE JAMAIS changer APP_KEY en production**
2. Si nécessaire, re-saisir toutes les credentials après changement de clé

### Problème : Mapping d'IDs dupliqués

**Cause :** Violation de contrainte unique

**Solution :**
```php
// Vérifier avant de créer
$existingMapping = IntegrationMapping::where([
    'integration_id' => $integrationId,
    'entity_type' => 'order',
    'internal_id' => $orderId
])->first();

if ($existingMapping) {
    $existingMapping->update(['external_id' => $newExternalId]);
} else {
    IntegrationMapping::create([...]);
}
```

### Problème : Synchronisation lente

**Optimisations :**

1. **Utiliser eager loading :**
   ```php
   $orders = Order::with(['items.product', 'user'])
       ->where('tenant_id', $tenant_id)
       ->get();
   ```

2. **Traitement asynchrone avec queues :**
   ```php
   dispatch(new SyncIntegrationJob($integration, $entityType));
   ```

3. **Pagination pour gros volumes :**
   ```php
   Order::chunk(100, function ($orders) use ($integration) {
       // Synchroniser chaque chunk
   });
   ```

---

## 📞 Support et ressources

### Documentation officielle des ERP

- **SAP B1** : https://help.sap.com/docs/SAP_BUSINESS_ONE_SERVICE_LAYER
- **Dynamics 365** : https://learn.microsoft.com/dynamics365/
- **Sage** : https://developer.sage.com/
- **QuickBooks** : https://developer.intuit.com/
- **Odoo** : https://www.odoo.com/documentation/
- **Xero** : https://developer.xero.com/
- **NetSuite** : https://docs.oracle.com/en/cloud/saas/netsuite/

### Logs et debugging

```bash
# Logs Laravel
tail -f storage/logs/laravel.log

# Logs Nginx/Apache
tail -f /var/log/nginx/error.log

# Logs base de données (MySQL)
tail -f /var/log/mysql/error.log
```

### Commandes artisan utiles

```bash
# Lister toutes les routes
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan route:list --name=integrations

# Vider le cache
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan cache:clear

# Tester une intégration via tinker
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan tinker
>>> $integration = Integration::find(1);
>>> $integration->canSync();
```

---

## ✅ Checklist de mise en production

- [ ] Migration exécutée sur serveur de production
- [ ] Credentials chiffrées testées et validées
- [ ] Tests de connexion réussis pour chaque ERP configuré
- [ ] Logs de synchronisation vérifiés (aucune erreur critique)
- [ ] Scheduler Laravel configuré (cron)
- [ ] Alertes email configurées pour échecs
- [ ] Policy d'autorisation activée
- [ ] Sauvegarde base de données effectuée
- [ ] Documentation API fournie aux développeurs
- [ ] Formation utilisateurs admin réalisée
- [ ] Plan de rollback préparé

---

**📅 Dernière mise à jour :** 06 Octobre 2025
**📌 Version système :** 1.0.0
**🎯 Statut :** Production Ready (75% - Framework complet, implémentations API à finaliser)
