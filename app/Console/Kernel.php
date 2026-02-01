<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Sauvegarde quotidienne à 2h du matin
        $schedule->command('backup:run --only-db')
            ->daily()
            ->at('02:00')
            ->onSuccess(function () {
                \Log::info('Sauvegarde quotidienne réussie');
            })
            ->onFailure(function () {
                \Log::error('Échec de la sauvegarde quotidienne');
            });

        // Nettoyage des anciennes sauvegardes tous les dimanches à 3h
        $schedule->command('backup:clean')
            ->weekly()
            ->sundays()
            ->at('03:00');

        // Vérification de l'état des sauvegardes tous les lundis à 9h
        $schedule->command('backup:monitor')
            ->weekly()
            ->mondays()
            ->at('09:00');

        // Nettoyage des anciennes tentatives de connexion chaque jour
        $schedule->call(function () {
            \App\Models\LoginAttempt::where('created_at', '<', now()->subDays(30))->delete();
        })->daily()->at('04:00');

        // Nettoyage des anciens logs d'activité (garder 90 jours)
        $schedule->call(function () {
            \App\Models\ActivityLog::where('created_at', '<', now()->subDays(90))->delete();
        })->weekly()->sundays()->at('05:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
