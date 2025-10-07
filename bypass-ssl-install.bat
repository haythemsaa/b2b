@echo off
echo ================================================
echo Installation B2B Platform - Contournement SSL
echo ================================================
echo.

set PHP_PATH=C:\wamp64\bin\php\php8.1.0\php.exe

echo 1. Configuration temporaire sans verification SSL...
echo.

:: Créer un script PHP temporaire qui désactive la vérification SSL
echo ^<?php > temp_install.php
echo // Desactiver temporairement la verification SSL >> temp_install.php
echo ini_set('openssl.cafile', ''); >> temp_install.php
echo ini_set('openssl.capath', ''); >> temp_install.php
echo $context = stream_context_create([ >> temp_install.php
echo     'http' =^> [ >> temp_install.php
echo         'method' =^> 'GET', >> temp_install.php
echo         'header' =^> 'User-Agent: Mozilla/5.0' >> temp_install.php
echo     ], >> temp_install.php
echo     'ssl' =^> [ >> temp_install.php
echo         'verify_peer' =^> false, >> temp_install.php
echo         'verify_peer_name' =^> false >> temp_install.php
echo     ] >> temp_install.php
echo ]); >> temp_install.php
echo $installer = file_get_contents('https://getcomposer.org/installer', false, $context); >> temp_install.php
echo if ($installer) { >> temp_install.php
echo     file_put_contents('composer-setup.php', $installer); >> temp_install.php
echo     echo "Installateur telecharge avec succes\n"; >> temp_install.php
echo } else { >> temp_install.php
echo     echo "Echec du telechargement\n"; >> temp_install.php
echo } >> temp_install.php

echo 2. Telechargement de l'installateur Composer...
%PHP_PATH% temp_install.php

if exist composer-setup.php (
    echo 3. Installation de Composer...
    %PHP_PATH% composer-setup.php
    del composer-setup.php
    del temp_install.php

    if exist composer.phar (
        echo 4. Installation des dependances Laravel...
        %PHP_PATH% composer.phar install --no-dev --optimize-autoloader
        echo.
        echo ================================================
        echo Installation terminee avec succes !
        echo ================================================
        goto :end
    )
) else (
    echo Echec du telechargement automatique.
    del temp_install.php
)

echo.
echo ================================================
echo Installation manuelle requise
echo ================================================
echo.
echo Le telechargement automatique a echoue.
echo.
echo Solutions alternatives :
echo.
echo 1. TELECHARGEMENT MANUEL :
echo    - Allez sur https://getcomposer.org/download/
echo    - Telechargez "Composer-Setup.exe"
echo    - Installez-le
echo    - Puis tapez : composer install
echo.
echo 2. UTILISER LA VERSION DEMO :
echo    L'application fonctionne deja sans Composer !
echo    http://localhost/b2bn/public/simple-demo.php
echo.
echo 3. TELECHARGEMENT DIRECT :
echo    - Telechargez https://getcomposer.org/composer.phar
echo    - Placez le fichier dans ce dossier
echo    - Executez : php composer.phar install
echo.

:end
echo ================================================
echo Configuration de la base de donnees
echo ================================================
echo.
echo N'oubliez pas :
echo 1. Demarrer WAMP (icone verte)
echo 2. phpMyAdmin : http://localhost/phpmyadmin
echo 3. Creer base 'b2bn_platform'
echo 4. Importer 'database_schema.sql'
echo 5. Importer 'database_data.sql'
echo.
echo Demo disponible : http://localhost/b2bn/public/simple-demo.php
echo.
pause