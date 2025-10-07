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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom commercial du grossiste
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->string('domain')->nullable(); // Domaine personnalisé
            $table->string('email'); // Email principal
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('TN');

            // Branding
            $table->string('logo_url')->nullable();
            $table->json('brand_colors')->nullable(); // primary, secondary, accent
            $table->string('favicon_url')->nullable();

            // Configuration
            $table->string('default_currency', 3)->default('TND');
            $table->string('default_language', 2)->default('fr');
            $table->json('supported_languages')->default('["fr", "ar"]');
            $table->string('timezone')->default('Africa/Tunis');

            // Plan & Quotas
            $table->enum('plan', ['starter', 'pro', 'enterprise'])->default('starter');
            $table->integer('max_users')->default(50);
            $table->integer('max_products')->default(1000);
            $table->decimal('monthly_fee', 10, 2)->default(0);

            // Modules activés
            $table->json('enabled_modules')->default('[]'); // chat, rma, multi_warehouse, etc.

            // Statut & Meta
            $table->boolean('is_active')->default(true);
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('last_payment_at')->nullable();
            $table->json('settings')->nullable(); // paramètres spécifiques

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'plan']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
