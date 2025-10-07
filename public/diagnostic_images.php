<?php
// Diagnostic complet des images
header('Content-Type: text/html; charset=utf-8');

echo '<!DOCTYPE html>
<html>
<head>
    <title>Diagnostic Images Produits</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .test { margin: 15px 0; padding: 15px; background: white; border-radius: 5px; }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #0d6efd; }
        img { max-width: 200px; border: 2px solid #ddd; margin: 10px 0; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 3px; overflow-x: auto; }
        h1 { color: #333; }
        h2 { color: #666; margin-top: 30px; }
    </style>
</head>
<body>
<h1>🔍 Diagnostic Complet des Images</h1>';

// Test 1: Vérifier les chemins
echo '<div class="test">
<h2>📁 Test 1: Vérification des Chemins</h2>';

$publicDir = __DIR__;
$storageDir = dirname(__DIR__) . '/storage/app/public';
$symlinkDir = __DIR__ . '/storage';

echo '<p><strong>Public dir:</strong> ' . $publicDir . '</p>';
echo '<p><strong>Storage dir:</strong> ' . $storageDir . '</p>';
echo '<p><strong>Symlink dir:</strong> ' . $symlinkDir . '</p>';

echo '<p>Storage exists: ' . (is_dir($storageDir) ? '<span class="success">✓ OUI</span>' : '<span class="error">✗ NON</span>') . '</p>';

// Sur Windows, is_link() ne fonctionne pas pour les junctions
$symlinkExists = is_dir($symlinkDir);
echo '<p>Symlink/Junction exists: ' . ($symlinkExists ? '<span class="success">✓ OUI</span>' : '<span class="error">✗ NON</span>') . '</p>';

if ($symlinkExists) {
    // Tenter de lire le target (fonctionne sur Windows avec junctions)
    if (is_link($symlinkDir)) {
        echo '<p>Symlink target: <code>' . readlink($symlinkDir) . '</code></p>';
    } else {
        echo '<p class="info">Type: Windows Junction (équivalent symlink)</p>';
    }
}

echo '</div>';

// Test 2: Lister les fichiers dans storage/app/public/products
echo '<div class="test">
<h2>📸 Test 2: Fichiers dans storage/app/public/products</h2>';

$productsDir = $storageDir . '/products';
if (is_dir($productsDir)) {
    $files = scandir($productsDir);
    $imageFiles = array_filter($files, function($f) use ($productsDir) {
        return is_file($productsDir . '/' . $f) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $f);
    });

    echo '<p class="success">✓ Dossier existe: ' . $productsDir . '</p>';
    echo '<p>Nombre d\'images trouvées: <strong>' . count($imageFiles) . '</strong></p>';

    if (count($imageFiles) > 0) {
        echo '<pre>';
        foreach (array_slice($imageFiles, 0, 5) as $file) {
            $fullPath = $productsDir . '/' . $file;
            $size = filesize($fullPath);
            echo $file . ' (' . number_format($size/1024, 2) . ' KB)' . "\n";
        }
        echo '</pre>';
    }
} else {
    echo '<p class="error">✗ Dossier n\'existe pas: ' . $productsDir . '</p>';
}

echo '</div>';

// Test 3: Vérifier l'accès via symlink
echo '<div class="test">
<h2>🔗 Test 3: Accès via Symlink</h2>';

if (count($imageFiles ?? []) > 0) {
    $testFile = array_values($imageFiles)[0];
    $relativePath = 'products/' . $testFile;

    // Via symlink
    $symlinkPath = $symlinkDir . '/' . $relativePath;
    echo '<p>Chemin symlink: <code>' . $symlinkPath . '</code></p>';
    echo '<p>Fichier accessible: ' . (file_exists($symlinkPath) ? '<span class="success">✓ OUI</span>' : '<span class="error">✗ NON</span>') . '</p>';

    if (file_exists($symlinkPath)) {
        echo '<p>Taille: ' . number_format(filesize($symlinkPath)/1024, 2) . ' KB</p>';
        echo '<p>Permissions: ' . substr(sprintf('%o', fileperms($symlinkPath)), -4) . '</p>';
    }
}

echo '</div>';

// Test 4: Test d'affichage réel des images
echo '<div class="test">
<h2>🖼️ Test 4: Affichage Réel des Images</h2>';

if (count($imageFiles ?? []) > 0) {
    foreach (array_slice($imageFiles, 0, 3) as $file) {
        $relativePath = 'products/' . $file;
        $url = '/storage/' . $relativePath;

        echo '<div style="margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">';
        echo '<p><strong>Fichier:</strong> ' . $file . '</p>';
        echo '<p><strong>URL:</strong> <a href="' . $url . '" target="_blank">' . $url . '</a></p>';
        echo '<p><strong>Test d\'affichage:</strong></p>';
        echo '<img src="' . $url . '" alt="' . $file . '"
              onerror="this.parentElement.innerHTML += \'<p class=\\\'error\\\'>❌ ERREUR: Image non chargée</p>\'">';
        echo '</div>';
    }
}

echo '</div>';

// Test 5: Connexion à la base de données
echo '<div class="test">
<h2>💾 Test 5: Vérification Base de Données</h2>';

try {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    $app = require_once dirname(__DIR__) . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    $images = \App\Models\ProductImage::with('product')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    echo '<p class="success">✓ Connexion DB réussie</p>';
    echo '<p>Nombre d\'images en base: <strong>' . \App\Models\ProductImage::count() . '</strong></p>';

    if ($images->count() > 0) {
        echo '<table border="1" cellpadding="10" style="width: 100%; margin-top: 10px; border-collapse: collapse;">
        <tr style="background: #f8f9fa;">
            <th>ID</th>
            <th>Produit</th>
            <th>Chemin</th>
            <th>Cover</th>
            <th>Fichier existe?</th>
        </tr>';

        foreach ($images as $img) {
            $fullPath = storage_path('app/public/' . $img->image_path);
            $exists = file_exists($fullPath);

            echo '<tr>';
            echo '<td>' . $img->id . '</td>';
            echo '<td>' . ($img->product ? $img->product->name : 'N/A') . '</td>';
            echo '<td><code>' . $img->image_path . '</code></td>';
            echo '<td>' . ($img->is_cover ? '⭐' : '') . '</td>';
            echo '<td>' . ($exists ? '<span class="success">✓</span>' : '<span class="error">✗</span>') . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }

} catch (Exception $e) {
    echo '<p class="error">✗ Erreur DB: ' . $e->getMessage() . '</p>';
}

echo '</div>';

// Test 6: Recommandations
echo '<div class="test">
<h2>💡 Recommandations</h2>';

$issues = [];

if (!is_dir($storageDir)) {
    $issues[] = 'Le dossier storage/app/public n\'existe pas';
}

if (!is_link($symlinkDir) && !is_dir($symlinkDir)) {
    $issues[] = 'Le symlink public/storage n\'existe pas. Exécuter: php artisan storage:link';
}

if (empty($imageFiles ?? [])) {
    $issues[] = 'Aucune image trouvée dans storage/app/public/products';
}

if (count($issues) > 0) {
    echo '<ul>';
    foreach ($issues as $issue) {
        echo '<li class="error">⚠️ ' . $issue . '</li>';
    }
    echo '</ul>';
} else {
    echo '<p class="success">✅ Tout semble configuré correctement!</p>';
    echo '<p class="info">Si les images ne s\'affichent toujours pas, vérifiez:</p>';
    echo '<ul>
        <li>La console du navigateur (F12) pour les erreurs</li>
        <li>Les permissions des fichiers sur Windows</li>
        <li>Si vous êtes sur la bonne page produit (celle qui a des images)</li>
        <li>Essayez un hard refresh (Ctrl+Shift+R)</li>
    </ul>';
}

echo '</div>';

echo '</body></html>';
