<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('brand')->nullable();
            $table->string('unit')->default('piece'); // piece, carton, kg, etc.
            $table->decimal('base_price', 10, 3)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_order_quantity')->default(1);
            $table->integer('order_multiple')->default(1);
            $table->integer('stock_alert_threshold')->default(10);
            $table->json('images')->nullable();
            $table->json('attributes')->nullable(); // couleur, taille, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['is_active', 'category_id']);
            $table->index('sku');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};