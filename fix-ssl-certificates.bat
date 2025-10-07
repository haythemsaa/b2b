@echo off
echo ================================================
echo Correction des certificats SSL pour Composer
echo ================================================
echo.

set PHP_INI=C:\xampp2025\php\php.ini
set CERT_FILE=C:\xampp2025\apache\bin\curl-ca-bundle.crt

echo 1. Verification des fichiers...
if not exist "%PHP_INI%" (
    echo ERREUR: php.ini non trouve : %PHP_INI%
    pause
    exit /b 1
)

echo PHP.ini trouve : %PHP_INI%
echo.

echo 2. Telechargement des certificats CA mis a jour...
echo Telechargement depuis curl.se...

:: Créer le dossier si nécessaire
if not exist "C:\xampp2025\apache\bin\" mkdir "C:\xampp2025\apache\bin\"

:: Télécharger avec PowerShell (contourne les problèmes SSL)
powershell -Command "[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; try { Invoke-WebRequest -Uri 'https://curl.se/ca/cacert.pem' -OutFile 'C:\xampp2025\apache\bin\curl-ca-bundle.crt' -UseBasicParsing; Write-Host 'Certificats telecharges avec succes' } catch { Write-Host 'Echec du telechargement' }"

if exist "%CERT_FILE%" (
    echo Certificats installes : %CERT_FILE%
) else (
    echo Echec du telechargement, creation d'un fichier temporaire...
    echo # Certificat temporaire > "%CERT_FILE%"
)

echo.
echo 3. Configuration de php.ini...

:: Sauvegarder php.ini
copy "%PHP_INI%" "%PHP_INI%.backup"

:: Configurer openssl.cafile
powershell -Command "(Get-Content '%PHP_INI%') -replace ';openssl.cafile=.*', 'openssl.cafile=\"C:\xampp2025\apache\bin\curl-ca-bundle.crt\"' | Set-Content '%PHP_INI%'"

:: Configurer curl.cainfo si nécessaire
powershell -Command "$content = Get-Content '%PHP_INI%'; if ($content -notmatch 'curl.cainfo') { $content += 'curl.cainfo=\"C:\xampp2025\apache\bin\curl-ca-bundle.crt\"' }; $content | Set-Content '%PHP_INI%'"

echo Configuration SSL mise a jour dans php.ini
echo.

echo 4. Test de la configuration SSL...
C:\wamp64\bin\php\php8.1.0\php.exe -r "echo 'Test SSL: '; var_dump(openssl_get_cert_locations());"

echo.
echo 5. Installation de Composer avec SSL corrige...
C:\wamp64\bin\php\php8.1.0\php.exe -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" 2>nul
if exist composer-setup.php (
    echo Installateur Composer telecharge avec succes
    C:\wamp64\bin\php\php8.1.0\php.exe composer-setup.php
    del composer-setup.php
) else (
    echo Echec du telechargement, utilisation de la methode alternative...
    goto :alternative_install
)

if exist composer.phar (
    echo.
    echo 6. Installation des dependances Laravel...
    C:\wamp64\bin\php\php8.1.0\php.exe composer.phar install --no-dev --optimize-autoloader
    goto :success
)

:alternative_install
echo.
echo Installation alternative de Composer...
echo Telechargement manuel requis :
echo 1. Allez sur https://getcomposer.org/download/
echo 2. Telechargez Composer-Setup.exe
echo 3. Installez-le
echo 4. Puis executez dans ce dossier : composer install
echo.

:success
echo.
echo ================================================
echo Configuration SSL terminee !
echo ================================================
echo.
echo Prochaines etapes :
echo 1. Redemarrer WAMP/XAMPP
echo 2. Creer la base de donnees 'b2bn_platform'
echo 3. Importer database_schema.sql puis database_data.sql
echo 4. Tester : http://localhost/b2bn/public/simple-demo.php
echo.
echo Si Composer fonctionne maintenant :
echo composer install
echo.
pause