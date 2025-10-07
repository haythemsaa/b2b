# Configuration B2B Platform avec WAMP64

## 🚀 Installation rapide

### Étape 1 : Préparation
1. **Démarrer WAMP64** (icône verte dans la barre système)
2. **Vérifier PHP** : Clic droit WAMP → PHP → Version → **Sélectionner PHP 8.1.0**

### Étape 2 : Configuration automatique
```cmd
# Exécuter le script d'installation
double-clic sur setup-wamp-manual.bat
```

### Étape 3 : Base de données
1. **Aller sur** http://localhost/phpmyadmin
2. **Créer une base** : `b2bn_platform` (Interclassement: `utf8mb4_unicode_ci`)
3. **Importer** `database_schema.sql`
4. **Importer** `database_data.sql`

### Étape 4 : Accès
- **Version démo** : http://localhost/b2bn/public/simple-demo.php
- **Version complète** : http://localhost/b2bn/public (après installation Composer)

## 👤 Comptes de test
- **Grossiste** : grossiste@b2b.com / password
- **Vendeur** : ahmed@vendeur1.com / password

## 🔧 Résolution des problèmes courants

### Erreur "DLL manquante" avec PHP 5.6
**Solution :** Changer vers PHP 8.1
```
Clic droit WAMP → PHP → Version → 8.1.0
```

### "Base de données non trouvée"
**Vérifications :**
1. WAMP démarré (icône verte) ✅
2. Base `b2bn_platform` créée ✅
3. Fichiers SQL importés ✅

### Erreur 404 sur l'application
**Solutions :**
1. **URL correcte** : http://localhost/b2bn/public/simple-demo.php
2. **Vérifier le chemin** : Le dossier doit être dans `C:\wamp64\www\` ou pointer vers `C:\xampp2025\htdocs\b2bn\`

### Pour utiliser le chemin WAMP standard
Déplacer le dossier vers `C:\wamp64\www\b2bn\`
Puis accéder via : http://localhost/b2bn/public/simple-demo.php

## 📦 Installation complète avec Composer

### Option 1 : Installateur Windows
1. Télécharger https://getcomposer.org/Composer-Setup.exe
2. Installer et redémarrer l'invite de commande
3. Exécuter dans le dossier du projet :
   ```cmd
   composer install
   php artisan key:generate
   ```

### Option 2 : Installation manuelle
```cmd
# Avec PHP 8.1 de WAMP
cd C:\xampp2025\htdocs\b2bn
C:\wamp64\bin\php\php8.1.0\php.exe -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
C:\wamp64\bin\php\php8.1.0\php.exe composer-setup.php
C:\wamp64\bin\php\php8.1.0\php.exe composer.phar install
```

## ✅ Fonctionnalités disponibles

### Version démo (immédiate)
- ✅ Connexion utilisateur
- ✅ Dashboard grossiste/vendeur
- ✅ Statistiques de base
- ✅ Interface responsive

### Version complète (avec Composer)
- ✅ Toutes les fonctionnalités B2B
- ✅ Gestion des produits et commandes
- ✅ Panier et checkout
- ✅ Messagerie temps réel
- ✅ Tarification différenciée
- ✅ Support multilingue

## 🌍 Configuration des Virtual Hosts (Optionnel)

Pour un accès plus propre via http://b2b.local :

1. **Éditer** `C:\wamp64\bin\apache\apache2.4.x\conf\extra\httpd-vhosts.conf`
2. **Ajouter** :
   ```apache
   <VirtualHost *:80>
       DocumentRoot "C:/xampp2025/htdocs/b2bn/public"
       ServerName b2b.local
       <Directory "C:/xampp2025/htdocs/b2bn/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
3. **Éditer** `C:\Windows\System32\drivers\etc\hosts` (en admin)
4. **Ajouter** : `127.0.0.1 b2b.local`
5. **Redémarrer WAMP**

Accès via : http://b2b.local

## 📞 Support

En cas de problème :
1. Vérifier que WAMP est complètement démarré
2. Tester la démo d'abord : http://localhost/b2bn/public/simple-demo.php
3. Vérifier les logs WAMP : `C:\wamp64\logs\`