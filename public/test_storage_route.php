<!DOCTYPE html>
<html>
<head>
    <title>Test Storage Route</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .test { margin: 20px 0; padding: 15px; border: 2px solid #ddd; }
        .success { border-color: green; }
        .error { border-color: red; }
        img { max-width: 400px; border: 3px solid blue; }
    </style>
</head>
<body>
    <h1>Test Storage Route</h1>

    <div class="test">
        <h2>Test Image: 1759753669_15_68e3b5c5d7fca.png</h2>

        <h3>Méthode 1: Via asset() helper</h3>
        <p>URL: <?php echo asset('storage/products/1759753669_15_68e3b5c5d7fca.png'); ?></p>
        <img src="<?php echo asset('storage/products/1759753669_15_68e3b5c5d7fca.png'); ?>"
             onerror="alert('ERREUR: Image non chargée via asset()')">

        <hr>

        <h3>Méthode 2: URL relative</h3>
        <p>URL: /storage/products/1759753669_15_68e3b5c5d7fca.png</p>
        <img src="/storage/products/1759753669_15_68e3b5c5d7fca.png"
             onerror="alert('ERREUR: Image non chargée via URL relative')">

        <hr>

        <h3>Méthode 3: URL absolue</h3>
        <p>URL: http://127.0.0.1:8001/storage/products/1759753669_15_68e3b5c5d7fca.png</p>
        <img src="http://127.0.0.1:8001/storage/products/1759753669_15_68e3b5c5d7fca.png"
             onerror="alert('ERREUR: Image non chargée via URL absolue')">
    </div>

    <div class="test">
        <h2>Vérification Fichiers</h2>
        <?php
        $file1 = __DIR__ . '/../storage/app/public/products/1759753669_15_68e3b5c5d7fca.png';
        $file2 = __DIR__ . '/storage/products/1759753669_15_68e3b5c5d7fca.png';

        echo "<p><strong>Fichier original:</strong> " . ($file1) . "</p>";
        echo "<p>Existe: " . (file_exists($file1) ? "✓ OUI" : "✗ NON") . "</p>";

        echo "<p><strong>Via symlink:</strong> " . ($file2) . "</p>";
        echo "<p>Existe: " . (file_exists($file2) ? "✓ OUI" : "✗ NON") . "</p>";
        ?>
    </div>

    <script>
        // Test fetch API
        fetch('/storage/products/1759753669_15_68e3b5c5d7fca.png')
            .then(response => {
                console.log('Fetch status:', response.status);
                console.log('Content-Type:', response.headers.get('Content-Type'));
                if (!response.ok) {
                    document.body.innerHTML += '<div class="test error"><h2>Fetch API Test: ÉCHEC</h2><p>Status: ' + response.status + '</p></div>';
                } else {
                    document.body.innerHTML += '<div class="test success"><h2>Fetch API Test: SUCCÈS</h2><p>L\'image est accessible!</p></div>';
                }
            })
            .catch(error => {
                document.body.innerHTML += '<div class="test error"><h2>Fetch API Test: ERREUR</h2><p>' + error + '</p></div>';
            });
    </script>
</body>
</html>
