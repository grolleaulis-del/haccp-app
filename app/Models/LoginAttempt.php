<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = [
        'email',
        'ip_address',
        'successful',
        'user_agent',
    ];

    protected $casts = [
        'successful' => 'boolean',
    ];

    /**
     * Vérifier si une IP est bloquée
     */
    public static function isBlocked(string $email, string $ip): bool
    {
        $maxAttempts = 5;
        $decayMinutes = 15;
        
        $attempts = self::where('email', $email)
            ->where('ip_address', $ip)
            ->where('successful', false)
            ->where('created_at', '>', now()->subMinutes($decayMinutes))
            ->count();

        return $attempts >= $maxAttempts;
    }

    /**
     * Obtenir le temps restant avant déblocage (en minutes)
     */
    public static function getBlockedUntil(string $email, string $ip): ?int
    {
        $decayMinutes = 15;
        
        $oldestAttempt = self::where('email', $email)
            ->where('ip_address', $ip)
            ->where('successful', false)
            ->where('created_at', '>', now()->subMinutes($decayMinutes))
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$oldestAttempt) {
            return null;
        }

        $unlockTime = $oldestAttempt->created_at->addMinutes($decayMinutes);
        return now()->diffInMinutes($unlockTime, false);
    }

    /**
     * Réinitialiser les tentatives après succès
     */
    public static function clearAttempts(string $email, string $ip): void
    {
        self::where('email', $email)
            ->where('ip_address', $ip)
            ->where('successful', false)
            ->delete();
    }
}
