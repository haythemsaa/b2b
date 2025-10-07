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
        Schema::table('product_images', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')->constrained('tenants')->onDelete('cascade');
        });

        // Mettre à jour les enregistrements existants avec le tenant_id du produit
        DB::statement('
            UPDATE product_images pi
            INNER JOIN products p ON pi.product_id = p.id
            SET pi.tenant_id = p.tenant_id
            WHERE pi.tenant_id IS NULL
        ');

        // Rendre la colonne non nullable après avoir mis à jour les données
        Schema::table('product_images', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};
