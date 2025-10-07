@echo off
echo ================================================
echo Configuration PHP 8.1 pour Composer sur WAMP
echo ================================================
echo.

set PHP81_PATH=C:\wamp64\bin\php\php8.1.0\php.exe
set COMPOSER_SETUP=https://getcomposer.org/installer

echo 1. Verification de PHP 8.1...
if not exist "%PHP81_PATH%" (
    echo ERREUR: PHP 8.1 non trouve
    echo Chemin attendu : %PHP81_PATH%
    echo.
    echo Versions disponibles dans WAMP :
    dir C:\wamp64\bin\php\
    pause
    exit /b 1
)

echo PHP 8.1 trouve : %PHP81_PATH%
%PHP81_PATH% --version
echo.

echo 2. Configuration de l'environnement pour cette session...
set PATH=C:\wamp64\bin\php\php8.1.0;%PATH%
set COMPOSER_PHP=%PHP81_PATH%

echo.
echo 3. Test de la connexion internet avec PHP 8.1...
%PHP81_PATH% -r "echo 'Test connexion: '; var_dump(file_get_contents('http://www.google.com', false, stream_context_create(['http'=>['timeout'=>5]])) !== false);"

echo.
echo 4. Installation directe de Composer avec PHP 8.1...

:: Méthode 1 : Téléchargement direct avec PHP 8.1
echo Tentative de telechargement avec PHP 8.1...
%PHP81_PATH% -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" 2>nul

if exist composer-setup.php (
    echo Installateur telecharge avec succes
    echo Installation de Composer...
    %PHP81_PATH% composer-setup.php --install-dir=. --filename=composer
    del composer-setup.php

    if exist composer.phar (
        echo Composer installe avec succes !
        goto :install_deps
    )
) else (
    echo Echec du telechargement automatique
    goto :manual_install
)

:install_deps
echo.
echo 5. Installation des dependances avec PHP 8.1...
%PHP81_PATH% composer.phar install --no-dev --optimize-autoloader

if %errorlevel% == 0 (
    echo.
    echo 6. Generation de la cle d'application...
    %PHP81_PATH% artisan key:generate --force

    echo.
    echo ================================================
    echo Installation terminee avec succes !
    echo ================================================
    echo.
    echo Application complete disponible :
    echo http://localhost/b2bn/public
    echo.
    goto :database_info
) else (
    echo Erreur lors de l'installation des dependances
    goto :manual_install
)

:manual_install
echo.
echo ================================================
echo Installation manuelle requise
echo ================================================
echo.
echo Composer n'a pas pu etre installe automatiquement.
echo.
echo SOLUTION RECOMMANDEE :
echo 1. Telechargez manuellement : https://getcomposer.org/Composer-Setup.exe
echo 2. Lors de l'installation, specifiez le chemin PHP :
echo    %PHP81_PATH%
echo 3. Apres installation, executez dans ce dossier :
echo    composer install
echo.
echo SOLUTION ALTERNATIVE :
echo Votre application fonctionne deja en version demo :
echo http://localhost/b2bn/public/simple-demo.php
echo.

:database_info
echo ================================================
echo Configuration de la base de donnees
echo ================================================
echo.
echo N'oubliez pas de :
echo 1. Demarrer WAMP (icone verte)
echo 2. Aller sur http://localhost/phpmyadmin
echo 3. Creer la base 'b2bn_platform'
echo 4. Importer 'database_schema.sql'
echo 5. Importer 'database_data.sql'
echo.
echo Comptes de test :
echo Grossiste : grossiste@b2b.com / password
echo Vendeur   : ahmed@vendeur1.com / password
echo.

echo Voulez-vous ouvrir phpMyAdmin maintenant ? (O/N)
set /p choice=Votre choix :
if /i "%choice%"=="O" start http://localhost/phpmyadmin

echo.
echo Voulez-vous tester l'application ? (O/N)
set /p choice=Votre choix :
if /i "%choice%"=="O" (
    if exist composer.phar (
        start http://localhost/b2bn/public
    ) else (
        start http://localhost/b2bn/public/simple-demo.php
    )
)

echo.
pause