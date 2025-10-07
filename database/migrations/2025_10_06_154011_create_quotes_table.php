<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table principale des devis
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('quote_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Vendeur
            $table->foreignId('grossiste_id')->constrained('users')->onDelete('cascade'); // Grossiste

            // Informations client
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->text('customer_address')->nullable();

            // Montants
            $table->decimal('subtotal', 10, 3)->default(0);
            $table->decimal('tax_amount', 10, 3)->default(0);
            $table->decimal('discount_amount', 10, 3)->default(0);
            $table->decimal('total', 10, 3)->default(0);

            // Statut et validité
            $table->enum('status', ['draft', 'sent', 'viewed', 'accepted', 'rejected', 'expired', 'converted'])->default('draft');
            $table->date('valid_until')->nullable();
            $table->date('accepted_at')->nullable();
            $table->date('rejected_at')->nullable();
            $table->foreignId('converted_order_id')->nullable()->constrained('orders')->onDelete('set null');

            // Notes et conditions
            $table->text('notes')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->text('internal_notes')->nullable();

            // Métadonnées
            $table->string('currency', 3)->default('TND');
            $table->decimal('tax_rate', 5, 2)->default(19);
            $table->string('payment_terms')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'user_id']);
            $table->index(['tenant_id', 'status']);
            $table->index('quote_number');
        });

        // Table des items du devis
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('product_name');
            $table->string('product_sku');
            $table->text('product_description')->nullable();

            $table->integer('quantity');
            $table->decimal('unit_price', 10, 3);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 10, 3)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('subtotal', 10, 3);
            $table->decimal('total', 10, 3);

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('quote_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
        Schema::dropIfExists('quotes');
    }
};
