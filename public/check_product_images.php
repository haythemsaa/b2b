<?php
// Vérifier les images pour un produit spécifique
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/html; charset=utf-8');

$productSku = $_GET['sku'] ?? 'RIZ-BAS-1KG';

$product = \App\Models\Product::where('sku', $productSku)->first();

if (!$product) {
    die("Produit non trouvé avec SKU: $productSku");
}

echo "<!DOCTYPE html><html><head>
<title>Images pour: {$product->name}</title>
<style>
    body { font-family: Arial; padding: 20px; }
    .image { border: 2px solid #ddd; padding: 10px; margin: 10px 0; }
    img { max-width: 300px; }
    .success { color: green; }
    .error { color: red; }
</style>
</head><body>";

echo "<h1>Images pour: {$product->name}</h1>";
echo "<p><strong>ID Produit:</strong> {$product->id}</p>";
echo "<p><strong>SKU:</strong> {$product->sku}</p>";
echo "<p><strong>Tenant ID:</strong> {$product->tenant_id}</p>";

// Charger les images sans le global scope tenant pour debug
$images = \App\Models\ProductImage::withoutGlobalScopes()
    ->where('product_id', $product->id)
    ->get();

echo "<h2>Images en base de données (total): " . $images->count() . "</h2>";

// Vérifier avec global scope
$imagesWithScope = $product->images;
$countWithScope = $imagesWithScope ? $imagesWithScope->count() : 0;
echo "<p><strong>Avec tenant scope:</strong> {$countWithScope} images</p>";

if ($images->count() > 0) {
    foreach ($images as $img) {
        $fullPath = storage_path('app/public/' . $img->image_path);
        $fileExists = file_exists($fullPath);

        echo "<div class='image'>";
        echo "<p><strong>ID:</strong> {$img->id}</p>";
        echo "<p><strong>Chemin:</strong> <code>{$img->image_path}</code></p>";
        echo "<p><strong>Position:</strong> {$img->position}</p>";
        echo "<p><strong>Cover:</strong> " . ($img->is_cover ? 'Oui ⭐' : 'Non') . "</p>";
        echo "<p><strong>Tenant ID:</strong> {$img->tenant_id}</p>";
        echo "<p><strong>Fichier existe:</strong> " . ($fileExists ? "<span class='success'>✓ OUI</span>" : "<span class='error'>✗ NON</span>") . "</p>";

        if ($fileExists) {
            $url = asset('storage/' . $img->image_path);
            echo "<p><strong>URL:</strong> <a href='{$url}' target='_blank'>{$url}</a></p>";
            echo "<img src='{$url}' alt='{$product->name}'>";
        }

        echo "</div>";
    }
} else {
    echo "<p class='error'>Aucune image trouvée pour ce produit.</p>";
}

echo "<hr>";
echo "<h3>Tester un autre produit:</h3>";
echo "<form method='GET'>";
echo "<input type='text' name='sku' value='{$productSku}' placeholder='Product SKU'>";
echo "<button type='submit'>Vérifier</button>";
echo "</form>";

echo "</body></html>";
