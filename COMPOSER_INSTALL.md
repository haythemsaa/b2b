# Installation de Composer pour Windows

## Option 1 : Installation automatique (Recommandée)

1. **Télécharger l'installateur :**
   - Aller sur https://getcomposer.org/download/
   - Télécharger `Composer-Setup.exe`

2. **Exécuter l'installateur :**
   - Double-cliquer sur `Composer-Setup.exe`
   - Suivre les instructions
   - L'installateur détectera automatiquement PHP

3. **Vérifier l'installation :**
   ```cmd
   composer --version
   ```

## Option 2 : Installation manuelle

1. **Télécharger Composer :**
   ```cmd
   cd C:\xampp2025\htdocs\b2bn
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   php composer-setup.php
   php -r "unlink('composer-setup.php');"
   ```

2. **Installer les dépendances :**
   ```cmd
   php composer.phar install
   ```

## Option 3 : Installation via PowerShell

Ouvrir PowerShell en tant qu'administrateur et exécuter :

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force
[System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
iex ((New-Object System.Net.WebClient).DownloadString('https://getcomposer.org/installer'))
```

## Après l'installation de Composer

1. **Installer les dépendances Laravel :**
   ```cmd
   cd C:\xampp2025\htdocs\b2bn
   composer install
   ```

2. **Générer la clé d'application :**
   ```cmd
   php artisan key:generate
   ```

3. **Importer la base de données :**
   - Créer `b2bn_platform` dans phpMyAdmin
   - Importer `database_schema.sql`
   - Importer `database_data.sql`

4. **Accéder à l'application :**
   - http://localhost/b2bn

## En cas de problème

### Erreur SSL/HTTPS :
Ajouter dans `php.ini` (C:\xampp2025\php\php.ini) :
```ini
openssl.cafile="C:\xampp2025\apache\bin\curl-ca-bundle.crt"
```

### PHP non trouvé :
Ajouter au PATH Windows :
```
C:\xampp2025\php
```

### Permissions Windows :
Exécuter l'invite de commande en tant qu'administrateur.

## Version de démonstration

En attendant l'installation de Composer, vous pouvez tester une version simplifiée :
- http://localhost/b2bn/public/simple-demo.php

Cette version inclut :
- Connexion avec les comptes de test
- Dashboard basique
- Statistiques simples
- Interface utilisateur