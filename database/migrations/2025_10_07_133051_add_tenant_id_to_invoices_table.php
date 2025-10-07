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
        Schema::table('invoices', function (Blueprint $table) {
            // Add tenant_id column if it doesn't exist
            if (!Schema::hasColumn('invoices', 'tenant_id')) {
                $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->onDelete('cascade');
                $table->index('tenant_id');
            }
        });

        // Update existing invoices with tenant_id from their related order (if order_id column exists)
        if (Schema::hasColumn('invoices', 'order_id')) {
            DB::statement('
                UPDATE invoices
                INNER JOIN orders ON invoices.order_id = orders.id
                SET invoices.tenant_id = orders.tenant_id
                WHERE invoices.order_id IS NOT NULL AND invoices.tenant_id IS NULL
            ');
        }

        // For invoices without order (subscription-based), set tenant_id from subscription
        if (Schema::hasColumn('invoices', 'subscription_id')) {
            DB::statement('
                UPDATE invoices
                INNER JOIN subscriptions ON invoices.subscription_id = subscriptions.id
                SET invoices.tenant_id = subscriptions.tenant_id
                WHERE invoices.subscription_id IS NOT NULL AND invoices.tenant_id IS NULL
            ');
        }

        // Set default tenant_id = 1 for any remaining invoices without tenant_id
        DB::statement('UPDATE invoices SET tenant_id = 1 WHERE tenant_id IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'tenant_id')) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            }
        });
    }
};
