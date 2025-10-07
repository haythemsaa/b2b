<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Indexes pour la table products
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Vérifier et créer les index seulement s'ils n'existent pas
                $this->addIndexIfNotExists('products', ['tenant_id', 'is_active', 'stock_quantity'], 'idx_products_tenant_active_stock');
                $this->addIndexIfNotExists('products', ['category_id', 'is_active'], 'idx_products_category_active');
                $this->addIndexIfNotExists('products', 'sku', 'idx_products_sku');
                $this->addIndexIfNotExists('products', 'name', 'idx_products_name');
            });
        }

        // Indexes pour la table orders
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->index(['tenant_id', 'status'], 'idx_orders_tenant_status');
                $table->index(['user_id', 'status'], 'idx_orders_user_status');
                $table->index('created_at', 'idx_orders_created_at');
                $table->index('order_number', 'idx_orders_order_number');
            });
        }

        // Indexes pour la table users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index(['tenant_id', 'role'], 'idx_users_tenant_role');
                $table->index(['tenant_id', 'is_active'], 'idx_users_tenant_active');
                // Index group_id seulement si la colonne existe
                if (Schema::hasColumn('users', 'group_id')) {
                    $table->index('group_id', 'idx_users_group');
                }
            });
        }

        // Indexes pour la table quotes
        if (Schema::hasTable('quotes')) {
            Schema::table('quotes', function (Blueprint $table) {
                $table->index(['tenant_id', 'status'], 'idx_quotes_tenant_status');
                $table->index(['user_id', 'status'], 'idx_quotes_user_status');
                $table->index('valid_until', 'idx_quotes_valid_until');
                $table->index('quote_number', 'idx_quotes_quote_number');
            });
        }

        // Indexes pour la table carts
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->index(['user_id', 'tenant_id'], 'idx_carts_user_tenant');
            });
        }

        // Indexes pour la table categories
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->index(['tenant_id', 'parent_id'], 'idx_categories_tenant_parent');
                $table->index('slug', 'idx_categories_slug');
            });
        }

        // Indexes pour la table integrations
        if (Schema::hasTable('integrations')) {
            Schema::table('integrations', function (Blueprint $table) {
                $table->index(['tenant_id', 'status', 'type'], 'idx_integrations_tenant_status_type');
                $table->index('next_sync_at', 'idx_integrations_next_sync');
            });
        }

        // Indexes pour la table integration_logs
        if (Schema::hasTable('integration_logs')) {
            Schema::table('integration_logs', function (Blueprint $table) {
                $table->index(['integration_id', 'status'], 'idx_int_logs_integration_status');
                $table->index('created_at', 'idx_int_logs_created_at');
            });
        }

        // Indexes pour la table custom_prices
        if (Schema::hasTable('custom_prices')) {
            Schema::table('custom_prices', function (Blueprint $table) {
                $table->index(['product_id', 'group_id'], 'idx_custom_prices_product_group');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropIndex('idx_products_tenant_active_stock');
                $table->dropIndex('idx_products_category_active');
                $table->dropIndex('idx_products_sku');
                $table->dropIndex('idx_products_name');
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropIndex('idx_orders_tenant_status');
                $table->dropIndex('idx_orders_user_status');
                $table->dropIndex('idx_orders_created_at');
                $table->dropIndex('idx_orders_order_number');
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex('idx_users_tenant_role');
                $table->dropIndex('idx_users_tenant_active');
                $table->dropIndex('idx_users_group');
            });
        }

        if (Schema::hasTable('quotes')) {
            Schema::table('quotes', function (Blueprint $table) {
                $table->dropIndex('idx_quotes_tenant_status');
                $table->dropIndex('idx_quotes_user_status');
                $table->dropIndex('idx_quotes_valid_until');
                $table->dropIndex('idx_quotes_quote_number');
            });
        }

        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropIndex('idx_carts_user_tenant');
            });
        }

        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropIndex('idx_categories_tenant_parent');
                $table->dropIndex('idx_categories_slug');
            });
        }

        if (Schema::hasTable('integrations')) {
            Schema::table('integrations', function (Blueprint $table) {
                $table->dropIndex('idx_integrations_tenant_status_type');
                $table->dropIndex('idx_integrations_next_sync');
            });
        }

        if (Schema::hasTable('integration_logs')) {
            Schema::table('integration_logs', function (Blueprint $table) {
                $table->dropIndex('idx_int_logs_integration_status');
                $table->dropIndex('idx_int_logs_created_at');
            });
        }

        if (Schema::hasTable('custom_prices')) {
            Schema::table('custom_prices', function (Blueprint $table) {
                $table->dropIndex('idx_custom_prices_product_group');
            });
        }
    }
};
