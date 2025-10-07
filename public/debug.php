<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Chargement de l'autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap de l'application
$app = require_once __DIR__.'/../bootstrap/app.php';

// Création du kernel
$kernel = $app->make(Kernel::class);

// Création d'une requête fictive pour /login
$request = Request::create('/login', 'GET');

try {
    $response = $kernel->handle($request);
    echo "✅ Framework Laravel fonctionne !<br>";
    echo "📄 Status: " . $response->getStatusCode() . "<br>";
    echo "🔗 Content (100 premiers caractères): " . substr($response->getContent(), 0, 100) . "...<br>";
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
    echo "📂 Fichier: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    echo "📝 Trace (premiers 3 niveaux):<br>";
    $trace = $e->getTrace();
    for ($i = 0; $i < min(3, count($trace)); $i++) {
        echo $i . ": " . ($trace[$i]['file'] ?? 'N/A') . ":" . ($trace[$i]['line'] ?? 'N/A') . " - " . ($trace[$i]['function'] ?? 'N/A') . "<br>";
    }
}

$kernel->terminate($request, $response ?? null);
?>