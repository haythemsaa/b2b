@echo off
echo =======================================
echo   B2B Platform - Script de demarrage
echo =======================================
echo.

echo Verification de l'environnement...
if not exist ".env" (
    echo Copie du fichier de configuration...
    copy ".env.example" ".env"
)

echo.
echo Installation des dependances Composer...
composer install --no-dev --optimize-autoloader

echo.
echo Generation de la cle d'application...
php artisan key:generate --force

echo.
echo Execution des migrations et seeders...
php artisan migrate:fresh --seed --force

echo.
echo Nettoyage du cache...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo.
echo Optimisation pour la production...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo =======================================
echo   Installation terminee avec succes!
echo =======================================
echo.
echo Application disponible a : http://localhost/b2bn
echo.
echo Comptes de test :
echo   Grossiste : grossiste@b2b.com / password
echo   Vendeur   : ahmed@vendeur1.com / password
echo.
echo Appuyez sur une touche pour fermer...
pause >nul