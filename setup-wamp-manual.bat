@echo off
echo ================================================
echo Configuration B2B Platform pour WAMP - Manuel
echo ================================================
echo.

set PHP_PATH=C:\wamp64\bin\php\php8.1.0\php.exe

echo 1. Test de PHP 8.1...
%PHP_PATH% --version
echo.

echo 2. Creation de l'environnement...
if not exist ".env" (
    copy ".env.example" ".env"
    echo Fichier .env cree
)

echo.
echo 3. Generation de la cle d'application...
powershell -Command "$guid = [System.Guid]::NewGuid().ToString().Replace('-',''); $key = [System.Convert]::ToBase64String([System.Text.Encoding]::UTF8.GetBytes($guid + 'B2BPlatform2024')); (Get-Content .env) -replace 'APP_KEY=.*', ('APP_KEY=base64:' + $key) | Set-Content .env"
echo Cle d'application generee

echo.
echo 4. Configuration de la base de donnees...
echo.
echo INSTRUCTIONS :
echo 1. Demarrez WAMP si ce n'est pas fait
echo 2. Verifiez que l'icone WAMP est verte
echo 3. Allez sur http://localhost/phpmyadmin
echo 4. Creez une base 'b2bn_platform' (utf8mb4_unicode_ci)
echo 5. Importez 'database_schema.sql'
echo 6. Importez 'database_data.sql'
echo.
echo Appuyez sur une touche quand c'est fait...
pause

echo.
echo 5. Test de la connexion base de donnees...
%PHP_PATH% -r "try { new PDO('mysql:host=127.0.0.1;dbname=b2bn_platform', 'root', ''); echo 'Base de donnees OK' . PHP_EOL; } catch(Exception $e) { echo 'Erreur DB: ' . $e->getMessage() . PHP_EOL; }"

echo.
echo 6. Configuration WAMP terminee !
echo.
echo ACCES A L'APPLICATION :
echo.
echo Version demo (fonctionne immediatement) :
echo http://localhost/b2bn/public/simple-demo.php
echo.
echo Version complete (apres installation Composer) :
echo http://localhost/b2bn/public
echo.
echo INSTALLATION COMPOSER (optionnelle) :
echo 1. Telecharger : https://getcomposer.org/Composer-Setup.exe
echo 2. Installer
echo 3. Executer dans ce dossier : composer install
echo.
echo COMPTES DE TEST :
echo Grossiste : grossiste@b2b.com / password
echo Vendeur   : ahmed@vendeur1.com / password
echo.
pause