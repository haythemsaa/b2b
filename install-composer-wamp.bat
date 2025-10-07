@echo off
echo ================================================
echo Installation Composer pour WAMP64 - PHP 8.1.0
echo ================================================
echo.

set WAMP_PHP=C:\wamp64\bin\php\php8.1.0\php.exe

echo 1. Verification de PHP WAMP 8.1.0...
if not exist "%WAMP_PHP%" (
    echo ERREUR: PHP 8.1.0 non trouve
    echo Chemin attendu : %WAMP_PHP%
    pause
    exit /b 1
)

echo PHP WAMP 8.1.0 trouve : %WAMP_PHP%
"%WAMP_PHP%" --version
echo.

echo 2. Test des extensions PHP requises...
echo Verification des extensions :
"%WAMP_PHP%" -m | findstr /i "openssl"
"%WAMP_PHP%" -m | findstr /i "pdo"
"%WAMP_PHP%" -m | findstr /i "mysql"
"%WAMP_PHP%" -m | findstr /i "curl"

echo.
echo 3. Telechargement de Composer...

:: Télécharger avec PHP 8.1.0
"%WAMP_PHP%" -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

if exist composer-setup.php (
    echo Installateur Composer telecharge avec succes
    echo Installation en cours...
    "%WAMP_PHP%" composer-setup.php --install-dir=. --filename=composer
    del composer-setup.php

    if exist composer.phar (
        echo.
        echo 4. Test de Composer...
        "%WAMP_PHP%" composer.phar --version

        echo.
        echo 5. Installation des dependances Laravel...
        "%WAMP_PHP%" composer.phar install --no-dev --optimize-autoloader

        if %errorlevel% == 0 (
            echo.
            echo 6. Generation de la cle d'application...
            "%WAMP_PHP%" artisan key:generate --force

            echo.
            echo ================================================
            echo Installation terminee avec succes !
            echo ================================================
            echo.
            echo Application Laravel complete disponible :
            echo http://localhost/b2bn/public
            echo.
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

goto :success

:fallback
echo.
echo ================================================
echo Installation alternative
echo ================================================
echo.
echo SOLUTION 1 - Installateur Windows :
echo 1. Telechargez : https://getcomposer.org/Composer-Setup.exe
echo 2. Lors de l'installation, specifiez le chemin PHP :
echo    %WAMP_PHP%
echo 3. Apres installation, executez : composer install
echo.
echo SOLUTION 2 - Application demo fonctionnelle :
echo http://localhost/b2bn/public/simple-demo.php
echo.

:success
echo ================================================
echo Configuration terminee
echo ================================================
echo.
echo Prochaines etapes :
echo 1. Demarrer WAMP (Apache + MySQL)
echo 2. Aller sur http://localhost/phpmyadmin
echo 3. Importer database_data_fixed.sql
echo 4. Tester l'application
echo.
echo Comptes de test :
echo Grossiste : grossiste@b2b.com / password
echo Vendeur   : ahmed@vendeur1.com / password
echo.

echo Voulez-vous tester l'application maintenant ? (O/N)
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