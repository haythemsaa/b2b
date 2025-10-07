<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Table des devises disponibles
        if (!Schema::hasTable('currencies')) {
            Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // USD, EUR, TND, etc.
            $table->string('name'); // Dollar américain, Euro, Dinar tunisien
            $table->string('symbol', 10); // $, €, TND
            $table->integer('decimal_places')->default(2); // Nombre de décimales
            $table->string('format')->default('{symbol}{amount}'); // Format d'affichage
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false); // Devise par défaut du système
            $table->integer('position')->default(0); // Ordre d'affichage
            $table->timestamps();

            $table->index('code');
            $table->index('is_active');
        });
        }

        // Table des taux de change
        if (!Schema::hasTable('exchange_rates')) {
            Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('from_currency', 3); // Code devise source
            $table->string('to_currency', 3); // Code devise destination
            $table->decimal('rate', 12, 6); // Taux de change
            $table->date('date'); // Date du taux
            $table->string('source')->default('manual'); // Source: manual, api, ecb
            $table->timestamps();

            $table->index(['from_currency', 'to_currency', 'date']);
            $table->unique(['from_currency', 'to_currency', 'date']);

            $table->foreign('from_currency')->references('code')->on('currencies')->onDelete('cascade');
            $table->foreign('to_currency')->references('code')->on('currencies')->onDelete('cascade');
        });
        }

        // Ajouter colonne devise aux tables existantes (sans foreign key pour l'instant)
        if (!Schema::hasColumn('products', 'currency')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('currency', 3)->default('TND')->after('price');
            });
        }

        if (!Schema::hasColumn('orders', 'currency')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('currency', 3)->default('TND')->after('total');
                $table->decimal('exchange_rate', 12, 6)->default(1)->after('currency');
            });
        }

        if (!Schema::hasColumn('quotes', 'exchange_rate')) {
            Schema::table('quotes', function (Blueprint $table) {
                $table->decimal('exchange_rate', 12, 6)->default(1)->after('currency');
            });
        }

        // Insérer les devises par défaut
        DB::table('currencies')->insert([
            ['code' => 'TND', 'name' => 'Dinar Tunisien', 'symbol' => 'TND', 'decimal_places' => 3, 'format' => '{amount} {symbol}', 'is_active' => true, 'is_default' => true, 'position' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'decimal_places' => 2, 'format' => '{symbol}{amount}', 'is_active' => true, 'is_default' => false, 'position' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'USD', 'name' => 'Dollar Américain', 'symbol' => '$', 'decimal_places' => 2, 'format' => '{symbol}{amount}', 'is_active' => true, 'is_default' => false, 'position' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'GBP', 'name' => 'Livre Sterling', 'symbol' => '£', 'decimal_places' => 2, 'format' => '{symbol}{amount}', 'is_active' => true, 'is_default' => false, 'position' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'CHF', 'name' => 'Franc Suisse', 'symbol' => 'CHF', 'decimal_places' => 2, 'format' => '{amount} {symbol}', 'is_active' => true, 'is_default' => false, 'position' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'MAD', 'name' => 'Dirham Marocain', 'symbol' => 'MAD', 'decimal_places' => 2, 'format' => '{amount} {symbol}', 'is_active' => true, 'is_default' => false, 'position' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'DZD', 'name' => 'Dinar Algérien', 'symbol' => 'DZD', 'decimal_places' => 2, 'format' => '{amount} {symbol}', 'is_active' => true, 'is_default' => false, 'position' => 7, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Taux de change par défaut
        DB::table('exchange_rates')->insert([
            ['from_currency' => 'TND', 'to_currency' => 'EUR', 'rate' => 0.31, 'date' => now()->toDateString(), 'source' => 'manual', 'created_at' => now(), 'updated_at' => now()],
            ['from_currency' => 'EUR', 'to_currency' => 'TND', 'rate' => 3.23, 'date' => now()->toDateString(), 'source' => 'manual', 'created_at' => now(), 'updated_at' => now()],
            ['from_currency' => 'TND', 'to_currency' => 'USD', 'rate' => 0.32, 'date' => now()->toDateString(), 'source' => 'manual', 'created_at' => now(), 'updated_at' => now()],
            ['from_currency' => 'USD', 'to_currency' => 'TND', 'rate' => 3.12, 'date' => now()->toDateString(), 'source' => 'manual', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('quotes', 'exchange_rate')) {
            Schema::table('quotes', function (Blueprint $table) {
                $table->dropColumn('exchange_rate');
            });
        }

        if (Schema::hasColumn('orders', 'currency')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn(['currency', 'exchange_rate']);
            });
        }

        if (Schema::hasColumn('products', 'currency')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('currency');
            });
        }

        Schema::dropIfExists('exchange_rates');
        Schema::dropIfExists('currencies');
    }
};
