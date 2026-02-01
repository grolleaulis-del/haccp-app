<?php

return [

    'backup' => [

        /*
         * Nom de la sauvegarde
         */
        'name' => env('APP_NAME', 'haccp'),

        'source' => [

            'files' => [

                /*
                 * Fichiers et dossiers à inclure dans la sauvegarde
                 */
                'include' => [
                    base_path(),
                ],

                /*
                 * Fichiers et dossiers à exclure
                 */
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                    base_path('storage/framework/cache'),
                    base_path('storage/framework/sessions'),
                    base_path('storage/framework/views'),
                    base_path('storage/logs'),
                ],

                /*
                 * Suivre les liens symboliques
                 */
                'follow_links' => false,

                /*
                 * Ignorer les fichiers non lisibles
                 */
                'ignore_unreadable_directories' => false,

                /*
                 * Taille maximale relative d'un fichier après compression
                 */
                'relative_path' => null,
            ],

            /*
             * Bases de données à sauvegarder
             */
            'databases' => [
                'mysql',
            ],
        ],

        /*
         * Destination des sauvegardes
         */
        'destination' => [

            /*
             * Système de fichiers où stocker les sauvegardes
             */
            'disks' => [
                'local',
            ],
        ],

        /*
         * Durée de conservation des sauvegardes temporaires
         */
        'temporary_directory' => storage_path('app/backup-temp'),

        /*
         * Mot de passe pour chiffrer les sauvegardes (optionnel)
         */
        'password' => env('BACKUP_ARCHIVE_PASSWORD'),

        /*
         * Compression
         */
        'compression' => 'gzip',
    ],

    /*
     * Configuration de nettoyage des anciennes sauvegardes
     */
    'cleanup' => [
        /*
         * Stratégie de nettoyage
         */
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,

        /*
         * Nombre de sauvegardes complètes à conserver
         */
        'default_strategy' => [

            /*
             * Conserver toutes les sauvegardes des 7 derniers jours
             */
            'keep_all_backups_for_days' => 7,

            /*
             * Conserver 1 sauvegarde quotidienne pendant 16 jours
             */
            'keep_daily_backups_for_days' => 16,

            /*
             * Conserver 1 sauvegarde hebdomadaire pendant 8 semaines
             */
            'keep_weekly_backups_for_weeks' => 8,

            /*
             * Conserver 1 sauvegarde mensuelle pendant 4 mois
             */
            'keep_monthly_backups_for_months' => 4,

            /*
             * Conserver 1 sauvegarde annuelle pendant 2 ans
             */
            'keep_yearly_backups_for_years' => 2,

            /*
             * Supprimer les sauvegardes de plus de X Mo
             */
            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
        ],
    ],

    /*
     * Configuration des notifications
     */
    'notifications' => [

        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessfulNotification::class => ['mail'],
        ],

        /*
         * Email pour recevoir les notifications
         */
        'mail' => [
            'to' => env('BACKUP_MAIL_TO', 'admin@example.com'),
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'backup@example.com'),
                'name' => env('MAIL_FROM_NAME', 'Backup System'),
            ],
        ],

        'slack' => [
            'webhook_url' => '',
            'channel' => null,
            'username' => null,
            'icon' => null,
        ],

        'discord' => [
            'webhook_url' => '',
            'username' => '',
            'avatar_url' => '',
        ],
    ],

    /*
     * Commandes à exécuter avant et après la sauvegarde
     */
    'monitorBackups' => [
        [
            'name' => env('APP_NAME', 'haccp'),
            'disks' => ['local'],
            'health_checks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,
            ],
        ],
    ],

    'backup_job_class' => \Spatie\Backup\BackupDestination\BackupDestination::class,

    'cleanup_job_class' => \Spatie\Backup\Tasks\Cleanup\CleanupJob::class,

    'monitor_backups_job_class' => \Spatie\Backup\Tasks\Monitor\MonitorBackupsJob::class,

];
