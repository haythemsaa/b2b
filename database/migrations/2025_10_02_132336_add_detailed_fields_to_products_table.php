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
        Schema::table('products', function (Blueprint $table) {
            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('short_description')->nullable();

            // Product Identity (skip 'brand' as it already exists)
            $table->string('manufacturer')->nullable();
            $table->string('supplier_reference')->nullable();
            $table->string('ean13', 13)->nullable();
            $table->string('upc', 12)->nullable();
            $table->string('isbn', 32)->nullable();

            // Physical Properties
            $table->decimal('weight', 10, 3)->nullable()->comment('in kg');
            $table->decimal('width', 10, 2)->nullable()->comment('in cm');
            $table->decimal('height', 10, 2)->nullable()->comment('in cm');
            $table->decimal('depth', 10, 2)->nullable()->comment('in cm');

            // Advanced Stock
            $table->integer('min_quantity')->default(1);
            $table->integer('low_stock_threshold')->nullable();
            $table->boolean('available_for_order')->default(true);
            $table->string('availability')->nullable();
            $table->date('available_date')->nullable();

            // Advanced Pricing
            $table->decimal('wholesale_price', 10, 2)->nullable();
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->boolean('on_sale')->default(false);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->date('sale_start_date')->nullable();
            $table->date('sale_end_date')->nullable();

            // Display Options
            $table->boolean('show_price')->default(true);
            $table->boolean('featured')->default(false);
            $table->boolean('new_arrival')->default(false);
            $table->integer('position')->default(0);
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('new');

            // Technical Information
            $table->json('features')->nullable();
            $table->json('technical_specs')->nullable();
            $table->text('additional_info')->nullable();

            // Shipping
            $table->boolean('free_shipping')->default(false);
            $table->string('delivery_time')->nullable();
            $table->decimal('additional_shipping_cost', 10, 2)->nullable();

            // Customization
            $table->boolean('customizable')->default(false);
            $table->text('customization_text')->nullable();
            $table->integer('text_fields')->default(0);

            // Media
            $table->string('video_url')->nullable();
            $table->json('attachments')->nullable();

            // Indexes (brand index may already exist, but we'll add indexes for new columns)
            $table->index('featured');
            $table->index('on_sale');
            $table->index('available_for_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop indexes first (skip brand index as it wasn't added)
            $table->dropIndex(['featured']);
            $table->dropIndex(['on_sale']);
            $table->dropIndex(['available_for_order']);

            // Drop all columns (skip 'brand' as it existed before)
            $table->dropColumn([
                // SEO
                'meta_title',
                'meta_description',
                'meta_keywords',
                'short_description',
                // Product Identity
                'manufacturer',
                'supplier_reference',
                'ean13',
                'upc',
                'isbn',
                // Physical Properties
                'weight',
                'width',
                'height',
                'depth',
                // Advanced Stock
                'min_quantity',
                'low_stock_threshold',
                'available_for_order',
                'availability',
                'available_date',
                // Advanced Pricing
                'wholesale_price',
                'tax_rate',
                'on_sale',
                'sale_price',
                'sale_start_date',
                'sale_end_date',
                // Display Options
                'show_price',
                'featured',
                'new_arrival',
                'position',
                'condition',
                // Technical Information
                'features',
                'technical_specs',
                'additional_info',
                // Shipping
                'free_shipping',
                'delivery_time',
                'additional_shipping_cost',
                // Customization
                'customizable',
                'customization_text',
                'text_fields',
                // Media
                'video_url',
                'attachments',
            ]);
        });
    }
};
