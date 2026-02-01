<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\LotUtilisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ScanEtiquetteController extends Controller
{
    /**
     * Page de scan d'étiquette (caméra qui s'ouvre automatiquement)
     */
    public function index()
    {
        return view('scan-etiquette.index');
    }

    /**
     * Page de sélection du produit après capture photo
     */
    public function selectProduit(Request $request)
    {
        $request->validate([
            'skip_photo' => 'nullable|boolean',
            'photo' => 'nullable|string|required_without:skip_photo',
        ]);

        $photoData = $request->input('photo');
        $skipPhoto = (bool) $request->input('skip_photo');

        // Récupérer tous les produits actifs
        $produits = Produit::where('actif', true)
            ->orderBy('famille')
            ->orderBy('nom')
            ->get();

        return view('scan-etiquette.select-produit', compact('photoData', 'skipPhoto', 'produits'));
    }

    /**
     * Enregistrer le lot avec la photo et le produit sélectionné
     */
    public function storeLot(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|string',
            'produit_id' => 'required|exists:produits,id',
            'numero_lot' => 'nullable|string|max:50',
            'dlc' => 'nullable|date',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $produit = Produit::findOrFail($request->produit_id);

        DB::transaction(function () use ($produit, $request) {
            // Clôturer le lot actif s'il existe
            $lotActif = $produit->lotActif()->first();
            if ($lotActif) {
                $lotActif->update([
                    'statut' => 'termine',
                    'ended_at' => now(),
                ]);
            }

            // Sauvegarder la photo base64
            $photoPath = null;
            $photoData = $request->input('photo');

            if ($photoData && strpos($photoData, 'data:image') === 0) {
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

            // Créer le nouveau lot
            LotUtilisation::create([
                'produit_id' => $produit->id,
                'numero_lot' => $request->numero_lot,
                'dlc' => $request->dlc,
                'statut' => 'actif',
                'started_at' => now(),
                'photo_etiquette' => $photoPath,
                'commentaire' => $request->commentaire,
                'user_id' => auth()->id(),
                'type_operation' => 'usage',
            ]);
        });

        return redirect()->route('scan-etiquette.index')
            ->with('success', "Lot enregistré avec succès pour {$produit->nom}");
    }

    /**
     * Supprimer un lot
     */
    public function destroy(LotUtilisation $lot)
    {
        // Supprimer la photo si elle existe
        if ($lot->photo_etiquette && Storage::disk('public')->exists($lot->photo_etiquette)) {
            Storage::disk('public')->delete($lot->photo_etiquette);
        }
        if ($lot->photo_path && Storage::disk('public')->exists($lot->photo_path)) {
            Storage::disk('public')->delete($lot->photo_path);
        }

        $produitNom = $lot->produit->nom ?? 'ce lot';
        $lot->delete();

        return redirect()->back()
            ->with('success', "Le lot de {$produitNom} a été supprimé avec succès.");
    }

    /**
     * Supprimer plusieurs lots
     */
    public function destroyMultiple(Request $request)
    {
        $validated = $request->validate([
            'lots' => 'required|array|min:1',
            'lots.*' => 'exists:lot_utilisations,id',
        ], [
            'lots.required' => 'Veuillez sélectionner au moins un lot.',
            'lots.min' => 'Veuillez sélectionner au moins un lot.',
        ]);

        $deleted = 0;
        foreach ($validated['lots'] as $lotId) {
            $lot = LotUtilisation::find($lotId);
            if ($lot) {
                // Supprimer les photos
                if ($lot->photo_etiquette && Storage::disk('public')->exists($lot->photo_etiquette)) {
                    Storage::disk('public')->delete($lot->photo_etiquette);
                }
                if ($lot->photo_path && Storage::disk('public')->exists($lot->photo_path)) {
                    Storage::disk('public')->delete($lot->photo_path);
                }
                $lot->delete();
                $deleted++;
            }
        }

        return redirect()->back()
            ->with('success', "{$deleted} lot(s) supprimé(s) avec succès.");
    }
}
