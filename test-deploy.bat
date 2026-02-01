@echo off
REM =========================================================
REM Test de Deploiement Local (Simulation cPanel)
REM Pour tester le cycle de deploiement sans cPanel
REM =========================================================

echo.
echo =========================================================
echo   TEST DE DEPLOIEMENT LOCAL
echo =========================================================
echo.

REM 1. Vérifier qu'on est au bon endroit
echo [1/5] Verification du chemin...
cd /d C:\laragon\www\haccp.grolleau\haccp-app
if errorlevel 1 goto error
echo OK - Chemin: %cd%
echo.

REM 2. Mode maintenance
echo [2/5] Activation du mode maintenance...
php artisan down
echo.

REM 3. Optimisation composer
echo [3/5] Optimisation des dependances...
composer install --optimize-autoloader --no-dev
echo.

REM 4. Migrations (optionnel)
echo [4/5] Verification des migrations...
php artisan migrate:status
echo.

REM 5. Nettoyage et cache
echo [5/5] Nettoyage et reconstruction des caches...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
echo.

php artisan config:cache
php artisan route:cache
php artisan view:cache
echo.

REM 6. Desactiver maintenance
php artisan up
echo.

echo =========================================================
echo   TEST DE DEPLOIEMENT REUSSI !
echo =========================================================
echo.
echo Resutats:
echo   - Application en mode production
echo   - Caches optimises
echo   - Maintenace desactivee
echo.
echo Prochaine etape: Tester sur http://localhost:8000
echo.

pause
exit /b 0

:error
echo ERREUR: Impossible d'acceder au dossier de l'application
pause
exit /b 1
