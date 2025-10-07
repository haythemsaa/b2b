@echo off
echo ================================================
echo Installation B2B Platform sans Composer
echo ================================================
echo.

set PHP_PATH=C:\xampp2025\php\php.exe

echo 1. Verification de PHP...
if not exist "%PHP_PATH%" (
    echo ERREUR: PHP non trouve dans XAMPP
    echo Veuillez verifier que XAMPP est installe dans C:\xampp2025\
    pause
    exit /b 1
)

echo PHP trouve : %PHP_PATH%
echo.

echo 2. Creation de la base de donnees...
echo.
echo IMPORTANT: Avant de continuer, veuillez :
echo 1. Ouvrir phpMyAdmin : http://localhost/phpmyadmin
echo 2. Creer une nouvelle base de donnees nommee : b2bn_platform
echo 3. Utiliser l'encodage : utf8mb4_unicode_ci
echo.
echo Appuyez sur une touche quand la base de donnees est creee...
pause

echo.
echo 3. Import du schema de base de donnees...
echo.
echo Maintenant, importez les fichiers SQL dans phpMyAdmin :
echo 1. Selectionnez la base 'b2bn_platform'
echo 2. Cliquez sur 'Importer'
echo 3. Selectionnez et importez 'database_schema.sql'
echo 4. Puis importez 'database_data.sql'
echo.
echo Appuyez sur une touche quand l'import est termine...
pause

echo.
echo 4. Generation de la cle d'application...
echo Mise a jour du fichier .env...

:: Generer une cle aleatoire base64
powershell -Command "$key = [System.Convert]::ToBase64String([System.Text.Encoding]::UTF8.GetBytes('B2BPlatformSecretKey123456789012')); Write-Output $key" > temp_key.txt
set /p APP_KEY=<temp_key.txt
del temp_key.txt

:: Mettre a jour le fichier .env
powershell -Command "(Get-Content .env) -replace 'APP_KEY=.*', 'APP_KEY=base64:%APP_KEY%' | Set-Content .env"

echo Cle d'application generee avec succes.
echo.

echo 5. Creation du fichier d'index simplifie...
echo Preparation de l'application pour fonctionner sans Composer...

:: Creer un autoloader personnalise
echo ^<?php > bootstrap\autoload.php
echo // Autoloader personnalise pour B2B Platform >> bootstrap\autoload.php
echo spl_autoload_register(function ($class) { >> bootstrap\autoload.php
echo     $baseDir = __DIR__ . '/../'; >> bootstrap\autoload.php
echo     if (strpos($class, 'App\\') === 0) { >> bootstrap\autoload.php
echo         $file = $baseDir . 'app/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php'; >> bootstrap\autoload.php
echo         if (file_exists($file)) require_once $file; >> bootstrap\autoload.php
echo     } >> bootstrap\autoload.php
echo }); >> bootstrap\autoload.php

echo.
echo 6. Configuration terminee !
echo.
echo ================================================
echo Installation terminee avec succes !
echo ================================================
echo.
echo Votre application B2B est maintenant prete !
echo.
echo Acces : http://localhost/b2bn
echo.
echo Comptes de test :
echo   Grossiste : grossiste@b2b.com / password
echo   Vendeur   : ahmed@vendeur1.com / password
echo.
echo IMPORTANT: L'application fonctionne avec un autoloader simplifie.
echo Pour une installation complete, installez Composer et executez 'composer install'.
echo.
pause