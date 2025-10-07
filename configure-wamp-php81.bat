@echo off
echo ================================================
echo Configuration WAMP pour utiliser PHP 8.1 par defaut
echo ================================================
echo.

echo 1. Instructions pour configurer WAMP :
echo.
echo ETAPE 1 - Changer la version PHP dans WAMP :
echo   - Clic droit sur l'icone WAMP (barre systeme)
echo   - PHP ^> Version ^> 8.1.0
echo   - Attendre que WAMP redémarre (icone verte)
echo.

echo ETAPE 2 - Verifier la version PHP active :
echo   - Aller sur http://localhost/
echo   - Cliquer sur phpinfo()
echo   - Verifier que la version est 8.1.x
echo.

echo ETAPE 3 - Configurer le PATH Windows (optionnel) :
echo   - Ajouter au PATH système : C:\wamp64\bin\php\php8.1.0
echo   - Redémarrer l'invite de commande
echo.

echo 2. Test de la configuration actuelle...
echo.

set PHP81_PATH=C:\wamp64\bin\php\php8.1.0\php.exe

if exist "%PHP81_PATH%" (
    echo PHP 8.1 trouve : %PHP81_PATH%
    echo Version :
    %PHP81_PATH% --version
    echo.
    echo Extensions installees importantes :
    %PHP81_PATH% -m | findstr /i "openssl pdo mysql curl"
    echo.
) else (
    echo ERREUR: PHP 8.1 non trouve
    echo Veuillez verifier l'installation WAMP
)

echo.
echo 3. Test de Composer avec PHP 8.1...
if exist composer.phar (
    echo Composer detecte, test avec PHP 8.1 :
    %PHP81_PATH% composer.phar --version 2>nul
    if %errorlevel% == 0 (
        echo Composer fonctionne avec PHP 8.1 !
    ) else (
        echo Probleme avec Composer
    )
) else (
    echo Composer non installe
)

echo.
echo ================================================
echo Actions recommandees
echo ================================================
echo.

echo Si WAMP utilise encore PHP 5.6 :
echo 1. Clic droit icone WAMP ^> PHP ^> Version ^> 8.1.0
echo 2. Attendre redemarrage WAMP
echo 3. Relancer ce script
echo.

echo Pour installer Composer :
echo 1. Executez : fix-php-version-composer.bat
echo 2. Ou telechargez manuellement : https://getcomposer.org/Composer-Setup.exe
echo    ^> Lors de l'installation, specifiez : %PHP81_PATH%
echo.

echo Pour tester l'application immediatement :
echo Version demo : http://localhost/b2bn/public/simple-demo.php
echo.

echo Voulez-vous :
echo [1] Configurer WAMP maintenant
echo [2] Tester la demo
echo [3] Ouvrir phpMyAdmin
echo [4] Quitter
echo.

set /p choice=Votre choix (1-4) :

if "%choice%"=="1" (
    echo.
    echo Instructions pour configurer WAMP :
    echo 1. Clic droit sur l'icone WAMP dans la barre systeme
    echo 2. PHP ^> Version ^> 8.1.0
    echo 3. Attendre que l'icone redevienne verte
    echo 4. Relancer ce script pour verifier
    pause
) else if "%choice%"=="2" (
    start http://localhost/b2bn/public/simple-demo.php
) else if "%choice%"=="3" (
    start http://localhost/phpmyadmin
) else (
    echo Au revoir !
)

echo.
pause