<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Models\LoginAttempt;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $email = $request->input('email');
        $ip = $request->ip();

        // Vérifier si l'IP est bloquée
        if (LoginAttempt::isBlocked($email, $ip)) {
            $minutesLeft = LoginAttempt::getBlockedUntil($email, $ip);
            return back()->withErrors([
                'email' => "Trop de tentatives de connexion. Réessayez dans {$minutesLeft} minutes.",
            ])->onlyInput('email');
        }

        try {
            $request->authenticate();

            // Connexion réussie
            LoginAttempt::create([
                'email' => $email,
                'ip_address' => $ip,
                'successful' => true,
                'user_agent' => $request->userAgent(),
            ]);

            // Nettoyer les anciennes tentatives
            LoginAttempt::clearAttempts($email, $ip);

            // Mettre à jour les infos de connexion
            $user = Auth::user();
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $ip,
            ]);

            // Log d'activité
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'login',
                'description' => 'Connexion réussie',
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
            ]);

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer la tentative échouée
            LoginAttempt::create([
                'email' => $email,
                'ip_address' => $ip,
                'successful' => false,
                'user_agent' => $request->userAgent(),
            ]);

            throw $e;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Log d'activité
        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'logout',
                'description' => 'Déconnexion',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
