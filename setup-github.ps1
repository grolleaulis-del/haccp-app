#!/usr/bin/env pwsh
# =====================================================
# Script de Configuration GitHub Automatisé
# À exécuter en PowerShell
# =====================================================

Write-Host ""
Write-Host "=====================================================" -ForegroundColor Cyan
Write-Host "  Configuration GitHub Automatisée" -ForegroundColor Cyan
Write-Host "=====================================================" -ForegroundColor Cyan
Write-Host ""

# 1. Vérifier Git
Write-Host "[1/5] Vérification de Git..." -ForegroundColor Yellow
try {
    $gitVersion = git --version
    Write-Host "✓ Git trouvé: $gitVersion" -ForegroundColor Green
} catch {
    Write-Host "✗ Git n'est pas installé!" -ForegroundColor Red
    Write-Host "  Télécharger depuis: https://git-scm.com/download/win" -ForegroundColor Yellow
    exit 1
}

Write-Host ""

# 2. Configurer Git
Write-Host "[2/5] Configuration de Git..." -ForegroundColor Yellow

$userName = Read-Host "Entrez votre nom complet (ex: Jean Dupont)"
$userEmail = Read-Host "Entrez votre email GitHub (ex: jean.dupont@example.com)"

git config --global user.name "$userName"
git config --global user.email "$userEmail"

Write-Host "✓ Git configuré pour: $userName <$userEmail>" -ForegroundColor Green

Write-Host ""

# 3. Aller au dossier
Write-Host "[3/5] Accès au dossier de l'application..." -ForegroundColor Yellow

$appPath = "C:\laragon\www\haccp.grolleau\haccp-app"

if (Test-Path $appPath) {
    cd $appPath
    Write-Host "✓ Dossier trouvé: $appPath" -ForegroundColor Green
} else {
    Write-Host "✗ Dossier non trouvé: $appPath" -ForegroundColor Red
    exit 1
}

Write-Host ""

# 4. Vérifier si Git est initialisé
Write-Host "[4/5] Vérification du repository Git..." -ForegroundColor Yellow

if (Test-Path .\.git) {
    Write-Host "✓ Repository Git déjà initialisé" -ForegroundColor Green
    $gitInit = $false
} else {
    Write-Host "⚠ Repository Git non trouvé, initialisation..." -ForegroundColor Yellow
    git init
    git add .
    git commit -m "Version initiale HACCP"
    Write-Host "✓ Repository Git initialisé" -ForegroundColor Green
    $gitInit = $true
}

Write-Host ""

# 5. Configurer GitHub
Write-Host "[5/5] Configuration du repository GitHub..." -ForegroundColor Yellow

$repoUrl = Read-Host "Entrez l'URL du repository GitHub (ex: https://github.com/votreusername/haccp-app.git)"

# Vérifier si un remote existe déjà
$existingRemote = git remote -v 2>$null | Select-String "origin"

if ($existingRemote) {
    Write-Host "⚠ Un remote 'origin' existe déjà" -ForegroundColor Yellow
    git remote remove origin
}

git remote add origin "$repoUrl"

Write-Host "✓ Repository configuré: $repoUrl" -ForegroundColor Green

Write-Host ""
Write-Host "=====================================================" -ForegroundColor Cyan
Write-Host "  Prêt pour le premier push !" -ForegroundColor Cyan
Write-Host "=====================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Commande pour pousser le code:" -ForegroundColor Yellow
Write-Host "  git push -u origin main" -ForegroundColor White
Write-Host ""
Write-Host "Ou exécuter le script:" -ForegroundColor Yellow
Write-Host "  .\push-code.ps1" -ForegroundColor White
Write-Host ""

# Proposer de pousser maintenant
$push = Read-Host "Voulez-vous pousser le code maintenant ? (O/N)"

if ($push -eq "O" -or $push -eq "o") {
    Write-Host ""
    Write-Host "Envoi du code vers GitHub..." -ForegroundColor Yellow
    git push -u origin main
    Write-Host "✓ Code poussé avec succès !" -ForegroundColor Green
}

Write-Host ""
Write-Host "Visitez votre repository:" -ForegroundColor Green
Write-Host "  $($repoUrl -replace '\.git$', '')" -ForegroundColor White
Write-Host ""

pause
