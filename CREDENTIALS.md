# 🔐 CREDENTIALS - Application HACCP

## Compte Administrateur

**Email:** admin@haccp.local  
**Rôle:** admin  
**Permissions:** Accès complet au système + panneau d'administration

## Autres Utilisateurs

Tous les autres utilisateurs ont le rôle "employe" :
- test@example.com
- admin@haccp.test
- admin@test.com
- Nadia@haccp.local
- youri@haccp.local
- gina@grolleau-lis.fr

## Accès Administration

**URL Panneau Admin:** http://localhost:8000/admin  
**Accès réservé:** Utilisateurs avec rôle "admin" uniquement

## Changement de Rôle

Pour changer le rôle d'un utilisateur, connectez-vous en tant qu'admin et allez sur :
- `/admin/users` 
- Cliquer sur "Modifier" à côté de l'utilisateur
- Changer le rôle (admin/manager/employe)

Ou via tinker :
```bash
php artisan tinker
>>> $user = User::where('email', 'email@example.com')->first();
>>> $user->role = 'manager';
>>> $user->save();
```

## Réinitialisation du Mot de Passe

Via l'interface web :
- Utiliser "Mot de passe oublié" sur la page de connexion

Via tinker :
```bash
php artisan tinker
>>> $user = User::where('email', 'admin@haccp.local')->first();
>>> $user->password = Hash::make('NouveauMotDePasse123!');
>>> $user->save();
```

## Sécurité Active

✅ Système de rôles (admin/manager/employe)  
✅ Logs d'activité détaillés  
✅ Limitation tentatives de connexion (5 max par 15 min)  
✅ Sauvegardes automatiques programmées (2h du matin)  
✅ Protection CSRF sur tous les formulaires  
✅ Désactivation de comptes utilisateurs  

---
**Date de configuration:** 1er février 2026
