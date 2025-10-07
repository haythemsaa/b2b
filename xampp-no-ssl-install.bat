@echo off
echo ================================================
echo Installation B2B Platform - XAMPP 2025
echo Solution sans problemes SSL
echo ================================================
echo.

set XAMPP_PHP=C:\xampp2025\php\php.exe

echo 1. Verification XAMPP...
if not exist "%XAMPP_PHP%" (
    echo ERREUR: XAMPP non trouve dans C:\xampp2025\
    pause
    exit /b 1
)

echo XAMPP PHP trouve : %XAMPP_PHP%
%XAMPP_PHP% --version
echo.

echo 2. Configuration de l'environnement .env...
if not exist ".env" (
    copy ".env.example" ".env"
    echo Fichier .env cree
)

echo.
echo 3. Generation de la cle d'application...
powershell -Command "$bytes = [System.Text.Encoding]::UTF8.GetBytes([System.Guid]::NewGuid().ToString() + 'B2BPlatformXAMPP2025'); $key = [System.Convert]::ToBase64String($bytes); (Get-Content .env) -replace 'APP_KEY=.*', ('APP_KEY=base64:' + $key) | Set-Content .env"
echo Cle d'application generee avec succes
echo.

echo 4. Instructions pour Composer...
echo.
echo Le telechargement automatique de Composer echoue a cause des certificats SSL.
echo.
echo SOLUTION RECOMMANDEE :
echo 1. Allez sur : https://getcomposer.org/download/
echo 2. Telechargez "Composer-Setup.exe"
echo 3. Pendant l'installation, specifiez le chemin PHP :
echo    %XAMPP_PHP%
echo 4. Apres installation, ouvrez une nouvelle invite de commande
echo 5. Dans ce dossier, tapez : composer install
echo.

echo SOLUTION ALTERNATIVE :
echo Votre application B2B fonctionne deja sans Composer !
echo http://localhost/b2bn/public/simple-demo.php
echo.
echo Cette version demo inclut :
echo - Connexion securisee
echo - Dashboard complet
echo - Statistiques temps reel
echo - Interface responsive
echo.

echo ================================================
echo Configuration de la base de donnees
echo ================================================
echo.
echo Avant d'utiliser l'application :
echo 1. Demarrez XAMPP (Apache + MySQL)
echo 2. Allez sur http://localhost/phpmyadmin
echo 3. Creez une base de donnees : b2bn_platform
echo 4. Importez 'database_schema.sql'
echo 5. Importez 'database_data.sql'
echo.

echo Comptes de test apres import :
echo Grossiste : grossiste@b2b.com / password
echo Vendeur   : ahmed@vendeur1.com / password
echo.

echo Actions disponibles :
echo [1] Ouvrir phpMyAdmin
echo [2] Tester l'application demo
echo [3] Ouvrir la page de telechargement Composer
echo [4] Afficher les instructions detaillees
echo [5] Quitter
echo.

set /p choice=Votre choix (1-5) :

if "%choice%"=="1" (
    start http://localhost/phpmyadmin
    echo phpMyAdmin ouvert. Creez la base 'b2bn_platform' et importez les fichiers SQL.
) else if "%choice%"=="2" (
    start http://localhost/b2bn/public/simple-demo.php
    echo Application demo ouverte !
) else if "%choice%"=="3" (
    start https://getcomposer.org/download/
    echo Page de telechargement Composer ouverte.
    echo N'oubliez pas de specifier le chemin PHP lors de l'installation :
    echo %XAMPP_PHP%
) else if "%choice%"=="4" (
    goto :detailed_instructions
) else (
    echo Au revoir !
    goto :end
)

goto :end

:detailed_instructions
echo.
echo ================================================
echo Instructions detaillees
echo ================================================
echo.
echo ETAPE 1 - Demarrer XAMPP :
echo - Ouvrez le panneau de controle XAMPP
echo - Demarrez Apache et MySQL
echo - Verifiez que les voyants sont verts
echo.
echo ETAPE 2 - Creer la base de donnees :
echo - Allez sur http://localhost/phpmyadmin
echo - Cliquez "Nouvelle base de donnees"
echo - Nom : b2bn_platform
echo - Interclassement : utf8mb4_unicode_ci
echo - Cliquez "Creer"
echo.
echo ETAPE 3 - Importer les donnees :
echo - Selectionnez la base 'b2bn_platform'
echo - Onglet "Importer"
echo - "Choisir un fichier" ^> database_schema.sql
echo - Cliquez "Executer"
echo - Repetez avec database_data.sql
echo.
echo ETAPE 4 - Tester l'application :
echo - Version demo : http://localhost/b2bn/public/simple-demo.php
echo - Utilisez les comptes de test pour vous connecter
echo.
echo ETAPE 5 - Installation Composer (optionnelle) :
echo - Telechargez Composer-Setup.exe
echo - Specifiez le chemin PHP : %XAMPP_PHP%
echo - Puis : composer install
echo.

:end
echo.
pause