<?php
// Test simple pour vérifier l'accès aux images

$images = [
    'products/1759751610_10_68e3adbae92c6.png',
    'products/1759751029_9_68e3ab7520aca.png',
    'products/1759751014_6_68e3ab663c9f6.png',
];

echo '<!DOCTYPE html>
<html>
<head>
    <title>Test Images Produits</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .image-test { margin: 20px; padding: 10px; border: 1px solid #ddd; }
        img { max-width: 300px; border: 2px solid #ccc; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Test d\'accès aux Images Produits</h1>';

foreach ($images as $imagePath) {
    $fullPath = __DIR__ . '/storage/' . $imagePath;
    $url = '/storage/' . $imagePath;

    echo '<div class="image-test">';
    echo '<h3>' . $imagePath . '</h3>';
    echo '<p><strong>Chemin physique:</strong> ' . $fullPath . '</p>';

    if (file_exists($fullPath)) {
        echo '<p class="success">✓ Fichier existe physiquement</p>';
        echo '<p><strong>URL:</strong> <a href="' . $url . '">' . $url . '</a></p>';
        echo '<img src="' . $url . '" alt="' . $imagePath . '">';
    } else {
        echo '<p class="error">✗ Fichier non trouvé</p>';
    }

    echo '</div>';
}

echo '</body></html>';
