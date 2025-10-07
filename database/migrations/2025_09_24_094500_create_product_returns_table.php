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
        Schema::create('product_returns', function (Blueprint $table) {
            $table->id();
            $table->string('rma_number')->unique();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Vendeur qui demande le retour
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity_returned');
            $table->enum('reason', [
                'defective',
                'wrong_item',
                'not_as_described',
                'damaged_shipping',
                'expired',
                'other'
            ]);
            $table->text('reason_details')->nullable();
            $table->enum('condition', ['unopened', 'opened', 'damaged', 'unusable']);
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'processing',
                'completed',
                'refunded'
            ])->default('pending');
            $table->enum('return_type', ['refund', 'replacement', 'credit']);
            $table->decimal('refund_amount', 10, 3)->nullable();
            $table->json('images')->nullable(); // Photos du produit retourné
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
            $table->index('rma_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_returns');
    }
};
