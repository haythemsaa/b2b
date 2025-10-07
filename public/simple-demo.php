<?php
// Demo simple de l'application B2B sans Laravel complet
session_start();

// Configuration de base pour WAMP/XAMPP
$config = [
    'db_host' => '127.0.0.1',
    'db_name' => 'b2bn_platform',
    'db_user' => 'root',
    'db_pass' => '', // Mot de passe vide par défaut pour WAMP local
];

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
                   $config['db_user'], $config['db_pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_connected = true;
} catch (PDOException $e) {
    $db_connected = false;
    $db_error = $e->getMessage();
}

// Gestion des actions
$action = $_GET['action'] ?? 'home';
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

// Fonction de connexion simple
if ($action === 'login' && $_POST) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($db_connected) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification simple du mot de passe (en production, utilisez password_verify)
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['message'] = 'Connexion réussie !';
            header('Location: ?action=dashboard');
            exit;
        } else {
            $message = 'Identifiants incorrects.';
        }
    }
}

// Déconnexion
if ($action === 'logout') {
    session_destroy();
    header('Location: ?');
    exit;
}

$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>B2B Platform - Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="?">
                <i class="bi bi-shop"></i> B2B Platform
            </a>
            <?php if ($user): ?>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Bonjour, <?= htmlspecialchars($user['name']) ?>
                    <span class="badge bg-light text-dark"><?= ucfirst($user['role']) ?></span>
                </span>
                <a href="?action=logout" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($message): ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (!$db_connected): ?>
        <div class="alert alert-danger">
            <h5><i class="bi bi-exclamation-triangle"></i> Erreur de base de données</h5>
            <p>Impossible de se connecter à la base de données : <?= htmlspecialchars($db_error ?? 'Erreur inconnue') ?></p>
            <hr>
            <p class="mb-0">
                <strong>Veuillez :</strong><br>
                1. Créer la base de données <code>b2bn_platform</code><br>
                2. Importer <code>database_schema.sql</code><br>
                3. Importer <code>database_data.sql</code>
            </p>
        </div>
        <?php endif; ?>

        <?php if (!$user && $db_connected): ?>
        <!-- Page de connexion -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-circle"></i> Connexion</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="?action=login">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right"></i> Se connecter
                            </button>
                        </form>

                        <hr>
                        <h6>Comptes de test :</h6>
                        <div class="row">
                            <div class="col-sm-6">
                                <small><strong>Grossiste :</strong><br>
                                grossiste@b2b.com<br>
                                password</small>
                            </div>
                            <div class="col-sm-6">
                                <small><strong>Vendeur :</strong><br>
                                ahmed@vendeur1.com<br>
                                password</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php elseif ($user && $db_connected): ?>
        <!-- Dashboard utilisateur connecté -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-speedometer2"></i> Tableau de bord</h5>
                    </div>
                    <div class="card-body">
                        <h4>Bienvenue, <?= htmlspecialchars($user['name']) ?> !</h4>

                        <?php if ($user['role'] === 'grossiste'): ?>
                        <p class="text-muted">Interface administrateur - Gestion de la plateforme B2B</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-primary text-white mb-3">
                                    <div class="card-body">
                                        <h6>Vendeurs actifs</h6>
                                        <?php
                                        $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'vendeur' AND is_active = 1");
                                        echo $stmt->fetchColumn();
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-success text-white mb-3">
                                    <div class="card-body">
                                        <h6>Produits actifs</h6>
                                        <?php
                                        $stmt = $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1");
                                        echo $stmt->fetchColumn();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php else: ?>
                        <p class="text-muted">Interface vendeur - Passez vos commandes facilement</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-info text-white mb-3">
                                    <div class="card-body">
                                        <h6>Mes commandes</h6>
                                        <?php
                                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
                                        $stmt->execute([$user['id']]);
                                        echo $stmt->fetchColumn();
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-warning text-white mb-3">
                                    <div class="card-body">
                                        <h6>Produits disponibles</h6>
                                        <?php
                                        $stmt = $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1 AND stock_quantity > 0");
                                        echo $stmt->fetchColumn();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6><i class="bi bi-info-circle"></i> Informations</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Société :</strong> <?= htmlspecialchars($user['company_name'] ?? 'Non renseigné') ?></p>
                        <p><strong>Ville :</strong> <?= htmlspecialchars($user['city'] ?? 'Non renseigné') ?></p>
                        <p><strong>Téléphone :</strong> <?= htmlspecialchars($user['phone'] ?? 'Non renseigné') ?></p>
                        <p><strong>Langue :</strong> <?= $user['preferred_language'] === 'ar' ? 'العربية' : 'Français' ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($db_connected): ?>
        <!-- Informations sur l'installation complète -->
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark">
                <h6><i class="bi bi-exclamation-triangle"></i> Version de démonstration</h6>
            </div>
            <div class="card-body">
                <p>Vous utilisez actuellement une version simplifiée de l'application B2B Platform.</p>
                <p><strong>Pour accéder à toutes les fonctionnalités :</strong></p>
                <ol>
                    <li>Installez Composer : <a href="https://getcomposer.org" target="_blank">getcomposer.org</a></li>
                    <li>Exécutez : <code>composer install</code></li>
                    <li>Puis : <code>php artisan key:generate</code></li>
                </ol>
                <p class="mb-0">L'application complète inclut : gestion avancée des produits, panier, commandes, messagerie, tarification différenciée, et plus encore.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>