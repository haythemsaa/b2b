# Guide d'installation - Plateforme B2B

## Installation avec XAMPP (Recommandé pour le développement)

### Prérequis
- XAMPP avec PHP 8.1+ et MySQL
- Composer installé globalement

### Étapes d'installation

#### 1. Démarrer XAMPP
- Ouvrir le panneau de contrôle XAMPP
- Démarrer Apache et MySQL
- Vérifier que les services fonctionnent

#### 2. Préparer la base de données
- Aller sur http://localhost/phpmyadmin
- Créer une nouvelle base de données nommée `b2bn_platform`
- Utiliser l'encodage `utf8mb4_unicode_ci`

#### 3. Configuration du projet
Depuis le répertoire `C:\xampp2025\htdocs\b2bn\` :

```bash
# Copier le fichier de configuration
cp .env.example .env

# Générer la clé d'application (si Composer est installé)
composer install
php artisan key:generate
```

#### 4. Configurer la base de données
Éditer le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=b2bn_platform
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Initialiser la base de données
```bash
# Exécuter les migrations et seeders
php artisan migrate --seed
```

#### 6. Configurer les permissions (sur Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

#### 7. Accéder à l'application
- Ouvrir http://localhost/b2bn dans votre navigateur
- Vous serez redirigé vers la page de connexion

## Comptes de test par défaut

### Grossiste (Administrateur)
- **Email :** grossiste@b2b.com
- **Mot de passe :** password
- **Accès :** Interface d'administration complète

### Vendeurs
1. **Ahmed Ben Mohamed**
   - Email : ahmed@vendeur1.com
   - Mot de passe : password
   - Groupe : VIP (remise 15%)

2. **Fatma Trabelsi**
   - Email : fatma@vendeur2.com
   - Mot de passe : password
   - Groupe : Grosses commandes (remise 10%)

3. **Mohamed Ali**
   - Email : ali@vendeur3.com
   - Mot de passe : password
   - Groupe : Partenaires privilégiés (remise 12%)

4. **Salma Karray**
   - Email : salma@vendeur4.com
   - Mot de passe : password
   - Groupe : Standard (pas de remise)

## Structure des URLs

### Interface Vendeur
- Dashboard : `/dashboard`
- Produits : `/products`
- Panier : `/cart`
- Commandes : `/orders`
- Messages : `/messages`
- Profil : `/profile`

### Interface Grossiste (Admin)
- Dashboard Admin : `/admin/dashboard`
- Gestion vendeurs : `/admin/users`
- Gestion produits : `/admin/products`
- Gestion commandes : `/admin/orders`
- Messages : `/admin/messages`

## Fonctionnalités testables

### Pour les vendeurs
1. **Navigation produits**
   - Parcourir le catalogue par catégories
   - Rechercher des produits
   - Voir les prix personnalisés selon votre groupe

2. **Gestion panier**
   - Ajouter des produits au panier
   - Modifier les quantités
   - Respect des quantités minimales

3. **Passation de commandes**
   - Finaliser une commande
   - Suivre le statut des commandes
   - Consulter l'historique

4. **Messagerie**
   - Envoyer des messages au grossiste
   - Recevoir des réponses
   - Conversation en temps réel

### Pour le grossiste
1. **Gestion des vendeurs**
   - Créer de nouveaux comptes vendeurs
   - Assigner des groupes de clients
   - Activer/désactiver des comptes

2. **Gestion catalogue**
   - Ajouter/modifier des produits
   - Gérer les catégories
   - Mettre à jour les stocks

3. **Gestion des commandes**
   - Visualiser toutes les commandes
   - Changer le statut des commandes
   - Ajouter des notes internes

4. **Tarification**
   - Créer des prix personnalisés
   - Configurer des groupes de clients
   - Gérer les promotions

## Dépannage

### Problèmes courants

#### Erreur "Class not found"
```bash
composer dump-autoload
```

#### Problème de permissions
```bash
# Sur Linux/Mac
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Sur Windows avec XAMPP
# Vérifier que le dossier n'est pas en lecture seule
```

#### Base de données non accessible
- Vérifier que MySQL est démarré dans XAMPP
- Vérifier les paramètres dans `.env`
- Tester la connexion dans phpMyAdmin

#### Page blanche ou erreur 500
- Vérifier les logs dans `storage/logs/laravel.log`
- Activer le debug : `APP_DEBUG=true` dans `.env`
- Vider le cache : `php artisan cache:clear`

### Commandes utiles pour le développement

```bash
# Réinitialiser complètement la base de données
php artisan migrate:fresh --seed

# Vider tous les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Voir les routes disponibles
php artisan route:list

# Lancer les tests
php artisan test

# Générer un contrôleur
php artisan make:controller NomController

# Générer un modèle avec migration
php artisan make:model NomModel -m

# Voir les jobs en queue
php artisan queue:work
```

## Configuration avancée

### Mail (optionnel)
Pour les notifications par email, configurer dans `.env` :
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe
MAIL_ENCRYPTION=tls
```

### Websockets pour le chat en temps réel
Installer Pusher ou utiliser Laravel Websockets :
```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=votre-app-id
PUSHER_APP_KEY=votre-app-key
PUSHER_APP_SECRET=votre-app-secret
PUSHER_APP_CLUSTER=eu
```

### Optimisation pour la production
```bash
# Optimiser l'autoloader
composer install --optimize-autoloader --no-dev

# Mettre en cache les configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compiler les assets (si utilisé)
npm run production
```

## Support

Pour toute question ou problème :
1. Consulter les logs dans `storage/logs/`
2. Vérifier la documentation Laravel : https://laravel.com/docs
3. Contacter l'équipe de développement

---

**Note :** Ce guide suppose une installation sur un environnement de développement. Pour une mise en production, des étapes supplémentaires de sécurisation sont nécessaires.