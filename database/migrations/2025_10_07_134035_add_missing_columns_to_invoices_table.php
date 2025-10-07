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
            // Add subscription_id if not exists
            if (!Schema::hasColumn('invoices', 'subscription_id')) {
                $table->foreignId('subscription_id')->nullable()->after('tenant_id')->constrained()->onDelete('cascade');
            }

            // Add order_id if not exists
            if (!Schema::hasColumn('invoices', 'order_id')) {
                $table->foreignId('order_id')->nullable()->after('subscription_id')->constrained()->onDelete('cascade');
            }

            // Add invoice_number if not exists
            if (!Schema::hasColumn('invoices', 'invoice_number')) {
                $table->string('invoice_number')->unique()->after('order_id');
            }

            // Add invoice_date if not exists
            if (!Schema::hasColumn('invoices', 'invoice_date')) {
                $table->date('invoice_date')->nullable()->after('invoice_number');
            }

            // Add issue_date if not exists
            if (!Schema::hasColumn('invoices', 'issue_date')) {
                $table->date('issue_date')->nullable()->after('invoice_date');
            }

            // Add due_date if not exists
            if (!Schema::hasColumn('invoices', 'due_date')) {
                $table->date('due_date')->after('issue_date');
            }

            // Add paid_date if not exists
            if (!Schema::hasColumn('invoices', 'paid_date')) {
                $table->date('paid_date')->nullable()->after('due_date');
            }

            // Add subtotal if not exists
            if (!Schema::hasColumn('invoices', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->after('paid_date');
            }

            // Add tax if not exists
            if (!Schema::hasColumn('invoices', 'tax')) {
                $table->decimal('tax', 10, 2)->default(0)->after('subtotal');
            }

            // Add total if not exists
            if (!Schema::hasColumn('invoices', 'total')) {
                $table->decimal('total', 10, 2)->after('tax');
            }

            // Add status if not exists
            if (!Schema::hasColumn('invoices', 'status')) {
                $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending')->after('total');
            }

            // Add notes if not exists
            if (!Schema::hasColumn('invoices', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }

            // Add sent_at if not exists
            if (!Schema::hasColumn('invoices', 'sent_at')) {
                $table->timestamp('sent_at')->nullable()->after('notes');
            }

            // Add paid_at if not exists
            if (!Schema::hasColumn('invoices', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('sent_at');
            }
        });

        // Add soft deletes and indexes for performance
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'deleted_at')) {
                $table->softDeletes()->after('paid_at');
            }
        });

        // Add indexes in a separate block to avoid errors if they exist
        try {
            Schema::table('invoices', function (Blueprint $table) {
                $table->index(['tenant_id', 'status'], 'invoices_tenant_id_status_index');
            });
        } catch (\Exception $e) {
            // Index already exists, skip
        }

        try {
            Schema::table('invoices', function (Blueprint $table) {
                $table->index('invoice_date');
            });
        } catch (\Exception $e) {
            // Index already exists, skip
        }

        try {
            Schema::table('invoices', function (Blueprint $table) {
                $table->index('due_date');
            });
        } catch (\Exception $e) {
            // Index already exists, skip
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['tenant_id', 'status']);
            $table->dropIndex(['invoice_date']);
            $table->dropIndex(['due_date']);

            // Drop columns in reverse order
            $table->dropSoftDeletes();
            $table->dropColumn([
                'paid_at',
                'sent_at',
                'notes',
                'status',
                'total',
                'tax',
                'subtotal',
                'paid_date',
                'due_date',
                'issue_date',
                'invoice_date',
                'invoice_number',
            ]);

            // Drop foreign key constraints before dropping columns
            $table->dropForeign(['order_id']);
            $table->dropForeign(['subscription_id']);
            $table->dropColumn(['order_id', 'subscription_id']);
        });
    }
};
