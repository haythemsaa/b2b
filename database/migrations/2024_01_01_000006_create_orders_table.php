<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', [
                'pending',
                'confirmed',
                'preparing',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');
            $table->decimal('subtotal', 10, 3)->default(0);
            $table->decimal('discount_amount', 10, 3)->default(0);
            $table->decimal('total_amount', 10, 3)->default(0);
            $table->string('currency', 3)->default('TND');
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'status']);
            $table->index('order_number');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};