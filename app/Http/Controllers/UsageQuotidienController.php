<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\LotUtilisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UsageQuotidienController extends Controller
{
    /**
     * Affiche la liste des produits avec leur lot actif
     */
    public function index(Request $request)
    {
        // Récupérer toutes les familles
        $familles = Produit::where('actif', true)
            ->select('famille', DB::raw('COUNT(*) as count'))
            ->groupBy('famille')
            ->orderBy('famille')
            ->get();

        $produits = collect();
        $familleSelectionnee = $request->famille;

        // Si une famille est sélectionnée, charger ses produits
        if ($request->filled('famille')) {
            $produits = Produit::where('actif', true)
                ->where('famille', $request->famille)
                ->with('lotActif')
                ->orderBy('nom')
                ->get();
        }

        // Récupérer les lots créés aujourd'hui (type usage)
        $lotsAujourdhui = LotUtilisation::with(['produit', 'user'])
            ->where('type_operation', 'usage')
            ->whereDate('started_at', now()->toDateString())
            ->orderBy('started_at', 'desc')
            ->get();

        return view('usage-quotidien.index', [
            'produits' => $produits,
            'familles' => $familles,
            'familleSelectionnee' => $familleSelectionnee,
            'lotsAujourdhui' => $lotsAujourdhui,
        ]);
    }

    /**
     * Affiche le formulaire pour changer de lot
     */
    public function showChangerLot(Produit $produit)
    {
        $lotActif = $produit->lotActif()->first();

        return view('usage-quotidien.changer-lot', [
            'produit' => $produit,
            'lotActif' => $lotActif,
        ]);
    }

    /**
     * Change le lot actif (clôture l'ancien, crée le nouveau)
     * RÈGLE MÉTIER : Un seul lot actif par produit
     */
    public function changerLot(Request $request, Produit $produit)
    {
        // Validation selon mode_tracabilite
        if ($produit->mode_tracabilite === 'etiquette_photo') {
            $request->validate([
                'photo' => 'required|string',
                'commentaire' => 'nullable|string|max:500',
            ], [
                'photo.required' => 'Une photo est obligatoire pour ce mode de traçabilité.',
            ]);
        } elseif ($produit->mode_tracabilite === 'code_interne') {
            $request->validate([
                'code_interne' => 'required|string|max:100',
                'photo' => 'nullable|string',
                'commentaire' => 'nullable|string|max:500',
            ], [
                'code_interne.required' => 'Un code interne est obligatoire pour ce mode de traçabilité.',
            ]);
        }

        // Transaction : clôturer ancien lot + créer nouveau
        DB::transaction(function () use ($produit, $request) {
            // Clôturer le lot actif s'il existe
            $lotActif = $produit->lotActif()->first();
            if ($lotActif) {
                $lotActif->update([
                    'statut' => 'termine',
                    'ended_at' => now(),
                ]);
            }

            // Gérer la photo (base64 via composant caméra OU fichier uploadé)
            $photoPath = null;

            // Cas 1: base64 provenant du composant <x-camera-capture>
            $photoData = $request->input('photo');
            if ($photoData && is_string($photoData) && strpos($photoData, 'data:image') === 0) {
                preg_match('/data:image\/(\w+);base64,(.*)/', $photoData, $matches);
                if (count($matches) === 3) {
                    $extension = $matches[1];
                    $imageData = base64_decode($matches[2]);

                    Storage::disk('public')->makeDirectory('lots');
                    $fileName = uniqid('lot_', true) . '.' . $extension;
                    $storedPath = 'lots/' . $fileName;

                    Storage::disk('public')->put($storedPath, $imageData);
                    $photoPath = $storedPath;
                }
            }

            // Cas 2: fichier uploadé (mode code_interne avec photo optionnelle)
            if (!$photoPath && $request->hasFile('photo') && $request->file('photo')->isValid()) {
                Storage::disk('public')->makeDirectory('lots');
                // stocker le fichier dans le dossier 'lots' du disque public
                $storedPath = $request->file('photo')->store('lots', 'public');
                $photoPath = $storedPath;
            }

            LotUtilisation::create([
                'produit_id' => $produit->id,
                'statut' => 'actif',
                'started_at' => now(),
                'photo_etiquette' => $photoPath,
                'code_interne' => $request->code_interne ?? null,
                'commentaire' => $request->commentaire,
                'user_id' => auth()->id(),
                'type_operation' => 'usage',
            ]);
        });

        return redirect()->route('usage-quotidien.index')
            ->with('success', "Lot du produit '{$produit->nom}' changé avec succès.");
    }

    /**
     * Clôture le lot actif du produit
     */
    public function cloturer(LotUtilisation $lot, Request $request)
    {
        // Vérifier que le lot est actif
        if ($lot->statut !== 'actif') {
            return redirect()->back()
                ->with('error', 'Ce lot n\'est pas actif.');
        }

        $request->validate([
            'commentaire' => 'nullable|string|max:500',
        ]);

        $lot->update([
            'statut' => 'termine',
            'ended_at' => now(),
            'commentaire' => $request->commentaire ?? $lot->commentaire,
        ]);

        $produitNom = $lot->produit->nom;
        return redirect()->route('usage-quotidien.index')
            ->with('success', "Lot du produit '{$produitNom}' clôturé.");
    }

    /**
     * Affiche l'historique des lots terminés
     */
    public function historique(Request $request)
    {
        $query = LotUtilisation::where('statut', 'termine')
            ->with(['produit', 'user']);

        // Filtrer par produit si demandé
        if ($request->filled('produit_id')) {
            $query->where('produit_id', $request->produit_id);
        }

        // Filtrer par famille
        if ($request->filled('famille')) {
            $query->whereHas('produit', function($q) use ($request) {
                $q->where('famille', $request->famille);
            });
        }

        // Filtrer par période
        if ($request->filled('date_debut')) {
            $query->where('started_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('ended_at', '<=', $request->date_fin . ' 23:59:59');
        }

        $lots = $query->orderBy('ended_at', 'desc')->paginate(50);

        $produits = Produit::where('actif', true)->orderBy('nom')->get();
        $familles = Produit::where('actif', true)->distinct()->orderBy('famille')->pluck('famille');

        return view('usage-quotidien.historique', compact('lots', 'produits', 'familles'));
    }
}
