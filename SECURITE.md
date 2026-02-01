# 🔐 Guide de Sécurité - Application HACCP

## ✅ Fonctionnalités Implémentées

### 1. Système de Rôles et Permissions

**3 rôles disponibles :**
- **Admin** : Accès complet au système + panneau d'administration
- **Manager** : Accès à toutes les fonctionnalités + visualisation des logs
- **Employé** : Accès aux fonctionnalités quotidiennes uniquement

**Attribution des rôles :**
```php
// Dans le panneau admin
/admin/users/{id}/edit

// Par code
$user->role = 'admin'; // ou 'manager', 'employe'
$user->save();
```

**Vérification des rôles :**
```php
// Dans les contrôleurs
if (auth()->user()->isAdmin()) { }
if (auth()->user()->isManager()) { }
if (auth()->user()->hasRole(['admin', 'manager'])) { }

// Dans les vues Blade
@if(auth()->user()->isAdmin())
    <!-- Contenu admin -->
@endif

// Dans les routes
Route::middleware(['role:admin'])->group(function () {
    // Routes admin uniquement
});
```

### 2. Logs d'Activité Détaillés

**Enregistrement automatique :**
- ✅ Connexions/Déconnexions (IP, User-Agent, horodatage)
- ✅ Modifications utilisateurs
- ✅ Toutes les actions importantes

**Consultation des logs :**
- URL: `/admin/activity-logs`
- Filtres disponibles : module, action, utilisateur, dates
- Données stockées : user_id, action, module, description, IP, user-agent

**Utilisation dans le code :**
```php
use App\Models\ActivityLog;

ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'create',
    'module' => 'produits',
    'description' => 'Création du produit XYZ',
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

### 3. Limitation des Tentatives de Connexion (Throttling)

**Protection contre les attaques par force brute :**
- ✅ Maximum 5 tentatives par email/IP
- ✅ Blocage pendant 15 minutes après dépassement
- ✅ Message d'erreur indiquant le temps restant
- ✅ Nettoyage automatique des anciennes tentatives (>30 jours)

**Suivi des tentatives :**
- URL: `/admin/login-attempts`
- Affichage : email, IP, succès/échec, date, user-agent

### 4. Sauvegardes Automatiques

**Configuration :**
```php
// config/backup.php
'backup' => [
    'name' => 'haccp',
    'databases' => ['mysql'],
    'compression' => 'gzip',
]
```

**Planification automatique :**
- ✅ **Sauvegarde quotidienne** : 2h00 (base de données uniquement)
- ✅ **Nettoyage hebdomadaire** : Dimanche 3h00 (suppression anciennes sauvegardes)
- ✅ **Vérification** : Lundi 9h00 (état des sauvegardes)

**Rétention des sauvegardes :**
- Toutes les sauvegardes : 7 derniers jours
- 1 par jour : 16 jours
- 1 par semaine : 8 semaines
- 1 par mois : 4 mois
- 1 par an : 2 ans

**Commandes manuelles :**
```bash
# Créer une sauvegarde immédiate
php artisan backup:run --only-db

# Nettoyer les anciennes sauvegardes
php artisan backup:clean

# Vérifier l'état des sauvegardes
php artisan backup:monitor

# Lister toutes les sauvegardes
php artisan backup:list
```

**Interface web :**
- URL: `/admin/backups`
- Bouton "Créer une sauvegarde maintenant"
- Liste des sauvegardes existantes

### 5. Protection des Comptes Utilisateurs

**Désactivation de compte :**
- Les admins peuvent désactiver un compte utilisateur
- Un utilisateur désactivé est automatiquement déconnecté
- Impossible de se reconnecter tant que le compte est désactivé

**Protection supplémentaire :**
- ✅ Impossible de supprimer son propre compte
- ✅ Impossible de désactiver son propre compte
- ✅ CSRF tokens sur tous les formulaires
- ✅ Validation stricte des entrées
- ✅ Échappement automatique des sorties (Blade)

## 🚀 Activation du Scheduler Laravel

Pour que les sauvegardes automatiques fonctionnent, activez le scheduler Laravel :

### Sur Serveur Linux/Production :
```bash
crontab -e
# Ajouter cette ligne :
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Sur Windows/Laragon (Développement) :
Créez un fichier `scheduler.bat` :
```batch
@echo off
cd C:\laragon\www\haccp.grolleau\haccp-app
php artisan schedule:run
```

Puis utilisez le Planificateur de tâches Windows :
1. Rechercher "Planificateur de tâches"
2. Créer une tâche de base
3. Déclencheur : Répéter toutes les 1 minute
4. Action : Démarrer le script `scheduler.bat`

## 📊 Panneau d'Administration

**URL:** `/admin`

**Accès restreint:** Admin uniquement

**Fonctionnalités :**
- 👥 Gestion des utilisateurs (rôles, activation/désactivation)
- 📋 Logs d'activité (audit complet)
- 💾 Sauvegardes (création, téléchargement, monitoring)
- 🔒 Tentatives de connexion (détection intrusions)
- ⚙️ Paramètres système
- 📊 Statistiques

## 🔒 Recommandations de Sécurité

### En Production :

1. **Variables d'environnement (.env) :**
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:VOTRE_CLE_UNIQUE_GENEREE

# Mot de passe fort pour les sauvegardes
BACKUP_ARCHIVE_PASSWORD=UnMotDePasseTresComplexe123!

# Email pour notifications backup
BACKUP_MAIL_TO=admin@votredomaine.com
```

2. **HTTPS obligatoire :**
```php
// Dans app/Providers/AppServiceProvider.php
if ($this->app->environment('production')) {
    \URL::forceScheme('https');
}
```

3. **Permissions fichiers :**
```bash
chmod -R 755 storage bootstrap/cache
chmod 644 .env
```

4. **Configuration serveur web :**
- Racine web doit pointer vers `/public`
- Bloquer l'accès direct à `/storage`, `/vendor`, `.env`

5. **Sauvegardes hors site :**
Configurez un stockage externe (S3, FTP, etc.) dans `config/backup.php`

## 👤 Compte Admin par Défaut

**Email:** admin@haccp.local  
**Mot de passe:** (défini lors de la création)

⚠️ **Important:** Changez le mot de passe immédiatement après la première connexion !

## 📞 Support

En cas de problème de sécurité, contactez immédiatement l'administrateur système.
