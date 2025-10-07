<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // Épicerie salée
            [
                'name' => 'Riz Basmati 1kg',
                'sku' => 'RIZ-BAS-1KG',
                'description' => 'Riz basmati de qualité supérieure, grain long',
                'category_slug' => 'epicerie-salee',
                'brand' => 'Premium Rice',
                'unit' => 'kg',
                'base_price' => 8.500,
                'stock_quantity' => 150,
                'min_order_quantity' => 10,
                'order_multiple' => 10,
            ],
            [
                'name' => 'Huile d\'olive extra vierge 500ml',
                'sku' => 'HUILE-OLV-500',
                'description' => 'Huile d\'olive extra vierge pressée à froid',
                'category_slug' => 'epicerie-salee',
                'brand' => 'Méditerranée',
                'unit' => 'bouteille',
                'base_price' => 12.750,
                'stock_quantity' => 80,
                'min_order_quantity' => 6,
                'order_multiple' => 6,
            ],
            [
                'name' => 'Pâtes spaghetti 500g',
                'sku' => 'PATE-SPA-500',
                'description' => 'Spaghetti de blé dur, cuisson 8-10 minutes',
                'category_slug' => 'epicerie-salee',
                'brand' => 'Pasta Bella',
                'unit' => 'paquet',
                'base_price' => 2.200,
                'stock_quantity' => 200,
                'min_order_quantity' => 12,
                'order_multiple' => 12,
            ],

            // Épicerie sucrée
            [
                'name' => 'Chocolat noir 70% 100g',
                'sku' => 'CHOC-NOIR-100',
                'description' => 'Chocolat noir 70% cacao, tablette premium',
                'category_slug' => 'epicerie-sucree',
                'brand' => 'Cacao Royal',
                'unit' => 'tablette',
                'base_price' => 4.500,
                'stock_quantity' => 60,
                'min_order_quantity' => 20,
                'order_multiple' => 20,
            ],
            [
                'name' => 'Miel naturel 500g',
                'sku' => 'MIEL-NAT-500',
                'description' => 'Miel naturel de fleurs sauvages',
                'category_slug' => 'epicerie-sucree',
                'brand' => 'Miel Doré',
                'unit' => 'pot',
                'base_price' => 18.000,
                'stock_quantity' => 40,
                'min_order_quantity' => 6,
                'order_multiple' => 6,
            ],

            // Conserves
            [
                'name' => 'Tomates pelées en conserve 400g',
                'sku' => 'TOM-PEL-400',
                'description' => 'Tomates pelées italiennes en conserve',
                'category_slug' => 'conserves',
                'brand' => 'San Marzano',
                'unit' => 'boîte',
                'base_price' => 3.200,
                'stock_quantity' => 120,
                'min_order_quantity' => 24,
                'order_multiple' => 24,
            ],
            [
                'name' => 'Thon à l\'huile d\'olive 160g',
                'sku' => 'THON-HUILE-160',
                'description' => 'Thon albacore à l\'huile d\'olive extra vierge',
                'category_slug' => 'conserves',
                'brand' => 'Océan Bleu',
                'unit' => 'boîte',
                'base_price' => 6.500,
                'stock_quantity' => 90,
                'min_order_quantity' => 12,
                'order_multiple' => 12,
            ],

            // Boissons
            [
                'name' => 'Eau minérale 1.5L',
                'sku' => 'EAU-MIN-1.5L',
                'description' => 'Eau minérale naturelle source de montagne',
                'category_slug' => 'boissons',
                'brand' => 'Source Pure',
                'unit' => 'bouteille',
                'base_price' => 0.800,
                'stock_quantity' => 300,
                'min_order_quantity' => 12,
                'order_multiple' => 12,
            ],
            [
                'name' => 'Jus d\'orange 1L',
                'sku' => 'JUS-ORA-1L',
                'description' => 'Jus d\'orange 100% pur jus sans sucre ajouté',
                'category_slug' => 'boissons',
                'brand' => 'Vitamine C',
                'unit' => 'brick',
                'base_price' => 4.200,
                'stock_quantity' => 75,
                'min_order_quantity' => 8,
                'order_multiple' => 8,
            ],

            // Soins du corps
            [
                'name' => 'Gel douche hydratant 250ml',
                'sku' => 'GEL-DOU-250',
                'description' => 'Gel douche hydratant à l\'aloe vera',
                'category_slug' => 'soins-corps',
                'brand' => 'Doux Soin',
                'unit' => 'flacon',
                'base_price' => 7.500,
                'stock_quantity' => 85,
                'min_order_quantity' => 12,
                'order_multiple' => 12,
            ],
            [
                'name' => 'Shampooing tous cheveux 400ml',
                'sku' => 'SHAM-TOUS-400',
                'description' => 'Shampooing pour tous types de cheveux',
                'category_slug' => 'soins-corps',
                'brand' => 'Hair Care',
                'unit' => 'flacon',
                'base_price' => 9.200,
                'stock_quantity' => 70,
                'min_order_quantity' => 6,
                'order_multiple' => 6,
            ],

            // Nettoyage sols
            [
                'name' => 'Nettoyant sol multi-surfaces 1L',
                'sku' => 'NET-SOL-1L',
                'description' => 'Nettoyant pour tous types de sols',
                'category_slug' => 'nettoyage-sols',
                'brand' => 'Clean Pro',
                'unit' => 'bouteille',
                'base_price' => 5.800,
                'stock_quantity' => 100,
                'min_order_quantity' => 8,
                'order_multiple' => 8,
            ],

            // Téléphones
            [
                'name' => 'Smartphone Android 128GB',
                'sku' => 'TEL-AND-128',
                'description' => 'Smartphone Android avec écran 6.5", 128GB de stockage',
                'category_slug' => 'telephones',
                'brand' => 'TechMobile',
                'unit' => 'unité',
                'base_price' => 450.000,
                'stock_quantity' => 25,
                'min_order_quantity' => 1,
                'order_multiple' => 1,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category_slug'])->first();

            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'sku' => $productData['sku'],
                    'description' => $productData['description'],
                    'category_id' => $category->id,
                    'brand' => $productData['brand'],
                    'unit' => $productData['unit'],
                    'base_price' => $productData['base_price'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'min_order_quantity' => $productData['min_order_quantity'],
                    'order_multiple' => $productData['order_multiple'],
                    'stock_alert_threshold' => 10,
                    'is_active' => true,
                ]);
            }
        }
    }
}