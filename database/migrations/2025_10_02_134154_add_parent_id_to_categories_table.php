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
        Schema::table('categories', function (Blueprint $table) {
            // Hierarchical structure (parent_id already exists)
            $table->integer('level')->default(0)->after('parent_id');
            $table->integer('position')->default(0)->after('level');

            // SEO fields
            $table->string('meta_title')->nullable()->after('description');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');

            // Indexes (image and is_active already exist)
            $table->index('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Drop index
            $table->dropIndex(['level']);

            // Drop columns (keep parent_id, image, is_active as they existed before)
            $table->dropColumn([
                'level',
                'position',
                'meta_title',
                'meta_description',
                'meta_keywords'
            ]);
        });
    }
};
