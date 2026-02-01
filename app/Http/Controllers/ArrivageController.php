<?php

namespace App\Http\Controllers;

use App\Models\Arrivage;
use App\Models\ArrivageLigne;
use App\Models\Produit;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArrivageController extends Controller
{
    /**
     * Liste les arrivages avec filtres
     */
    public function index(Request $request)
    {
        $query = Arrivage::with('fournisseur', 'lignes.produit');

        // Filtrer par date
        if ($request->filled('date_debut')) {
            $query->where('date_arrivage', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_arrivage', '<=', $request->date_fin);
        }

        // Filtrer par fournisseur
        if ($request->filled('fournisseur_id')) {
            $query->where('fournisseur_id', $request->fournisseur_id);
        }

        $arrivages = $query->orderBy('date_arrivage', 'desc')->paginate(10);
        $fournisseurs = Fournisseur::orderBy('nom')->get();

        return view('arrivages.index', [
            'arrivages' => $arrivages,
            'fournisseurs' => $fournisseurs,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'fournisseur_id' => $request->fournisseur_id,
        ]);
    }

    /**
     * Affiche le formulaire de création d'arrivage
     */
    public function create()
    {
        $fournisseurs = Fournisseur::orderBy('nom')->get();
        $produits = Produit::where('actif', true)->orderBy('nom')->get();

        return view('arrivages.create', [
            'fournisseurs' => $fournisseurs,
            'produits' => $produits,
        ]);
    }

    /**
     * Enregistre un nouvel arrivage avec ses lignes
     */
    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date_arrivage' => 'required|date',
            'bl_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'commentaire' => 'nullable|string|max:500',
            'lignes' => 'nullable|array',
            'lignes.*.produit_id' => 'required|exists:produits,id',
            'lignes.*.numero_lot' => 'nullable|string|max:100',
            'lignes.*.photo' => 'nullable|image|max:5120',
            'lignes.*.commentaire' => 'nullable|string|max:500',
        ]);

        // Créer l'arrivage
        $blPath = null;
        if ($request->hasFile('bl_file')) {
            Storage::disk('public')->makeDirectory('bl');
            $blPath = $request->file('bl_file')->store('bl', 'public');
        }

        $arrivage = Arrivage::create([
            'fournisseur_id' => $request->fournisseur_id,
            'date_arrivage' => $request->date_arrivage,
            'bl_path' => $blPath,
            'commentaire' => $request->commentaire,
        ]);

        // Créer les lignes si présentes
        if ($request->has('lignes') && is_array($request->lignes)) {
            foreach ($request->lignes as $ligne) {
                $photoPath = null;
                if (isset($ligne['photo'])) {
                    Storage::disk('public')->makeDirectory('arrivages');
                    $photoPath = $ligne['photo']->store('arrivages', 'public');
                }

                ArrivageLigne::create([
                    'arrivage_id' => $arrivage->id,
                    'produit_id' => $ligne['produit_id'],
                    'numero_lot' => $ligne['numero_lot'] ?? null,
                    'photo_path' => $photoPath,
                    'commentaire' => $ligne['commentaire'] ?? null,
                ]);
            }
        }

        return redirect()->route('arrivages.show', $arrivage)
            ->with('success', 'Arrivage créé avec succès.');
    }

    /**
     * Affiche un arrivage avec ses lignes
     */
    public function show(Arrivage $arrivage)
    {
        $arrivage->load('fournisseur', 'lignes.produit');
        $produits = Produit::where('actif', true)->orderBy('nom')->get();

        return view('arrivages.show', [
            'arrivage' => $arrivage,
            'produits' => $produits,
        ]);
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Arrivage $arrivage)
    {
        $fournisseurs = Fournisseur::orderBy('nom')->get();
        $produits = Produit::where('actif', true)->orderBy('nom')->get();

        return view('arrivages.edit', [
            'arrivage' => $arrivage,
            'fournisseurs' => $fournisseurs,
            'produits' => $produits,
        ]);
    }

    /**
     * Met à jour un arrivage (simple pour le moment)
     */
    public function update(Request $request, Arrivage $arrivage)
    {
        $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date_arrivage' => 'required|date',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $arrivage->update([
            'fournisseur_id' => $request->fournisseur_id,
            'date_arrivage' => $request->date_arrivage,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('arrivages.show', $arrivage)
            ->with('success', 'Arrivage mis à jour.');
    }

    /**
     * Ajoute une ligne à un arrivage existant
     */
    public function addLigne(Request $request, Arrivage $arrivage)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'numero_lot' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:5120',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            Storage::disk('public')->makeDirectory('arrivages');
            $photoPath = $request->file('photo')->store('arrivages', 'public');
        }

        ArrivageLigne::create([
            'arrivage_id' => $arrivage->id,
            'produit_id' => $request->produit_id,
            'numero_lot' => $request->numero_lot,
            'photo_path' => $photoPath,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('arrivages.show', $arrivage)
            ->with('success', 'Ligne ajoutée.');
    }
}
