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
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->after('subscription_id')->constrained()->onDelete('cascade');
            $table->date('invoice_date')->nullable()->after('invoice_number');
            $table->timestamp('sent_at')->nullable()->after('paid_date');
            $table->timestamp('paid_at')->nullable()->after('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn(['order_id', 'invoice_date', 'sent_at', 'paid_at']);
        });
    }
};
