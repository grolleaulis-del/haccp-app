# 📚 GUIDE PAS À PAS - Configuration Déploiement

## ✅ Prérequis

- ✅ Compte GitHub (gratuit) : https://github.com
- ✅ Accès SSH à cPanel (ou Terminal dans File Manager)
- ✅ Laragon installé localement

---

## 🔧 ÉTAPE 1 : Créer le Repository GitHub (5 minutes)

### 1.1 Créer un compte GitHub

1. Aller sur https://github.com/signup
2. Créer un compte (utiliser votre email)
3. Valider l'email

### 1.2 Créer un repository

1. Aller sur https://github.com/new
2. **Repository name** : `haccp-app`
3. **Description** : "Application HACCP Grolleau"
4. **Public ou Private** : Private (plus sûr)
5. Cliquer "Create repository"
6. **COPIER l'URL** (vous la aurez besoin)
   - Exemple : `https://github.com/VOTRE-COMPTE/haccp-app.git`

---

## 💻 ÉTAPE 2 : Initialiser Git Localement (10 minutes)

### 2.1 Installer Git sur Windows

Si pas encore installé :
1. Aller sur https://git-scm.com/download/win
2. Télécharger et installer (garder les paramètres par défaut)
3. Redémarrer Windows

### 2.2 Configurer Git

**Ouvrir PowerShell** et exécuter :

```powershell
# Configuration globale (1 seule fois)
git config --global user.name "Votre Nom"
git config --global user.email "votre.email@example.com"
git config --global --list  # Vérifier
```

### 2.3 Initialiser le Repository Local

```powershell
# Aller dans le dossier de l'app
cd C:\laragon\www\haccp.grolleau\haccp-app

# Vérifier si Git est déjà initialisé
git log  # Si erreur = pas encore initialisé

# SI PAS INITIALISÉ :
git init

# Ajouter tous les fichiers
git add .

# Premier commit
git commit -m "Version initiale HACCP"

# Ajouter le repository distant GitHub
git remote add origin https://github.com/VOTRE-COMPTE/haccp-app.git

# Renommer la branche en "main" si nécessaire
git branch -M main

# Pousser sur GitHub
git push -u origin main
```

### 2.4 Vérifier sur GitHub

- Aller sur https://github.com/VOTRE-COMPTE/haccp-app
- Vérifier que le code est là ✅

---

## 🖥️ ÉTAPE 3 : Configurer cPanel (15 minutes)

### 3.1 Accéder à cPanel

1. Aller sur https://votredomaine.com:2083
2. Login : votre identifiant cPanel
3. Chercher "Terminal" ou "Advanced → Terminal"
4. Cliquer

### 3.2 Cloner le Repository

**Dans le Terminal cPanel, exécuter :**

```bash
# Aller dans le dossier public_html
cd ~/public_html

# IMPORTANT : Vérifier qu'on est au bon endroit
pwd  # Devrait afficher /home/votrecompte/public_html

# Vérifier que le dossier est vide ou vérifier l'existant
ls -la

# Cloner le repository (remplacer URL et COMPTE)
git clone https://github.com/VOTRE-COMPTE/haccp-app.git .

# Vérifier que le code est là
ls -la  # Devrait voir app/, routes/, artisan, etc.
```

### 3.3 Installer Composer et les Dépendances

```bash
# Aller dans le dossier
cd ~/public_html

# Vérifier Composer
composer --version  # Si version ok, continuer

# Installer les dépendances (SANS dev)
composer install --no-dev --optimize-autoloader --no-interaction

# Si erreur de permission, essayer :
composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
```

### 3.4 Configurer .env Production

```bash
# Copier le fichier exemple
cp .env.example .env

# Éditer le fichier
nano .env

# Modifier ces lignes :
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votredomaine.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=votrebase_cpanel      # À demander à votre hébergeur
DB_USERNAME=votreuser_cpanel       # À demander à votre hébergeur
DB_PASSWORD=votrepass_cpanel       # À demander à votre hébergeur

# Sauvegarder : CTRL+O, Entrée, CTRL+X
```

**Comment trouver les données DB dans cPanel :**
1. Dans cPanel, chercher "MySQL Databases"
2. Voir les bases de données créées
3. Les identifiants sont prépendus du compte

