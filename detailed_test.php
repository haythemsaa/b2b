<?php

echo "=== TEST DÉTAILLÉ - B2B PLATFORM ===\n\n";

// Test des routes principales
$routes_to_test = [
    '/' => 'Page d\'accueil',
    '/login' => 'Connexion',
    '/dashboard' => 'Dashboard (doit rediriger)',
    '/products' => 'Catalogue produits',
    '/cart' => 'Panier',
    '/orders' => 'Commandes',
    '/messages' => 'Messages',
    '/returns' => 'Retours',
    '/admin/dashboard' => 'Admin Dashboard',
    '/admin/users' => 'Admin Utilisateurs',
    '/admin/products' => 'Admin Produits',
    '/admin/groups' => 'Admin Groupes',
    '/admin/custom-prices' => 'Admin Prix',
    '/admin/orders' => 'Admin Commandes',
    '/admin/returns' => 'Admin Retours',
    '/superadmin' => 'SuperAdmin Dashboard',
    '/superadmin/tenants' => 'SuperAdmin Tenants',
    '/superadmin/analytics' => 'SuperAdmin Analytics'
];

$base_url = 'http://127.0.0.1:8001';
$results = [];

function testRoute($url, $description) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Ne pas suivre les redirections
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Test Bot');

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    $status_icon = '';
    $status_text = '';

    switch ($http_code) {
        case 200:
            $status_icon = '✅';
            $status_text = 'OK';
            break;
        case 302:
        case 301:
            $status_icon = '🔄';
            $status_text = 'REDIRECT';
            break;
        case 404:
            $status_icon = '❌';
            $status_text = 'NOT FOUND';
            break;
        case 500:
            $status_icon = '🚨';
            $status_text = 'SERVER ERROR';
            break;
        case 0:
            $status_icon = '💀';
            $status_text = 'CONNECTION FAILED';
            break;
        default:
            $status_icon = '⚠️';
            $status_text = 'UNKNOWN';
    }

    printf("%-3s %-15s %-40s [%d]\n", $status_icon, $status_text, $description, $http_code);

    if ($error) {
        echo "    Erreur: $error\n";
    }

    return [
        'url' => $url,
        'description' => $description,
        'http_code' => $http_code,
        'status' => $status_text,
        'error' => $error,
        'response' => $response
    ];
}

echo "📊 TEST DES ROUTES PRINCIPALES\n";
echo str_repeat("-", 80) . "\n";

foreach ($routes_to_test as $route => $description) {
    $url = $base_url . $route;
    $results[] = testRoute($url, $description);
}

// Statistiques
echo "\n📈 STATISTIQUES\n";
echo str_repeat("-", 80) . "\n";

$total = count($results);
$ok = count(array_filter($results, fn($r) => $r['http_code'] == 200));
$redirect = count(array_filter($results, fn($r) => in_array($r['http_code'], [301, 302])));
$not_found = count(array_filter($results, fn($r) => $r['http_code'] == 404));
$errors = count(array_filter($results, fn($r) => $r['http_code'] >= 500));
$connection_failed = count(array_filter($results, fn($r) => $r['http_code'] == 0));

echo "Total des routes testées: $total\n";
echo "✅ OK (200): $ok\n";
echo "🔄 Redirections (3xx): $redirect\n";
echo "❌ Non trouvées (404): $not_found\n";
echo "🚨 Erreurs serveur (5xx): $errors\n";
echo "💀 Connexion échouée: $connection_failed\n";

// Analyse des problèmes
echo "\n🔍 ANALYSE DES PROBLÈMES\n";
echo str_repeat("-", 80) . "\n";

$problematic = array_filter($results, function($r) {
    return $r['http_code'] == 0 || $r['http_code'] >= 400;
});

if (empty($problematic)) {
    echo "✅ Aucun problème majeur détecté!\n";
    echo "🔄 Les redirections sont normales pour les pages protégées\n";
} else {
    foreach ($problematic as $problem) {
        echo "❌ {$problem['description']}: {$problem['status']} [{$problem['http_code']}]\n";
        if ($problem['error']) {
            echo "   Erreur: {$problem['error']}\n";
        }
    }
}

// Test de connectivité de base
echo "\n🔌 TEST DE CONNECTIVITÉ\n";
echo str_repeat("-", 80) . "\n";

$simple_test = testRoute($base_url, "Test de base du serveur");
if ($simple_test['http_code'] == 0) {
    echo "💀 PROBLÈME CRITIQUE: Le serveur ne répond pas!\n";
    echo "   Vérifiez que le serveur Laravel est bien démarré\n";
    echo "   Commande: php artisan serve --host=127.0.0.1 --port=8001\n";
} else {
    echo "✅ Le serveur répond correctement\n";
}

// Vérification des logs Laravel
echo "\n📋 RECOMMANDATIONS\n";
echo str_repeat("-", 80) . "\n";

if ($connection_failed > 0) {
    echo "1. 🔧 Redémarrer le serveur Laravel\n";
    echo "2. 🔍 Vérifier que le port 8001 n'est pas utilisé\n";
    echo "3. 🔥 Désactiver le pare-feu si nécessaire\n";
}

if ($errors > 0) {
    echo "4. 📝 Consulter les logs: storage/logs/laravel.log\n";
    echo "5. 🐛 Vérifier la configuration .env\n";
    echo "6. 🗄️ Tester la connexion à la base de données\n";
}

if ($not_found > 0) {
    echo "7. 🛣️ Vérifier les routes dans routes/web.php\n";
    echo "8. 🎭 Contrôler les contrôleurs correspondants\n";
}

echo "\n✅ TEST TERMINÉ - " . date('Y-m-d H:i:s') . "\n";