@echo off
echo ================================================
echo Installation directe Composer - Solution definitive
echo ================================================
echo.

set PHP81=C:\wamp64\bin\php\php8.1.0\php.exe

echo 1. Verification PHP 8.1...
if not exist "%PHP81%" (
    echo ERREUR: PHP 8.1 non trouve
    pause
    exit /b 1
)

%PHP81% --version
echo.

echo 2. Telechargement manuel de Composer...
echo.
echo OPTION A - Installateur Windows (RECOMMANDE) :
echo 1. Allez sur : https://getcomposer.org/download/
echo 2. Telechargez "Composer-Setup.exe"
echo 3. Pendant l'installation, quand demande, specifiez :
echo    %PHP81%
echo 4. Apres installation : composer install
echo.

echo OPTION B - Installation manuelle :
echo Si l'option A ne fonctionne pas :
echo 1. Telechargez https://getcomposer.org/composer.phar
echo 2. Sauvegardez-le dans ce dossier
echo 3. Executez : php composer.phar install
echo.

echo OPTION C - Sans Composer (IMMEDIAT) :
echo Votre application fonctionne deja !
echo http://localhost/b2bn/public/simple-demo.php
echo.

echo Voulez-vous :
echo [1] Ouvrir la page de telechargement Composer
echo [2] Tester l'application sans Composer
echo [3] Continuer manuellement
echo.

set /p choice=Votre choix (1-3) :

if "%choice%"=="1" (
    start https://getcomposer.org/download/
    echo.
    echo Apres avoir installe Composer :
    echo 1. Redemarrez cette invite de commande
    echo 2. Tapez : composer install
    echo 3. Puis : composer run post-create-project-cmd
) else if "%choice%"=="2" (
    echo.
    echo Ouverture de la demo...
    echo N'oubliez pas de creer la base de donnees !
    start http://localhost/b2bn/public/simple-demo.php
    start http://localhost/phpmyadmin
) else (
    echo.
    echo Installation manuelle en cours...
    echo.
    echo Si vous avez telecharge composer.phar :
    echo Placez-le dans ce dossier et executez :
    echo %PHP81% composer.phar install
)

echo.
echo ================================================
echo Base de donnees requise
echo ================================================
echo.
echo N'oubliez pas de :
echo 1. Creer la base 'b2bn_platform' dans phpMyAdmin
echo 2. Importer 'database_schema.sql'
echo 3. Importer 'database_data.sql'
echo.
echo Comptes de test :
echo grossiste@b2b.com / password
echo ahmed@vendeur1.com / password
echo.
pause