# 🚀 GUIDE GITHUB - Configuration Pas à Pas

## 📋 Objectif

Créer un compte GitHub, configurer Git localement, et pousser le code HACCP pour ensuite le déployer facilement sur cPanel.

---

## ✅ ÉTAPE 1 : Créer un Compte GitHub (5 minutes)

### 1.1 Accéder au site

1. Ouvrir https://github.com/signup
2. Remplir le formulaire :
   - **Username** : (créer un identifiant)
   - **Email** : Votre email professionnel
   - **Password** : Mot de passe fort
3. Cliquer "Create account"
4. Vérifier votre email
5. Accepter les conditions

### 1.2 Exemple de données

```
Username:  grolleau-haccp (ou similar)
Email:     contact@grolleau-lis.fr
Password:  UnMotDePasseFort123!@
```

---

## 🔧 ÉTAPE 2 : Configurer Git Localement (15 minutes)

### 2.1 Installer Git

**Si Git n'est pas déjà installé :**

1. Télécharger : https://git-scm.com/download/win
2. Exécuter l'installateur
3. Garder les paramètres par défaut
4. Redémarrer PowerShell après installation

### 2.2 Vérifier l'Installation

```powershell
# Dans PowerShell
git --version
```

**Résultat attendu :**
```
git version 2.43.0.windows.1
```

### 2.3 Configurer votre Identité Git

```powershell
# Configurer votre nom
git config --global user.name "Votre Nom"

# Configurer votre email (DOIT être le même que GitHub)
git config --global user.email "contact@grolleau-lis.fr"

# Vérifier la configuration
git config --global --list
```

---

## 🔐 ÉTAPE 3 : Générer une Clé SSH (Optionnel mais Recommandé)

### 3.1 Générer la Clé

```powershell
# Créer une clé SSH
ssh-keygen -t ed25519 -C "contact@grolleau-lis.fr"

# Ou si ed25519 ne marche pas :
ssh-keygen -t rsa -b 4096 -C "contact@grolleau-lis.fr"
```

**Quand demandé :**
- File location : Appuyer sur Entrée (prendre la valeur par défaut)
- Passphrase : Appuyer sur Entrée (laisser vide)

### 3.2 Copier la Clé Publique

```powershell
# Afficher et copier la clé publique
type $HOME\.ssh\id_ed25519.pub

# OU pour RSA :
type $HOME\.ssh\id_rsa.pub
```

**Copier tout le contenu (commence par `ssh-ed25519` ou `ssh-rsa`)**

### 3.3 Ajouter la Clé à GitHub

1. Aller sur https://github.com/settings/keys
2. Cliquer "New SSH key"
3. Coller la clé dans le champ
4. Donner un titre : "Mon PC Windows"
5. Cliquer "Add SSH key"

---

## 📦 ÉTAPE 4 : Créer un Repository GitHub (5 minutes)

### 4.1 Créer le Repository

1. Aller sur https://github.com/new
2. Remplir :
   - **Repository name** : `haccp-app`
   - **Description** : "Application HACCP Grolleau"
   - **Visibility** : Private (sécurisé)
   - **Initialize with README** : Non (on va pousser notre code)
3. Cliquer "Create repository"

### 4.2 Noter l'URL

Vous verrez 2 options, **copier l'URL HTTPS** :

```
https://github.com/grolleau-haccp/haccp-app.git
```

(Remplacer `grolleau-haccp` par votre username)

---

## 🔄 ÉTAPE 5 : Initialiser Git Localement (10 minutes)

### 5.1 Naviguer au Dossier de l'Application

```powershell
cd C:\laragon\www\haccp.grolleau\haccp-app
```

### 5.2 Vérifier si Git est Déjà Initialisé

```powershell
# Vérifier s'il y a un .git
ls -Force | grep -i ".git"

# OU regarder si le dossier .git existe
Test-Path .\.git
```

**Si résultat = True** : Git est déjà initialisé, passer à l'étape 5.4

**Si résultat = False** : Initialiser comme suit

### 5.3 Initialiser Git (SI NÉCESSAIRE)

```powershell
# Initialiser Git
git init

# Ajouter tous les fichiers
git add .

# Créer le premier commit
git commit -m "Version initiale HACCP - Toutes les fonctionnalités et sécurité"

# Afficher le statut
git status
```

**Résultat attendu :**
```
On branch master
nothing to commit, working tree clean
```

