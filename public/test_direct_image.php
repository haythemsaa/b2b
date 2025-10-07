<!DOCTYPE html>
<html>
<head>
    <title>Test Image Direct</title>
</head>
<body>
    <h1>Test Image Direct Access</h1>

    <h2>Test 1: Via URL /storage/products/...</h2>
    <p>URL: <a href="http://127.0.0.1:8001/storage/products/1759753669_15_68e3b5c5d7fca.png" target="_blank">
        http://127.0.0.1:8001/storage/products/1759753669_15_68e3b5c5d7fca.png
    </a></p>
    <img src="http://127.0.0.1:8001/storage/products/1759753669_15_68e3b5c5d7fca.png"
         style="max-width: 300px; border: 2px solid red;"
         onerror="this.parentElement.innerHTML += '<p style=color:red>ERROR: Image failed to load via Laravel route</p>'">

    <hr>

    <h2>Test 2: Fichier existe physiquement?</h2>
    <?php
    $file = __DIR__ . '/../storage/app/public/products/1759753669_15_68e3b5c5d7fca.png';
    if (file_exists($file)) {
        echo "<p style='color:green'>✓ Fichier existe: $file</p>";
        echo "<p>Taille: " . filesize($file) . " bytes</p>";
    } else {
        echo "<p style='color:red'>✗ Fichier n'existe pas: $file</p>";
    }
    ?>

    <hr>

    <h2>Test 3: Via public/storage symlink</h2>
    <?php
    $symlinkFile = __DIR__ . '/storage/products/1759753669_15_68e3b5c5d7fca.png';
    if (file_exists($symlinkFile)) {
        echo "<p style='color:green'>✓ Accessible via symlink: $symlinkFile</p>";
        echo "<p>URL directe: <code>/storage/products/1759753669_15_68e3b5c5d7fca.png</code></p>";
    } else {
        echo "<p style='color:red'>✗ Non accessible via symlink: $symlinkFile</p>";
    }
    ?>
</body>
</html>
