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
        // Create product_attributes table
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['select', 'radio', 'color', 'text']);
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index('type');
        });

        // Create product_attribute_values table
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_attribute_id')->constrained('product_attributes')->onDelete('cascade');
            $table->string('value');
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index('product_attribute_id');
        });

        // Create product_attribute_product pivot table
        Schema::create('product_attribute_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_attribute_value_id')->constrained('product_attribute_values')->onDelete('cascade');
            $table->decimal('price_impact', 10, 2)->nullable();
            $table->timestamps();

            $table->index('product_id');
            $table->index('product_attribute_value_id');
            $table->unique(['product_id', 'product_attribute_value_id'], 'product_attr_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_product');
        Schema::dropIfExists('product_attribute_values');
        Schema::dropIfExists('product_attributes');
    }
};
