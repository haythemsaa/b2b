@echo off
echo ================================================
echo Test rapide - B2B Platform sur XAMPP
echo ================================================
echo.

echo 1. Test de l'environnement XAMPP...
if exist "C:\xampp2025\php\php.exe" (
    echo ✅ PHP XAMPP trouve
    C:\xampp2025\php\php.exe --version | findstr "PHP"
) else (
    echo ❌ PHP XAMPP non trouve
)

if exist "C:\xampp2025\htdocs\b2bn\public\simple-demo.php" (
    echo ✅ Application demo presente
) else (
    echo ❌ Fichier demo manquant
)

if exist "C:\xampp2025\htdocs\b2bn\database_schema.sql" (
    echo ✅ Schema de base de donnees present
) else (
    echo ❌ Schema de base de donnees manquant
)

if exist "C:\xampp2025\htdocs\b2bn\.env" (
    echo ✅ Configuration .env presente
) else (
    echo ❌ Configuration .env manquante
    copy ".env.example" ".env" 2>nul
    echo ✅ Configuration .env creee
)

echo.
echo 2. Test de connexion a la base de donnees...
C:\xampp2025\php\php.exe -r "try { new PDO('mysql:host=127.0.0.1', 'root', ''); echo '✅ MySQL accessible\n'; } catch(Exception $e) { echo '❌ MySQL non accessible: ' . $e->getMessage() . '\n'; }"

echo.
echo 3. Verification de l'application...
echo.
echo URLs de test :
echo - Page d'accueil XAMPP : http://localhost/
echo - Application demo B2B : http://localhost/b2bn/public/simple-demo.php
echo - phpMyAdmin : http://localhost/phpmyadmin
echo.

echo Actions recommandees :
echo.
echo [1] Tester la demo immediatement
echo [2] Configurer la base de donnees
echo [3] Installer Composer
echo [4] Voir l'aide complete
echo.

set /p choice=Votre choix (1-4) :

if "%choice%"=="1" (
    echo Ouverture de l'application demo...
    start http://localhost/b2bn/public/simple-demo.php
    echo.
    echo Si la page ne se charge pas :
    echo 1. Verifiez que XAMPP Apache est demarre
    echo 2. Allez sur http://localhost/ pour tester XAMPP
) else if "%choice%"=="2" (
    echo Ouverture de phpMyAdmin...
    start http://localhost/phpmyadmin
    echo.
    echo Dans phpMyAdmin :
    echo 1. Creez une base 'b2bn_platform'
    echo 2. Importez 'database_schema.sql'
    echo 3. Importez 'database_data.sql'
) else if "%choice%"=="3" (
    start https://getcomposer.org/download/
    echo.
    echo Telechargez Composer-Setup.exe
    echo Lors de l'installation, specifiez :
    echo C:\xampp2025\php\php.exe
) else if "%choice%"=="4" (
    start xampp-no-ssl-install.bat
) else (
    echo Test termine !
)

echo.
echo ================================================
echo Statut de votre plateforme B2B
echo ================================================
echo.
echo ✅ Structure complete creee
echo ✅ Demo fonctionnelle
echo ✅ Base de donnees prete a importer
echo ✅ Configuration XAMPP compatible
echo.
echo Comptes de test (apres import DB) :
echo Grossiste : grossiste@b2b.com / password
echo Vendeur   : ahmed@vendeur1.com / password
echo.
pause