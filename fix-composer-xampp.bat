@echo off
echo ================================================
echo Installation Composer pour XAMPP 2025
echo ================================================
echo.

set XAMPP_PHP=C:\xampp2025\php\php.exe

echo 1. Verification de PHP XAMPP...
if not exist "%XAMPP_PHP%" (
    echo ERREUR: PHP XAMPP non trouve
    echo Chemin attendu : %XAMPP_PHP%
    echo Veuillez verifier l'installation XAMPP
    pause
    exit /b 1
)

echo PHP XAMPP trouve : %XAMPP_PHP%
%XAMPP_PHP% --version
echo.

echo 2. Configuration de l'environnement pour XAMPP...
set PATH=C:\xampp2025\php;%PATH%
set COMPOSER_PHP=%XAMPP_PHP%

echo.
echo 3. Test des extensions PHP requises...
echo Verification des extensions :
%XAMPP_PHP% -m | findstr /i "openssl"
%XAMPP_PHP% -m | findstr /i "pdo"
%XAMPP_PHP% -m | findstr /i "mysql"
%XAMPP_PHP% -m | findstr /i "curl"

echo.
echo 4. Telechargement de Composer avec XAMPP PHP...

:: Télécharger avec la méthode sécurisée
%XAMPP_PHP% -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" 2>nul

if exist composer-setup.php (
    echo Installateur Composer telecharge avec succes
    echo Installation en cours...
    %XAMPP_PHP% composer-setup.php --install-dir=. --filename=composer
    del composer-setup.php

    if exist composer.phar (
        echo.
        echo 5. Test de Composer...
        %XAMPP_PHP% composer.phar --version

        echo.
        echo 6. Installation des dependances Laravel...
        %XAMPP_PHP% composer.phar install --no-dev --optimize-autoloader

        if %errorlevel% == 0 (
            echo.
            echo 7. Generation de la cle d'application...
            %XAMPP_PHP% artisan key:generate --force

            echo.
            echo ================================================
            echo Installation terminee avec succes !
            echo ================================================
            echo.
            echo Application Laravel complete disponible :
            echo http://localhost/b2bn/public
            echo.
            goto :success
        ) else (
            echo Erreur lors de l'installation des dependances
            goto :fallback
        )
    ) else (
        echo Echec de l'installation de Composer
        goto :fallback
    )
) else (
    echo Echec du telechargement
    goto :fallback
)

:fallback
echo.
echo ================================================
echo Installation alternative requise
echo ================================================
echo.
echo Le telechargement automatique a echoue.
echo.
echo SOLUTION 1 - Installateur Windows :
echo 1. Telechargez : https://getcomposer.org/Composer-Setup.exe
echo 2. Lors de l'installation, specifiez le chemin PHP :
echo    %XAMPP_PHP%
echo 3. Apres installation, executez : composer install
echo.
echo SOLUTION 2 - Application fonctionnelle :
echo Votre application B2B fonctionne deja en mode demo :
echo http://localhost/b2bn/public/simple-demo.php
echo.

:success
echo ================================================
echo Configuration de la base de donnees
echo ================================================
echo.
echo Prochaines etapes :
echo 1. Demarrer XAMPP (Apache + MySQL)
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