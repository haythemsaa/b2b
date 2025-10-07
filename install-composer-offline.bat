@echo off
echo ================================================
echo Installation Composer - Methode alternative
echo ================================================
echo.

echo Cette methode evite les problemes SSL en utilisant des alternatives.
echo.

echo Option 1 : Installation executable Windows
echo ==========================================
echo 1. Allez sur : https://getcomposer.org/download/
echo 2. Telechargez "Composer-Setup.exe"
echo 3. Executez l'installateur
echo 4. Redemarrez l'invite de commande
echo 5. Tapez : composer install
echo.

echo Option 2 : Telechargement direct du PHAR
echo ========================================
echo Si l'option 1 ne fonctionne pas :
echo 1. Allez sur : https://getcomposer.org/composer.phar
echo 2. Clic droit > "Enregistrer sous" > composer.phar
echo 3. Placez composer.phar dans ce dossier
echo 4. Executez : php composer.phar install
echo.

echo Option 3 : Utilisation sans Composer
echo ====================================
echo L'application fonctionne deja avec la demo :
echo http://localhost/b2bn/public/simple-demo.php
echo.
echo Cette version inclut :
echo - Connexion utilisateur
echo - Dashboard complet
echo - Statistiques en temps reel
echo - Interface responsive
echo.

echo Comptes de test :
echo Grossiste : grossiste@b2b.com / password
echo Vendeur   : ahmed@vendeur1.com / password
echo.

echo ================================================
echo Instructions de base de donnees
echo ================================================
echo.
echo Avant d'utiliser l'application :
echo 1. Demarrez WAMP (icone verte)
echo 2. Allez sur http://localhost/phpmyadmin
echo 3. Creez une base 'b2bn_platform'
echo 4. Importez 'database_schema.sql'
echo 5. Importez 'database_data.sql'
echo.

echo Voulez-vous ouvrir phpMyAdmin maintenant ? (O/N)
set /p choice=Votre choix :
if /i "%choice%"=="O" start http://localhost/phpmyadmin

echo.
echo Voulez-vous tester la demo maintenant ? (O/N)
set /p choice=Votre choix :
if /i "%choice%"=="O" start http://localhost/b2bn/public/simple-demo.php

echo.
pause