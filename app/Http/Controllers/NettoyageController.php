<?php

namespace App\Http\Controllers;

use App\Models\TacheNettoyage;
use App\Models\Nettoyage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NettoyageController extends Controller
{
    /**
     * Dashboard nettoyage - affiche l'état des tâches
     */
    public function index(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));

        $taches = TacheNettoyage::where('actif', true)
            ->with(['nettoyages' => function ($query) use ($date) {
                $query->whereDate('done_at', $date)->latest();
            }])
            ->orderBy('nom')
            ->get();

        // Historique du jour
        $historique = Nettoyage::with('tache', 'user')
            ->whereDate('done_at', $date)
            ->orderBy('done_at', 'desc')
            ->paginate(20);

        return view('nettoyage.index', [
            'taches' => $taches,
            'historique' => $historique,
            'date' => $date,
        ]);
    }

    /**
     * Affiche le formulaire d'enregistrement
     */
    public function create()
    {
        $taches = TacheNettoyage::where('actif', true)
            ->orderBy('nom')
            ->get();

        return view('nettoyage.create', [
            'taches' => $taches,
        ]);
    }

    /**
     * Enregistre une tâche de nettoyage effectuée
     */
    public function store(Request $request)
    {
        $request->validate([
            'tache_nettoyage_id' => 'required|exists:taches_nettoyage,id',
            'done_at' => 'required|string',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $doneAt = $this->parseDateTime($request->input('done_at'));

        Nettoyage::create([
            'tache_nettoyage_id' => $request->tache_nettoyage_id,
            'done_at' => $doneAt,
            'commentaire' => $request->commentaire,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('nettoyage.index')
            ->with('success', 'Nettoyage enregistré avec succès.');
    }

    /**
     * Enregistrement rapide - marquer une tâche comme faite maintenant
     */
    public function quickRecord(Request $request, TacheNettoyage $tache)
    {
        $request->validate([
            'commentaire' => 'nullable|string|max:500',
        ]);

        Nettoyage::create([
            'tache_nettoyage_id' => $tache->id,
            'done_at' => now(),
            'commentaire' => $request->commentaire,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('nettoyage.index')
            ->with('success', $tache->nom . ' enregistré.');
    }

    /**
     * Affiche le formulaire d'édition d'un record
     */
    public function edit(Nettoyage $nettoyage)
    {
        $taches = TacheNettoyage::where('actif', true)
            ->orderBy('nom')
            ->get();

        return view('nettoyage.edit', [
            'nettoyage' => $nettoyage,
            'taches' => $taches,
        ]);
    }

    /**
     * Met à jour un record de nettoyage
     */
    public function update(Request $request, Nettoyage $nettoyage)
    {
        $request->validate([
            'tache_nettoyage_id' => 'required|exists:taches_nettoyage,id',
            'done_at' => 'required|string',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $doneAt = $this->parseDateTime($request->input('done_at'));

        $nettoyage->update([
            'tache_nettoyage_id' => $request->tache_nettoyage_id,
            'done_at' => $doneAt,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('nettoyage.index')
            ->with('success', 'Nettoyage mis à jour avec succès.');
    }

    /**
     * Supprime un record de nettoyage
     */
    public function destroy(Nettoyage $nettoyage)
    {
        $nettoyage->delete();
        return redirect()->route('nettoyage.index')
            ->with('success', 'Nettoyage supprimé.');
    }

    /**
     * Parse date coming either from datetime-local (Y-m-d\TH:i) or from d/m/Y H:i.
     */
    private function parseDateTime(string $value): string
    {
        // Browser datetime-local default
        try {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // fallback for formats like 23/01/2026 14:10
            return Carbon::createFromFormat('d/m/Y H:i', $value)->format('Y-m-d H:i:s');
        }
    }

    /**
     * Gère les tâches de nettoyage
     */
    public function taches()
    {
        $taches = TacheNettoyage::orderBy('nom')->paginate(15);
        return view('nettoyage.taches.index', ['taches' => $taches]);
    }

    public function createTache()
    {
        return view('nettoyage.taches.create');
    }

    public function storeTache(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:taches_nettoyage|max:255',
        ]);

        TacheNettoyage::create([
            'nom' => $request->nom,
            'actif' => true,
        ]);

        return redirect()->route('nettoyage.taches')
            ->with('success', 'Tâche créée avec succès.');
    }

    public function editTache(TacheNettoyage $tache)
    {
        return view('nettoyage.taches.edit', ['tache' => $tache]);
    }

    public function updateTache(Request $request, TacheNettoyage $tache)
    {
        $request->validate([
            'nom' => 'required|string|unique:taches_nettoyage,nom,' . $tache->id . '|max:255',
            'actif' => 'boolean',
        ]);

        $tache->update([
            'nom' => $request->nom,
            'actif' => $request->boolean('actif'),
        ]);

        return redirect()->route('nettoyage.taches')
            ->with('success', 'Tâche mise à jour avec succès.');
    }

    public function destroyTache(TacheNettoyage $tache)
    {
        $tache->delete();
        return redirect()->route('nettoyage.taches')
            ->with('success', 'Tâche supprimée.');
    }
}
