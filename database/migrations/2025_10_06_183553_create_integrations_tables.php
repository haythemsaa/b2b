<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table des configurations d'intégrations ERP/Comptabilité
        if (!Schema::hasTable('integrations')) {
            Schema::create('integrations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
                $table->string('name'); // Nom de l'intégration
                $table->enum('type', [
                    'sap_b1',           // SAP Business One
                    'dynamics_365',     // Microsoft Dynamics 365
                    'sage',             // Sage Accounting
                    'quickbooks',       // QuickBooks
                    'odoo',             // Odoo ERP
                    'xero',             // Xero Accounting
                    'netsuite',         // Oracle NetSuite
                    'custom_api'        // API personnalisée
                ]);
                $table->enum('status', ['active', 'inactive', 'error', 'testing'])->default('inactive');
                $table->json('credentials')->nullable(); // Encrypted credentials
                $table->json('settings')->nullable(); // Configuration spécifique
                $table->enum('sync_direction', ['export', 'import', 'bidirectional'])->default('export');

                // Options de synchronisation
                $table->boolean('sync_products')->default(false);
                $table->boolean('sync_orders')->default(true);
                $table->boolean('sync_customers')->default(false);
                $table->boolean('sync_invoices')->default(true);
                $table->boolean('sync_inventory')->default(false);

                // Scheduling
                $table->enum('sync_frequency', ['manual', 'hourly', 'daily', 'weekly'])->default('manual');
                $table->timestamp('last_sync_at')->nullable();
                $table->timestamp('next_sync_at')->nullable();

                // Statistiques
                $table->integer('total_syncs')->default(0);
                $table->integer('successful_syncs')->default(0);
                $table->integer('failed_syncs')->default(0);
                $table->text('last_error')->nullable();

                $table->timestamps();
                $table->softDeletes();

                // Index
                $table->index(['tenant_id', 'type']);
                $table->index(['tenant_id', 'status']);
                $table->index('last_sync_at');
            });
        }

        // Table des logs de synchronisation
        if (!Schema::hasTable('integration_logs')) {
            Schema::create('integration_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('integration_id')->constrained('integrations')->onDelete('cascade');
                $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
                $table->enum('entity_type', ['product', 'order', 'customer', 'invoice', 'inventory', 'other']);
                $table->string('entity_id')->nullable(); // ID de l'entité dans notre système
                $table->string('external_id')->nullable(); // ID dans le système externe
                $table->enum('action', ['create', 'update', 'delete', 'sync']);
                $table->enum('direction', ['export', 'import']);
                $table->enum('status', ['success', 'failed', 'pending', 'partial']);
                $table->json('request_data')->nullable(); // Données envoyées
                $table->json('response_data')->nullable(); // Réponse reçue
                $table->text('error_message')->nullable();
                $table->integer('duration_ms')->nullable(); // Durée en millisecondes
                $table->timestamps();

                // Index
                $table->index(['integration_id', 'created_at']);
                $table->index(['tenant_id', 'entity_type']);
                $table->index(['status', 'created_at']);
                $table->index('external_id');
            });
        }

        // Table de mapping des IDs entre notre système et systèmes externes
        if (!Schema::hasTable('integration_mappings')) {
            Schema::create('integration_mappings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('integration_id')->constrained('integrations')->onDelete('cascade');
                $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
                $table->enum('entity_type', ['product', 'order', 'customer', 'invoice', 'category', 'other']);
                $table->string('internal_id'); // ID dans notre base
                $table->string('external_id'); // ID dans le système externe
                $table->json('metadata')->nullable(); // Infos additionnelles
                $table->timestamp('last_synced_at')->nullable();
                $table->timestamps();

                // Index et contraintes
                $table->unique(['integration_id', 'entity_type', 'internal_id'], 'unique_internal_mapping');
                $table->unique(['integration_id', 'entity_type', 'external_id'], 'unique_external_mapping');
                $table->index(['tenant_id', 'entity_type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integration_mappings');
        Schema::dropIfExists('integration_logs');
        Schema::dropIfExists('integrations');
    }
};
