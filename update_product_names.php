<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\OrderItem;

echo "=== MISE À JOUR DES NOMS DE PRODUITS ===\n\n";

$productNames = [
    'RIZ-BAS-1KG' => 'Riz Basmati 1kg',
    'HUILE-OLV-500' => 'Huile d\'Olive Extra Vierge 500ml',
    'PATE-SPA-500' => 'Pâtes Spaghetti 500g',
    'CHOC-NOIR-100' => 'Chocolat Noir 70% 100g',
    'MIEL-NAT-500' => 'Miel Naturel 500g'
];

foreach ($productNames as $sku => $name) {
    $product = Product::where('sku', $sku)->first();
    if ($product) {
        $product->update(['name' => $name]);
        echo "Produit {$sku}: nom mis à jour -> {$name}\n";

        // Mettre à jour aussi les order_items existants
        OrderItem::where('product_sku', $sku)->update(['product_name' => $name]);
        echo "  OrderItems avec SKU {$sku} mis à jour\n";
    }
}

echo "\n=== MISE À JOUR TERMINÉE ===\n";