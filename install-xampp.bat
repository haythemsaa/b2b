@echo off
echo ================================================
echo Installation B2B Platform pour XAMPP
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
echo Veuillez creer la base de donnees 'b2bn_platform' dans phpMyAdmin
echo Appuyez sur une touche quand c'est fait...
pause

echo.
echo 3. Generation de la cle d'application...
echo Mise a jour du fichier .env avec une cle generee...

:: Generer une cle simple pour Laravel
echo APP_KEY=base64:QmFzZTY0S2V5Rm9yTGFyYXZlbEFwcGxpY2F0aW9u > temp_key.txt

:: Remplacer la ligne APP_KEY dans .env
powershell -Command "(Get-Content .env) -replace 'APP_KEY=', 'APP_KEY=base64:QmFzZTY0S2V5Rm9yTGFyYXZlbEFwcGxpY2F0aW9u' | Set-Content .env"
del temp_key.txt

echo Cle d'application generee avec succes.
echo.

echo 4. Creation des tables de base de donnees...
echo ATTENTION: Executez manuellement ces commandes SQL dans phpMyAdmin:
echo.
echo -- Connectez-vous a phpMyAdmin (http://localhost/phpmyadmin)
echo -- Selectionnez la base 'b2bn_platform'
echo -- Executez le contenu du fichier database_schema.sql
echo.

echo 5. Creation du schema de base de donnees...
echo Appuyez sur une touche pour continuer...
pause

echo.
echo ================================================
echo Installation terminee !
echo ================================================
echo.
echo Prochaines etapes :
echo 1. Ouvrez phpMyAdmin : http://localhost/phpmyadmin
echo 2. Selectionnez la base 'b2bn_platform'
echo 3. Importez le fichier 'database_schema.sql'
echo 4. Puis importez 'database_data.sql' pour les donnees de test
echo 5. Accedez a l'application : http://localhost/b2bn
echo.
echo Comptes de test :
echo   Grossiste : grossiste@b2b.com / password
echo   Vendeur   : ahmed@vendeur1.com / password
echo.
pause