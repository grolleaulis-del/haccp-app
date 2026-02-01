# Correction des accents "?" dans la base de données

## Problème
Les accents français apparaissent comme des "?" dans l'application. Cela est dû à un problème d'encodage de la base de données MySQL.

## Solution

### Étape 1 : Exécuter le script SQL
1. Ouvrir phpMyAdmin (http://localhost/phpmyadmin)
2. Sélectionner la base de données `haccp_local`
3. Cliquer sur l'onglet "SQL"
4. Copier/coller le contenu du fichier `fix-encoding.sql`
5. Cliquer sur "Exécuter"

### Étape 2 : Vider le cache Laravel
Exécuter dans le terminal depuis le dossier `haccp-app` :
```bash
php artisan config:clear
php artisan cache:clear
```

### Étape 3 : Redémarrer le serveur
Relancer le serveur Laravel :
```bash
php artisan serve
```

## Vérification
Après ces étapes :
- Les nouveaux enregistrements auront des accents corrects
- Les anciens enregistrements avec "?" devront être corrigés manuellement ou réimportés

## Configuration appliquée
- Base de données : `utf8mb4`
- Collation : `utf8mb4_unicode_ci`
- Laravel configuré pour forcer UTF-8 à la connexion (PDO::MYSQL_ATTR_INIT_COMMAND)

## Note importante
Si vous avez des données existantes avec des "?", vous devrez soit :
1. Les corriger manuellement dans phpMyAdmin
2. Les supprimer et les recréer
3. Faire une exportation/importation avec le bon encodage
