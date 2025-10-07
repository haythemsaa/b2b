<?php

// Test si Laravel se charge correctement
try {
    require_once __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';

    echo "✅ Bootstrap Laravel réussi !<br>";
    echo "📱 Version Laravel: " . app()->version() . "<br>";
    echo "🔧 Environment: " . app()->environment() . "<br>";
    echo "📂 Base Path: " . app()->basePath() . "<br>";

    // Test de la base de données
    try {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=b2bn_platform', 'root', '');
        echo "✅ Connexion base de données réussie !<br>";
    } catch (Exception $e) {
        echo "❌ Erreur base de données: " . $e->getMessage() . "<br>";
    }

} catch (Exception $e) {
    echo "❌ Erreur Laravel: " . $e->getMessage() . "<br>";
    echo "📝 Trace: " . $e->getTraceAsString() . "<br>";
}
?>