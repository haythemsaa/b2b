@echo off
echo ================================================
echo Installation Composer XAMPP - Sans verification SSL
echo ================================================
echo.

set XAMPP_PHP=C:\xampp2025\php\php.exe

echo 1. Verification de PHP XAMPP...
if not exist "%XAMPP_PHP%" (
    echo ERREUR: PHP XAMPP non trouve
    pause
    exit /b 1
)

echo PHP XAMPP trouve : %XAMPP_PHP%
%XAMPP_PHP% --version
echo.

echo 2. Telechargement manuel de Composer...
echo Telechargement de composer.phar depuis GitHub...

:: Utiliser PowerShell pour télécharger sans vérification SSL
powershell -Command "[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; [System.Net.ServicePointManager]::ServerCertificateValidationCallback = {$true}; Invoke-WebRequest -Uri 'https://getcomposer.org/composer.phar' -OutFile 'composer.phar'"

if exist composer.phar (
    echo Composer telecharge avec succes !
    echo.
    echo 3. Test de Composer...
    %XAMPP_PHP% composer.phar --version

    echo.
    echo 4. Installation des dependances Laravel...
    %XAMPP_PHP% composer.phar install --no-dev --optimize-autoloader --no-scripts

    if %errorlevel% == 0 (
        echo.
        echo 5. Configuration Laravel...
        if not exist ".env" copy ".env.example" ".env"
        %XAMPP_PHP% artisan key:generate --force

        echo.
        echo ================================================
        echo Installation reussie !
        echo ================================================
        echo.
        echo Application Laravel disponible :
        echo http://localhost/b2bn/public
        echo.
    ) else (
        echo Installation des dependances echouee, utilisation du mode demo
        goto :demo_mode
    )
) else (
    echo Echec du telechargement
    goto :demo_mode
)

goto :end

:demo_mode
echo.
echo ================================================
echo Mode demonstration
echo ================================================
echo.
echo L'application fonctionne en mode demo sans Composer :
echo http://localhost/b2bn/public/simple-demo.php
echo.
echo Pour installer Composer manuellement :
echo 1. Allez sur https://getcomposer.org/download/
echo 2. Telechargez Composer-Setup.exe
echo 3. Specifiez le chemin PHP : %XAMPP_PHP%
echo.

:end
echo Prochaines etapes :
echo 1. Importez database_data_fixed.sql dans phpMyAdmin
echo 2. Testez l'application
echo.
echo Comptes de test :
echo grossiste@b2b.com / password
echo ahmed@vendeur1.com / password
echo.

echo Voulez-vous ouvrir l'application ? (O/N)
set /p choice=Votre choix :
if /i "%choice%"=="O" (
    if exist composer.phar (
        start http://localhost/b2bn/public
    ) else (
        start http://localhost/b2bn/public/simple-demo.php
    )
)

pause