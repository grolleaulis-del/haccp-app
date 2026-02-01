#!/bin/bash
#########################################
# Script de Déploiement sur cPanel
# À placer dans le dossier de votre application sur le serveur
#########################################

echo "🚀 Démarrage du déploiement..."

# 1. Activer le mode maintenance
php artisan down --message="Mise à jour en cours..." --retry=60

# 2. Récupérer les dernières modifications depuis Git
echo "📥 Récupération du code depuis Git..."
git pull origin main

# 3. Installer/Mettre à jour les dépendances Composer (sans les dépendances de dev)
echo "📦 Installation des dépendances..."
composer install --no-dev --optimize-autoloader --no-interaction

# 4. Exécuter les migrations de base de données
echo "🗄️ Migration de la base de données..."
php artisan migrate --force

# 5. Nettoyer et reconstruire les caches
echo "🧹 Nettoyage des caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "🔧 Optimisation des caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Optimiser l'autoloader
composer dump-autoload --optimize

# 7. Créer le lien symbolique pour le stockage (si nécessaire)
php artisan storage:link 2>/dev/null

# 8. Désactiver le mode maintenance
php artisan up

echo "✅ Déploiement terminé avec succès !"
echo "🌐 Votre application est à jour et en ligne."
