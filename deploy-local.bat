@echo off
REM =====================================================
REM Script de préparation pour déploiement
REM À exécuter AVANT de pousser sur Git
REM =====================================================

echo.
echo ========================================
echo   PREPARATION POUR DEPLOIEMENT
echo ========================================
echo.

REM 1. Vérifier l'état Git
echo [1/6] Verification Git...
git status

echo.
echo Voulez-vous continuer ? (O/N)
set /p confirm=
if /i not "%confirm%"=="O" goto :end

REM 2. Tests (optionnel)
echo.
echo [2/6] Execution des tests...
php artisan test
if errorlevel 1 (
    echo ERREUR: Les tests ont echoue!
    pause
    goto :end
)

REM 3. Optimiser pour la production
echo.
echo [3/6] Optimisation...
composer install --optimize-autoloader --no-dev

REM 4. Vérifier le .env.example
echo.
echo [4/6] Verification .env.example...
if not exist .env.example (
    echo ATTENTION: .env.example n'existe pas!
    copy .env .env.example
    echo .env.example cree depuis .env
)

REM 5. Ajouter tous les fichiers
echo.
echo [5/6] Ajout des fichiers au commit...
git add .

REM 6. Commit
echo.
echo [6/6] Message du commit:
set /p commit_msg=
git commit -m "%commit_msg%"

REM Push
echo.
echo Pousser sur Git maintenant ? (O/N)
set /p push_confirm=
if /i "%push_confirm%"=="O" (
    git push origin main
    echo.
    echo ========================================
    echo   SUCCES! Code pousse sur Git
    echo ========================================
    echo.
    echo Maintenant sur le serveur cPanel:
    echo   1. Connectez-vous en SSH
    echo   2. cd ~/public_html
    echo   3. ./deploy.sh
    echo.
) else (
    echo.
    echo Commit prepare. Utilisez "git push origin main" quand pret.
)

:end
echo.
pause
