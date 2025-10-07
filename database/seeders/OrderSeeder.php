<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer quelques commandes de test avec des produits et utilisateurs existants
        $users = \App\Models\User::where('role', 'vendeur')->take(3)->get();
        $products = \App\Models\Product::take(5)->get();

        if ($users->count() == 0 || $products->count() == 0) {
            $this->command->warn('Pas assez d\'utilisateurs ou de produits pour créer des commandes de test');
            return;
        }

        $orderStatuses = ['pending', 'confirmed', 'preparing', 'shipped', 'delivered'];

        foreach ($users as $user) {
            // Créer 2-3 commandes par utilisateur
            for ($i = 1; $i <= 3; $i++) {
                $order = \App\Models\Order::create([
                    'user_id' => $user->id,
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'status' => $orderStatuses[array_rand($orderStatuses)],
                    'total_amount' => 0,
                    'notes' => "Commande de test #{$i} pour {$user->name}",
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 5)),
                ]);

                // Si la commande est livrée, définir la date de livraison
                if ($order->status === 'delivered') {
                    $order->update([
                        'delivered_at' => now()->subDays(rand(1, 15))
                    ]);
                }

                $totalAmount = 0;

                // Ajouter 1-3 articles par commande
                $orderProducts = $products->random(rand(1, 3));
                foreach ($orderProducts as $product) {
                    $quantity = rand(1, 5);
                    $unitPrice = $product->base_price;

                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $quantity * $unitPrice,
                    ]);

                    $totalAmount += $quantity * $unitPrice;
                }

                // Mettre à jour le montant total de la commande
                $order->update(['total_amount' => $totalAmount]);
            }
        }

        $this->command->info('Commandes de test créées avec succès!');
    }
}
