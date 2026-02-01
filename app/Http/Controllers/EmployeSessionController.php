<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeSessionController extends Controller
{
    /**
     * Afficher la page de sélection d'employé
     */
    public function index()
    {
        $employes = User::orderBy('name')->get();
        return view('employe-session.index', compact('employes'));
    }

    /**
     * Sélectionner un employé pour la session
     */
    public function select(Request $request, User $user)
    {
        // Connecter l'utilisateur
        Auth::login($user);

        // Enregistrer l'employé actif en session
        session(['employe_actif_id' => $user->id]);
        session(['employe_actif_name' => $user->name]);
        session(['last_activity' => now()->timestamp]);

        // Log de l'action
        ActivityLog::log('login', 'session', "Connexion de {$user->name}");

        // Rediriger vers le dashboard avec les 3 carrés
        return redirect()->route('dashboard');
    }

    /**
     * Déconnecter l'employé (retour à la sélection)
     */
    public function deselect()
    {
        $userName = session('employe_actif_name', 'Utilisateur');

        // Log de l'action
        ActivityLog::log('logout', 'session', "Déconnexion de {$userName}");

        Auth::logout();
        session()->forget(['employe_actif_id', 'employe_actif_name', 'last_activity']);
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('employe-session.index');
    }
}
