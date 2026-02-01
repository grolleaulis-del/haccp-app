#!/usr/bin/env pwsh
# =====================================================
# Script de Push vers GitHub
# À exécuter après chaque modification
# =====================================================

Write-Host ""
Write-Host "=====================================================" -ForegroundColor Cyan
Write-Host "  Push du code vers GitHub" -ForegroundColor Cyan
Write-Host "=====================================================" -ForegroundColor Cyan
Write-Host ""

$appPath = "C:\laragon\www\haccp.grolleau\haccp-app"
cd $appPath

# 1. Vérifier le statut
Write-Host "[1/3] Vérification du statut..." -ForegroundColor Yellow
git status

Write-Host ""

# 2. Demander un message
$message = Read-Host "Entrez le message de commit"

if ([string]::IsNullOrEmpty($message)) {
    $message = "Mise à jour - $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
}

# 3. Commit et push
Write-Host ""
Write-Host "[2/3] Création du commit..." -ForegroundColor Yellow
git add .
git commit -m "$message"

Write-Host ""
Write-Host "[3/3] Envoi du code..." -ForegroundColor Yellow
git push origin main

Write-Host ""
Write-Host "✓ Code poussé avec succès !" -ForegroundColor Green
Write-Host ""

pause
