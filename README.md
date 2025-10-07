# Plateforme B2B - Grossiste-Vendeurs

Une plateforme e-commerce B2B développée avec Laravel pour faciliter les échanges commerciaux entre grossistes et vendeurs.

## Fonctionnalités

### Pour les Vendeurs
- 🔐 Authentification sécurisée
- 📦 Catalogue produits avec recherche et filtres
- 💰 Tarification personnalisée par client
- 🛒 Panier d'achat avec validation des quantités
- 📋 Gestion des commandes et historique
- 💬 Messagerie instantanée avec le grossiste
- 🌍 Support multilingue (Français/Arabe)

### Pour les Grossistes (Admin)
- 📊 Tableau de bord avec statistiques
- 👥 Gestion des comptes vendeurs
- 📦 Gestion du catalogue produits
- 💰 Configuration des prix personnalisés et promotions
- 📋 Traitement des commandes
- 📦 Gestion des stocks avec alertes
- 💬 Messagerie avec tous les vendeurs

## Prérequis

- PHP 8.1 ou supérieur
- MySQL 5.7 ou supérieur
- Composer
- Node.js et NPM (optionnel, pour le développement frontend)

## Installation

### 1. Cloner le projet
```bash
git clone <repository-url>
cd b2bn
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configuration de l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configuration de la base de données
Éditer le fichier `.env` avec vos paramètres de base de données :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=b2bn_platform
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Créer la base de données
Créer une base de données MySQL nommée `b2bn_platform`

### 6. Exécuter les migrations et seeders
```bash
php artisan migrate --seed
```

### 7. Démarrer le serveur de développement
```bash
php artisan serve
```

L'application sera accessible à l'adresse : http://localhost:8000

## Comptes de test

### Grossiste (Admin)
- Email : `grossiste@b2b.com`
- Mot de passe : `password`
- Accès : Interface d'administration

### Vendeurs
- Email : `ahmed@vendeur1.com` | Mot de passe : `password`
- Email : `fatma@vendeur2.com` | Mot de passe : `password`
- Email : `ali@vendeur3.com` | Mot de passe : `password`
- Email : `salma@vendeur4.com` | Mot de passe : `password`

## Structure de la base de données

### Tables principales
- `users` - Utilisateurs (grossistes et vendeurs)
- `categories` - Catégories de produits
- `products` - Catalogue des produits
- `customer_groups` - Groupes de clients pour la tarification
- `custom_prices` - Prix personnalisés par client/groupe
- `orders` - Commandes
- `order_items` - Lignes de commande
- `messages` - Messagerie instantanée
- `notifications` - Notifications système

### Relations importantes
- Un vendeur peut appartenir à plusieurs groupes de clients
- Un produit peut avoir plusieurs prix personnalisés
- Une commande contient plusieurs lignes de produits
- Les messages sont liés entre utilisateurs (one-to-one conversation)

## Fonctionnalités avancées

### Tarification différenciée
- Prix de base par produit
- Prix personnalisés par vendeur spécifique
- Prix de groupe pour les catégories de clients
- Promotions temporaires ciblées

### Gestion des stocks
- Suivi en temps réel des quantités
- Alertes de stock faible
- Contrôle des quantités minimales et multiples de commande
- Décrémentation automatique lors des commandes

### Messagerie instantanée
- Chat en temps réel entre vendeurs et grossiste
- Historique des conversations
- Notifications de nouveaux messages
- Interface responsive

### Support multilingue
- Interface en français et arabe
- Support RTL pour l'arabe
- Changement de langue par utilisateur
- Contenu traduit dynamiquement

## Configuration avancée

### Cache et performances
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Queue pour les notifications
```bash
php artisan queue:work
```

### Websockets pour le chat en temps réel
Configuration avec Pusher dans le fichier `.env` :
```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster
```

## Développement

### Commandes utiles
```bash
# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Créer un nouveau modèle avec migration
php artisan make:model ModelName -m

# Créer un contrôleur
php artisan make:controller ControllerName

# Créer un middleware
php artisan make:middleware MiddlewareName

# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Tests
```bash
php artisan test
```

## Sécurité

- Authentification sécurisée avec Laravel Sanctum
- Protection CSRF sur tous les formulaires
- Validation des données côté serveur
- Contrôle d'accès basé sur les rôles
- Chiffrement des mots de passe
- Protection contre les injections SQL

## Support et maintenance

### Logs
Les logs de l'application sont disponibles dans `storage/logs/laravel.log`

### Sauvegarde
Planifier des sauvegardes régulières de :
- Base de données MySQL
- Fichiers uploadés dans `storage/app/public`

### Mise à jour
1. Sauvegarder la base de données et les fichiers
2. Mettre à jour le code source
3. Exécuter `composer install`
4. Exécuter `php artisan migrate`
5. Nettoyer les caches

## Roadmap

### Version future (Phase Mobile)
- Application mobile native iOS/Android
- API REST complète
- Notifications push
- Mode hors ligne
- Synchronisation des données

### Améliorations prévues
- Rapports et analytics avancés
- Intégration système de paiement
- Gestion multi-entrepôts
- Module de facturation automatique
- Intégration ERP externe

## Licence

Cette application est développée pour un usage commercial privé.

## Contact et support

Pour toute question ou support technique, veuillez contacter l'équipe de développement.