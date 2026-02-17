<?php

namespace App\Http\Controllers;

use App\Models\Famille;
use App\Models\Produit;
use Illuminate\Http\Request;

class FamilleController extends Controller
{
    /**
     * Liste des familles avec compteur de produits
     */
    public function index()
    {
        $familles = Famille::withCount(['produits' => function ($query) {
            // Count via string match
        }])->orderBy('nom')->get();

        // Fallback: count manually via produits table
        foreach ($familles as $famille) {
            $famille->nb_produits = Produit::where('famille', $famille->nom)->count();
        }

        return view('familles.index', compact('familles'));
    }

    /**
     * Enregistrer une nouvelle famille
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:familles,nom',
            'description' => 'nullable|string|max:500',
            'emoji' => 'nullable|string|max:10',
        ]);

        Famille::create($validated);

        return redirect()->route('familles.index')
            ->with('success', 'Famille "' . $validated['nom'] . '" créée avec succès.');
    }

    /**
     * Mettre à jour une famille (+ renommer dans les produits)
     */
    public function update(Request $request, Famille $famille)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:familles,nom,' . $famille->id,
            'description' => 'nullable|string|max:500',
            'emoji' => 'nullable|string|max:10',
        ]);

        $ancienNom = $famille->nom;
        $famille->update($validated);

        // Renommer dans tous les produits liés
        if ($ancienNom !== $validated['nom']) {
            Produit::where('famille', $ancienNom)->update(['famille' => $validated['nom']]);
        }

        return redirect()->route('familles.index')
            ->with('success', 'Famille mise à jour avec succès.');
    }

    /**
     * Supprimer une famille
     */
    public function destroy(Famille $famille)
    {
        $nbProduits = Produit::where('famille', $famille->nom)->count();

        if ($nbProduits > 0) {
            return redirect()->route('familles.index')
                ->with('error', 'Impossible de supprimer cette famille : ' . $nbProduits . ' produit(s) y sont rattachés.');
        }

        $famille->delete();

        return redirect()->route('familles.index')
            ->with('success', 'Famille supprimée avec succès.');
    }
}
