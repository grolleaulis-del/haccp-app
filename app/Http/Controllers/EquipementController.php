<?php

namespace App\Http\Controllers;

use App\Models\EquipementTemperature;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    /**
     * Liste les équipements
     */
    public function index()
    {
        $equipements = EquipementTemperature::orderBy('nom')->paginate(15);
        return view('equipements.index', ['equipements' => $equipements]);
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('equipements.create');
    }

    /**
     * Enregistre un nouvel équipement
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:equipements_temperature|max:255',
        ]);

        EquipementTemperature::create([
            'nom' => $request->nom,
            'actif' => true,
        ]);

        return redirect()->route('equipements.index')
            ->with('success', 'Équipement ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(EquipementTemperature $equipement)
    {
        return view('equipements.edit', ['equipement' => $equipement]);
    }

    /**
     * Met à jour un équipement
     */
    public function update(Request $request, EquipementTemperature $equipement)
    {
        $request->validate([
            'nom' => 'required|string|unique:equipements_temperature,nom,' . $equipement->id . '|max:255',
            'actif' => 'boolean',
        ]);

        $equipement->update([
            'nom' => $request->nom,
            'actif' => $request->boolean('actif'),
        ]);

        return redirect()->route('equipements.index')
            ->with('success', 'Équipement mis à jour avec succès.');
    }

    /**
     * Supprime un équipement
     */
    public function destroy(EquipementTemperature $equipement)
    {
        $equipement->delete();
        return redirect()->route('equipements.index')
            ->with('success', 'Équipement supprimé.');
    }
}
