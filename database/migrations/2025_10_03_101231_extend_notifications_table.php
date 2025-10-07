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
        Schema::table('notifications', function (Blueprint $table) {
            // Ajouter user_id si notifiable_id existe
            if (Schema::hasColumn('notifications', 'notifiable_id') && !Schema::hasColumn('notifications', 'user_id')) {
                DB::statement('ALTER TABLE notifications CHANGE notifiable_id user_id BIGINT UNSIGNED NOT NULL');
            }

            // Supprimer colonne notifiable_type si elle existe
            if (Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->dropColumn('notifiable_type');
            }

            // Ajouter nouvelles colonnes
            if (!Schema::hasColumn('notifications', 'tenant_id')) {
                $table->foreignId('tenant_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('notifications', 'title')) {
                $table->string('title')->after('type')->default('Notification');
            }
            if (!Schema::hasColumn('notifications', 'message')) {
                $table->text('message')->after('title')->nullable();
            }
            if (!Schema::hasColumn('notifications', 'icon')) {
                $table->string('icon')->nullable()->after('data');
            }
            if (!Schema::hasColumn('notifications', 'link')) {
                $table->string('link')->nullable()->after('icon');
            }
            if (!Schema::hasColumn('notifications', 'is_read')) {
                $table->boolean('is_read')->default(false)->after('link');
            }
            if (!Schema::hasColumn('notifications', 'priority')) {
                $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->after('read_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'priority')) {
                $table->dropColumn('priority');
            }
            if (Schema::hasColumn('notifications', 'is_read')) {
                $table->dropColumn('is_read');
            }
            if (Schema::hasColumn('notifications', 'link')) {
                $table->dropColumn('link');
            }
            if (Schema::hasColumn('notifications', 'icon')) {
                $table->dropColumn('icon');
            }
            if (Schema::hasColumn('notifications', 'message')) {
                $table->dropColumn('message');
            }
            if (Schema::hasColumn('notifications', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('notifications', 'tenant_id')) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            }
        });
    }
};