### 5.4 Connecter au Repository GitHub

```powershell
# Ajouter le repository distant
git remote add origin https://github.com/VOTRE-USERNAME/haccp-app.git

# Vérifier la connexion
git remote -v
```

**Résultat attendu :**
```
origin  https://github.com/grolleau-haccp/haccp-app.git (fetch)
origin  https://github.com/grolleau-haccp/haccp-app.git (push)
```

---

## 🚀 ÉTAPE 6 : Pousser le Code sur GitHub (2 minutes)

### 6.1 Pousser le Code

```powershell
# Pousser sur la branche main (ou master selon votre config)
git push -u origin main

# Si ça demande un mot de passe, entrer votre mot de passe GitHub
```

**Résultat attendu :**
```
Enumerating objects: ...
Counting objects: ...
Compressing objects: ...
Writing objects: ...
Receiving objects: ...
Unpacking objects: ...
 * [new branch]      main -> origin/main
Branch 'main' set up to track remote branch 'main' from 'origin'.
```

### 6.2 Si Erreur "Permission denied"

```powershell
# Vérifier si SSH marche
ssh -T git@github.com

# Si oui, utiliser SSH au lieu d'HTTPS
git remote remove origin
git remote add origin git@github.com:VOTRE-USERNAME/haccp-app.git
git push -u origin main
```

---

## ✅ ÉTAPE 7 : Vérifier sur GitHub (2 minutes)

### 7.1 Vérifier que le Code est Là

1. Aller sur https://github.com/VOTRE-USERNAME/haccp-app
2. Vérifier que le code est présent ✅

### 7.2 Vérifier la Branche

Vous devriez voir :
- Dossiers : `app/`, `routes/`, `database/`, `resources/`, etc.
- Fichiers : `artisan`, `composer.json`, `package.json`, etc.
- Fichiers de déploiement : `deploy.sh`, `DEPLOIEMENT.md`, etc.

---

## 🔄 ÉTAPE 8 : Synchronisation Régulière (Quotidienne)

### 8.1 Après Chaque Modification Locale

```powershell
cd C:\laragon\www\haccp.grolleau\haccp-app

# Voir les fichiers modifiés
git status

# Ajouter tous les changements
git add .

# Créer un commit avec une description
git commit -m "Description de vos modifications"

# Pousser sur GitHub
git push origin main
```

### 8.2 Récupérer les Modifications du Serveur (Si travail d'équipe)

```powershell
# Récupérer les dernières modifications
git pull origin main
```

---

## 🧪 TEST : Vérifier que Tout Fonctionne

### 9.1 Tester la Connexion

```powershell
# Depuis le dossier haccp-app
cd C:\laragon\www\haccp.grolleau\haccp-app

# Vérifier que vous êtes connecté
git remote -v

# Résultat attendu :
# origin  https://github.com/VOTRE-USERNAME/haccp-app.git (fetch)
# origin  https://github.com/VOTRE-USERNAME/haccp-app.git (push)
```

### 9.2 Tester un Push

```powershell
# Modifier un petit fichier (par exemple README.md ou ajouter un commentaire)
# Puis :

git add .
git commit -m "Test de synchronisation"
git push origin main

# Vérifier sur GitHub - le timestamp devrait être à jour
```

---

## 📝 Fichiers à Utiliser pour le Déploiement

Après avoir poussé sur GitHub, vous pouvez utiliser :

1. **sur cPanel :**
   ```bash
   cd ~/public_html
   git clone https://github.com/VOTRE-USERNAME/haccp-app.git .
   ./deploy.sh
   ```

2. **Pour les mises à jour :**
   ```bash
   cd ~/public_html
   git pull origin main
   ./deploy.sh
   ```

---

## ✅ Checklist Finale

- [ ] Compte GitHub créé
- [ ] Git installé sur Windows
- [ ] Identité Git configurée
- [ ] Clé SSH générée et ajoutée
- [ ] Repository créé sur GitHub
- [ ] Code local pushé sur GitHub
- [ ] Synchronisation testée
- [ ] Prêt pour déploiement cPanel !

---

## 🎉 Vous Avez Terminé !

Votre code est maintenant sécurisé sur GitHub et prêt pour être déployé sur cPanel en une commande !

**Prochaine étape :** 
1. Obtenir les identifiants cPanel
2. Se connecter en SSH
3. Cloner le repository
4. Exécuter `./deploy.sh`
