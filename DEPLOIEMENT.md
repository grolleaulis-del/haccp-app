# 🚀 Guide de Déploiement sur cPanel

## Méthode Recommandée : Git + Script de Déploiement

### 📋 Prérequis

1. **Repository Git configuré** (GitHub, GitLab, Bitbucket)
2. **Accès SSH à cPanel** (ou Terminal dans cPanel)
3. **Git installé sur le serveur**

---

## 🔧 Configuration Initiale (À faire UNE SEULE FOIS)

### Étape 1 : Créer un Repository Git

```bash
# Sur votre machine locale (dans haccp-app/)
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/VOTRE-COMPTE/haccp-app.git
git push -u origin main
```

### Étape 2 : Cloner sur cPanel

**Via Terminal SSH cPanel :**

```bash
# Se connecter en SSH
ssh votrecompte@votredomaine.com

# Aller dans le dossier de votre site
cd ~/public_html

# Cloner le repository
git clone https://github.com/VOTRE-COMPTE/haccp-app.git .

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Copier et configurer .env
cp .env.example .env
nano .env  # Éditer avec les credentials de production

# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations
php artisan migrate --force

# Créer le lien symbolique
php artisan storage:link

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permissions
chmod -R 755 storage bootstrap/cache
```

### Étape 3 : Rendre le script de déploiement exécutable

```bash
chmod +x deploy.sh
```

---

## 🔄 Mise à Jour de l'Application (À CHAQUE MODIFICATION)

### Sur votre machine locale :

```bash
# 1. Faire vos modifications dans le code
# 2. Commiter et pousser

git add .
git commit -m "Description de vos modifications"
git push origin main
```

### Sur le serveur cPanel :

**Méthode 1 - Script automatique (RECOMMANDÉ) :**

```bash
# Via SSH ou Terminal cPanel
cd ~/public_html
./deploy.sh
```

**Méthode 2 - Commandes manuelles :**

```bash
cd ~/public_html

# Mode maintenance
php artisan down

# Récupérer les modifications
git pull origin main

# Mettre à jour les dépendances si besoin
composer install --no-dev --optimize-autoloader

# Migrations
php artisan migrate --force

# Nettoyer les caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Reconstruire les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Désactiver le mode maintenance
php artisan up
```

---

## 📦 Que Mettre dans Git ?

### ✅ À INCLURE :
- Code source (app/, routes/, resources/, etc.)
- Migrations (database/migrations/)
- Configuration (config/)
- Composer.json et package.json
- .gitignore
- Scripts de déploiement (deploy.sh)

### ❌ À EXCLURE (.gitignore) :
- `/vendor` (dépendances Composer)
- `/node_modules` (dépendances NPM)
- `.env` (credentials)
- `/storage` (fichiers uploadés)
- `/public/storage` (lien symbolique)
- Caches et logs

---

## 🎯 Flux de Travail Simplifié

```
┌─────────────────────────────────────────────────┐
│ DÉVELOPPEMENT LOCAL (Windows/Laragon)          │
│                                                 │
│ 1. Modifier le code                            │
│ 2. Tester localement (http://localhost:8000)  │
│ 3. git add . && git commit -m "message"        │
│ 4. git push origin main                         │
└─────────────────────────────────────────────────┘
                      ↓
┌─────────────────────────────────────────────────┐
│ SERVEUR PRODUCTION (cPanel)                     │
│                                                 │
│ 1. Se connecter en SSH/Terminal                │
│ 2. cd ~/public_html                            │
│ 3. ./deploy.sh                                  │
│ 4. ✅ Application mise à jour !                │
└─────────────────────────────────────────────────┘
```

---

## 🛠️ Alternative : Déploiement via FTP (Non Recommandé)

Si vous n'avez pas accès SSH :

1. **Zipper le code localement** (sans vendor/, node_modules/, storage/)
2. **Uploader par FTP** vers cPanel
3. **Dézipper sur le serveur**
4. **Via File Manager cPanel → Terminal :**
   ```bash
   cd ~/public_html
   composer install --no-dev
   php artisan migrate --force
   php artisan config:cache
   ```

⚠️ **Inconvénient :** Très lent, risque d'erreur, pas de versioning

---

## 🔐 Fichier .env en Production

**Différences importantes avec local :**

```env
APP_NAME="HACCP Grolleau"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votredomaine.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=votre_base_cpanel
DB_USERNAME=votre_user_cpanel
DB_PASSWORD=votre_password_cpanel

# Sauvegardes par email
BACKUP_MAIL_TO=votre@email.com
```

---

## 🚨 Résolution de Problèmes

### Erreur 500 après déploiement

```bash
# Vérifier les permissions
chmod -R 755 storage bootstrap/cache

# Regénérer la clé si besoin
php artisan key:generate

# Nettoyer tous les caches
php artisan optimize:clear
```

### "Class not found"

```bash
# Recompiler l'autoloader
composer dump-autoload --optimize
```

### Base de données non à jour

```bash
# Forcer les migrations
php artisan migrate --force
```

### Assets (CSS/JS) non chargés

```bash
# Vérifier le lien symbolique
php artisan storage:link

# Régénérer les assets si nécessaire
npm run build
```

---

## 📊 Automatisation Avancée (Optionnel)

### Avec GitHub Actions (CI/CD)

Créer `.github/workflows/deploy.yml` :

```yaml
name: Deploy to cPanel

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - name: Deploy via SSH
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd ~/public_html
            ./deploy.sh
```

---

## ✅ Checklist de Déploiement

Avant chaque mise en production :

- [ ] Code testé localement
- [ ] Migrations testées
- [ ] .env de production configuré
- [ ] Sauvegardes de la BDD effectuées
- [ ] `git push` effectué
- [ ] Script `deploy.sh` exécuté sur le serveur
- [ ] Site testé après déploiement
- [ ] Logs vérifiés (storage/logs/laravel.log)

---

## 📞 En Cas de Problème Critique

**Retour en arrière rapide :**

```bash
# Revenir à la version précédente
git log  # Trouver le hash du commit précédent
git reset --hard HASH_DU_COMMIT
git push --force origin main

# Sur le serveur
cd ~/public_html
git pull --force
./deploy.sh
```

---

**Gain de temps : De 30 minutes à 30 secondes par déploiement ! 🚀**
