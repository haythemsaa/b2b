<?php

namespace Database\Seeders;

use App\Models\CustomPrice;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomerGroup;
use Illuminate\Database\Seeder;

class CustomPriceSeeder extends Seeder
{
    public function run()
    {
        $products = Product::limit(5)->get();
        $vendeurs = User::where('role', 'vendeur')->get();
        $vipGroup = CustomerGroup::where('name', 'VIP')->first();

        // Créer quelques prix personnalisés pour des vendeurs spécifiques
        if ($vendeurs->count() > 0 && $products->count() > 0) {
            // Prix spécial pour le premier vendeur sur le premier produit
            CustomPrice::create([
                'product_id' => $products[0]->id,
                'user_id' => $vendeurs[0]->id,
                'price' => $products[0]->base_price * 0.85, // 15% de réduction
                'min_quantity' => 1,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(6),
                'is_active' => true,
            ]);

            // Prix spécial pour le deuxième vendeur sur le deuxième produit
            if ($vendeurs->count() > 1 && $products->count() > 1) {
                CustomPrice::create([
                    'product_id' => $products[1]->id,
                    'user_id' => $vendeurs[1]->id,
                    'price' => $products[1]->base_price * 0.80, // 20% de réduction
                    'min_quantity' => 10,
                    'valid_from' => now(),
                    'valid_until' => now()->addMonths(3),
                    'is_active' => true,
                ]);
            }
        }

        // Créer des prix pour le groupe VIP
        if ($vipGroup && $products->count() > 2) {
            for ($i = 2; $i < min(5, $products->count()); $i++) {
                CustomPrice::create([
                    'product_id' => $products[$i]->id,
                    'customer_group_id' => $vipGroup->id,
                    'price' => $products[$i]->base_price * 0.85, // 15% de réduction pour les VIP
                    'min_quantity' => 1,
                    'valid_from' => now(),
                    'valid_until' => now()->addYear(),
                    'is_active' => true,
                ]);
            }
        }
    }
}