### 3.5 Générer la Clé d'Application

```bash
# Générer APP_KEY
php artisan key:generate

# Vérifier que .env a été modifié
grep APP_KEY .env
```

### 3.6 Exécuter les Migrations

```bash
# Créer les tables dans la BDD
php artisan migrate --force

# Résultat : "Migration table created successfully" + listing migrations
```

### 3.7 Créer le Lien Symbolique pour le Stockage

```bash
# Créer le lien pour les uploads
php artisan storage:link

# Devrait afficher : Storage link created successfully
```

### 3.8 Définir les Permissions

```bash
# Permissions pour les dossiers storage et cache
chmod -R 755 storage bootstrap/cache

# Pour les fichiers (si besoin)
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
```

### 3.9 Optimiser pour la Production

```bash
# Reconstruire les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimiser l'autoloader
composer dump-autoload --optimize
```

### 3.10 Rendre le Script Exécutable

```bash
# Rendre deploy.sh exécutable
chmod +x deploy.sh

# Vérifier
ls -la deploy.sh  # Devrait voir "x" dans les permissions
```

---

## 🧪 ÉTAPE 4 : Tester le Premier Déploiement (5 minutes)

### 4.1 Test Complet

```bash
# Mettre en maintenance
php artisan down

# Récupérer le code (devrait dire "Already up to date")
git pull origin main

# Revenir en ligne
php artisan up

# Vérifier que tout marche
curl https://votredomaine.com
```

### 4.2 Vérifier dans le Navigateur

1. Aller sur https://votredomaine.com
2. Vérifier que le site s'affiche ✅
3. Vérifier que vous pouvez vous connecter ✅

---

## 🔄 ÉTAPE 5 : Test du Cycle Complet (10 minutes)

### 5.1 Modifier quelque chose localement

**Sur votre PC (Laragon) :**

```powershell
cd C:\laragon\www\haccp.grolleau\haccp-app

# Faire une petite modification (ex: changer un titre)
# Puis :

git add .
git commit -m "Test modification"
git push origin main
```

### 5.2 Déployer sur cPanel

**Dans le Terminal cPanel :**

```bash
cd ~/public_html
./deploy.sh

# Attendre que ça se termine
# Devrait afficher : "✅ Déploiement terminé avec succès !"
```

### 5.3 Vérifier le Changement

- Aller sur https://votredomaine.com
- Vérifier que votre modification est là ✅

---

## ✅ Checklist Configuration Finale

- [ ] Repository GitHub créé
- [ ] Git initialisé localement
- [ ] Code pushé sur GitHub
- [ ] Code cloné sur cPanel
- [ ] Composer installé
- [ ] .env configuré
- [ ] Migrations exécutées
- [ ] Permissions définies
- [ ] Script deploy.sh exécutable
- [ ] Premier test réussi

---

## 🎉 C'est Terminé !

Maintenant, à chaque modification :

**Sur votre PC :**
```powershell
# Double-cliquer sur deploy-local.bat
# OU manuellement :
git add .
git commit -m "Mes modifications"
git push origin main
```

**Sur cPanel :**
```bash
./deploy.sh
```

**Done ! ✅**

---

## 🆘 Aide en Cas de Problème

### Erreur lors de `git clone`

**Problème :** "Permission denied"
```bash
# Solution :
git config --global url.https://.insteadOf git://
git clone https://github.com/VOTRE-COMPTE/haccp-app.git .
```

### Erreur Composer

**Problème :** "No such file or directory"
```bash
# Solution : Installer Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer
```

### Erreur Base de Données

**Problème :** "SQLSTATE[HY000] [2002]"
```bash
# Vérifier les credentials dans .env
cat .env | grep DB_

# Contacter le support cPanel pour les identifiants
```

### Erreur Permissions

**Problème :** "Permission denied" sur les fichiers
```bash
# Solution :
chmod -R 755 storage bootstrap/cache
chmod -R 644 storage/*
```

---

## 📞 Besoin d'Aide ?

Gardez ce guide à portée de main et n'hésitez pas à relire les sections au besoin !

**Prochaines étapes :**
1. Configurer les sauvegardes automatiques
2. Configurer les emails de notification
3. Mettre en place monitoring
