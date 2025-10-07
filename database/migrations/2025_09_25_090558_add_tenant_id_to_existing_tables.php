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
        // Tables principales nécessitant un tenant_id
        $tables = [
            'users', 'categories', 'products', 'customer_groups',
            'custom_prices', 'orders', 'order_items', 'messages',
            'promotions', 'promotion_products', 'promotion_users',
            'product_returns'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->unsignedBigInteger('tenant_id')->nullable()->after('id');
                    $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
                    $table->index('tenant_id');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users', 'categories', 'products', 'customer_groups',
            'custom_prices', 'orders', 'order_items', 'messages',
            'promotions', 'promotion_products', 'promotion_users',
            'product_returns'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['tenant_id']);
                    $table->dropIndex(['tenant_id']);
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
