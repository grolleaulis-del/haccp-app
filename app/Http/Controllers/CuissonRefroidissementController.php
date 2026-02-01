<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\LotUtilisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CuissonRefroidissementController extends Controller
{
    /**
     * Page de scan (caméra en premier, comme scan-étiquette)
     */
    public function index(Request $request)
    {
        return view('cuisson-refroidissement.index');
    }

    /**
     * Page de sélection du produit après capture photo
     */
    public function selectProduit(Request $request)
    {
        $request->validate([
            'photo' => 'required|string',
        ]);

        $photoData = $request->input('photo');

        $produits = Produit::where('actif', true)
            ->orderBy('famille')
            ->orderBy('nom')
            ->get();

        return view('cuisson-refroidissement.select-produit', compact('photoData', 'produits'));
    }

    /**
     * Afficher le formulaire de cuisson pour un produit
     */
    public function create(Produit $produit)
    {
        return view('cuisson-refroidissement.create', compact('produit'));
    }

    /**
     * Enregistrer la cuisson/refroidissement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'photo' => 'required|string',
            'quantite' => 'required|integer|min:1',
            'dlc_jours' => 'required|integer|min:1',
            'nombre_etiquettes' => 'required|integer|min:1|max:20',
            'temperature_cuisson' => 'nullable|numeric',
            'temperature_refroidissement' => 'nullable|numeric',
            'observations' => 'nullable|string|max:500',
        ]);

        $produit = Produit::findOrFail($validated['produit_id']);

        // Décoder et sauvegarder la photo
        $filename = null;
        $photoData = $validated['photo'];
        if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
            $photoData = substr($photoData, strpos($photoData, ',') + 1);
            $photoData = base64_decode($photoData);
            $filename = 'cuisson_' . time() . '_' . uniqid() . '.jpg';
            Storage::disk('public')->put('photos_cuisson/' . $filename, $photoData);
        }

        // Créer le lot de cuisson
        $lot = LotUtilisation::create([
            'produit_id' => $produit->id,
            'user_id' => auth()->id(),
            'quantite' => $validated['quantite'],
            'date_production' => now(),
            'dlc' => now()->addDays($validated['dlc_jours']),
            'photo_etiquette' => $filename ?? null,
            'type_operation' => 'cuisson',
            'temperature_cuisson' => $validated['temperature_cuisson'] ?? null,
            'temperature_refroidissement' => $validated['temperature_refroidissement'] ?? null,
            'observations' => $validated['observations'] ?? null,
            'started_at' => now(),
        ]);

        // Rediriger directement vers l'impression des étiquettes
        $nombre = $validated['nombre_etiquettes'];
        return view('cuisson-refroidissement.print-labels', compact('lot', 'nombre'));
    }

    /**
     * Page de confirmation
     */
    public function success(LotUtilisation $lot)
    {
        return view('cuisson-refroidissement.success', compact('lot'));
    }

    /**
     * Historique des cuissons
     */
    public function historique(Request $request)
    {
        $query = LotUtilisation::with(['produit', 'user'])
            ->where('type_operation', 'cuisson')
            ->latest();

        if ($request->filled('date')) {
            $query->whereDate('date_production', $request->date);
        }

        $lots = $query->paginate(20);

        return view('cuisson-refroidissement.historique', compact('lots'));
    }

    /**
     * Imprimer des étiquettes pour un lot
     */
    public function printLabels(Request $request, LotUtilisation $lot)
    {
        $validated = $request->validate([
            'nombre_etiquettes' => 'required|integer|min:1|max:20',
        ]);

        $nombre = $validated['nombre_etiquettes'];

        return view('cuisson-refroidissement.print-labels', compact('lot', 'nombre'));
    }

    /**
     * Supprimer un lot
     */
    public function destroy(LotUtilisation $lot)
    {
        // Supprimer la photo si elle existe
        if ($lot->photo_etiquette) {
            $photoPath = 'photos_cuisson/' . $lot->photo_etiquette;
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
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
            if ($lot && $lot->type_operation === 'cuisson') {
                // Supprimer la photo
                if ($lot->photo_etiquette) {
                    $photoPath = 'photos_cuisson/' . $lot->photo_etiquette;
                    if (Storage::disk('public')->exists($photoPath)) {
                        Storage::disk('public')->delete($photoPath);
                    }
                }
                $lot->delete();
                $deleted++;
            }
        }

        return redirect()->back()
            ->with('success', "{$deleted} lot(s) supprimé(s) avec succès.");
    }

    /**
     * Afficher tous les lots dont la DLC est toujours en cours (DLC >= aujourd'hui)
     */
    public function dlcEnCours()
    {
        $today = Carbon::today();
        
        $lots = LotUtilisation::where('dlc', '>=', $today)
            ->where('type_operation', 'cuisson')
            ->with(['produit', 'user'])
            ->orderBy('dlc', 'asc')
            ->get();

        return view('cuisson-refroidissement.dlc-en-cours', compact('lots'));
    }
}
