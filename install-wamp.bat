@echo off
echo ================================================
echo Installation B2B Platform pour WAMP64
echo ================================================
echo.

set PHP_PATH=C:\wamp64\bin\php\php8.1.0\php.exe

echo 1. Verification de PHP 8.1...
if not exist "%PHP_PATH%" (
    echo ERREUR: PHP 8.1 non trouve dans WAMP
    echo Chemins disponibles :
    dir C:\wamp64\bin\php\
    echo.
    echo Veuillez ajuster PHP_PATH dans ce script si necessaire
    pause
    exit /b 1
)

echo PHP trouve : %PHP_PATH%
%PHP_PATH% --version
echo.

echo 2. Telechargement de Composer...
echo Tentative de telechargement de Composer...

:: Essayer de telecharger Composer avec curl si disponible
curl --version >nul 2>&1
if %errorlevel% == 0 (
    echo Telechargement avec curl...
    curl -sS https://getcomposer.org/installer -o composer-setup.php
    if exist composer-setup.php (
        echo Installation de Composer...
        %PHP_PATH% composer-setup.php
        del composer-setup.php
        if exist composer.phar (
            echo Composer installe avec succes !
            goto :install_deps
        )
    )
)

echo.
echo Telechargement automatique echoue. Installation manuelle requise.
echo.
echo Veuillez :
echo 1. Telecharger Composer depuis https://getcomposer.org/download/
echo 2. Installer Composer-Setup.exe
echo 3. Redemarrer cette invite de commande
echo 4. Puis executer : composer install
echo.
echo Appuyez sur une touche pour continuer avec l'installation de base...
pause
goto :database_setup

:install_deps
echo.
echo 3. Installation des dependances Laravel...
if exist composer.phar (
    %PHP_PATH% composer.phar install --no-dev --optimize-autoloader
) else (
    composer install --no-dev --optimize-autoloader
)

:database_setup
echo.
echo 4. Configuration de la base de donnees...
echo.
echo IMPORTANT: Veuillez maintenant :
echo 1. Demarrer WAMP (si ce n'est pas fait)
echo 2. Aller sur http://localhost/phpmyadmin
echo 3. Creer une base de donnees 'b2bn_platform'
echo 4. Utiliser l'encodage utf8mb4_unicode_ci
echo.
echo Appuyez sur une touche quand c'est fait...
pause

echo.
echo 5. Import du schema...
echo.
echo Dans phpMyAdmin :
echo 1. Selectionnez la base 'b2bn_platform'
echo 2. Onglet 'Importer'
echo 3. Selectionnez 'database_schema.sql'
echo 4. Cliquez 'Executer'
echo 5. Puis repetez avec 'database_data.sql'
echo.
echo Appuyez sur une touche quand l'import est termine...
pause

echo.
echo 6. Generation de la cle d'application...
if exist artisan (
    %PHP_PATH% artisan key:generate --force
) else (
    echo Generation manuelle de la cle...
    powershell -Command "$key = [System.Convert]::ToBase64String([System.Text.Encoding]::UTF8.GetBytes([System.Guid]::NewGuid().ToString() + 'B2BPlatform')); (Get-Content .env) -replace 'APP_KEY=.*', ('APP_KEY=base64:' + $key) | Set-Content .env"
)

echo.
echo 7. Configuration du serveur WAMP...
echo.
echo Assurez-vous que WAMP pointe vers le bon repertoire :
echo - Repertoire racine : C:\xampp2025\htdocs\b2bn\public
echo - Ou ajustez l'URL : http://localhost/b2bn/public
echo.

echo ================================================
echo Installation terminee !
echo ================================================
echo.
echo Acces a l'application :
echo - Version complete : http://localhost/b2bn/public
echo - Version demo : http://localhost/b2bn/public/simple-demo.php
echo.
echo Comptes de test :
echo   Grossiste : grossiste@b2b.com / password
echo   Vendeur   : ahmed@vendeur1.com / password
echo.
echo Si des erreurs persistent :
echo 1. Verifiez que WAMP est demarre
echo 2. Verifiez la base de donnees
echo 3. Consultez COMPOSER_INSTALL.md
echo.
pause