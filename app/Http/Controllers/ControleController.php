<?php

namespace App\Http\Controllers;

use App\Models\Arrivage;
use App\Models\Fournisseur;
use App\Models\LotUtilisation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ControleController extends Controller
{
    /**
     * Affiche la page de contrôle avec filtres
     */
    public function index(Request $request)
    {
        $query = Arrivage::with('fournisseur', 'lignes.produit');

        // Filtres
        if ($request->filled('date_debut')) {
            $query->where('date_arrivage', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_arrivage', '<=', $request->date_fin);
        }
        if ($request->filled('fournisseur_id')) {
            $query->where('fournisseur_id', $request->fournisseur_id);
        }

        $arrivages = $query->orderBy('date_arrivage', 'desc')->paginate(15);

        // Récupérer les lots d'utilisation
        $lotsQuery = LotUtilisation::with(['produit', 'user']);

        // Filtres pour les lots
        if ($request->filled('date_debut')) {
            $lotsQuery->whereDate('started_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $lotsQuery->whereDate('started_at', '<=', $request->date_fin);
        }
        if ($request->filled('type_operation')) {
            $lotsQuery->where('type_operation', $request->type_operation);
        }

        $lots = $lotsQuery->orderBy('started_at', 'desc')->paginate(15);

        $fournisseurs = Fournisseur::orderBy('nom')->get();

        return view('controle.index', [
            'arrivages' => $arrivages,
            'lots' => $lots,
            'fournisseurs' => $fournisseurs,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'fournisseur_id' => $request->fournisseur_id,
            'type_operation' => $request->type_operation,
        ]);
    }

    /**
     * Export PDF d'un arrivage
     */
    public function exportPdf(Arrivage $arrivage)
    {
        $arrivage->load('fournisseur', 'lignes.produit');

        $pdf = Pdf::loadView('controle.pdf', ['arrivage' => $arrivage]);

        return $pdf->download('arrivage_' . $arrivage->id . '_' . $arrivage->date_arrivage->format('Y-m-d') . '.pdf');
    }

    /**
     * Export ZIP avec PDF + photos + BL
     */
    public function exportZip(Arrivage $arrivage)
    {
        $arrivage->load('fournisseur', 'lignes.produit');

        // Créer un fichier ZIP temporaire
        $zipFileName = 'arrivage_' . $arrivage->id . '_' . $arrivage->date_arrivage->format('Y-m-d') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Créer le dossier temp s'il n'existe pas
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Impossible de créer le fichier ZIP.');
        }

        // Ajouter le PDF
        $pdf = Pdf::loadView('controle.pdf', ['arrivage' => $arrivage]);
        $pdfContent = $pdf->output();
        $zip->addFromString('arrivage_' . $arrivage->id . '.pdf', $pdfContent);

        // Ajouter le BL si existe
        if ($arrivage->bl_path && Storage::disk('public')->exists($arrivage->bl_path)) {
            $blPath = Storage::disk('public')->path($arrivage->bl_path);
            $blName = basename($arrivage->bl_path);
            $zip->addFile($blPath, 'BL_' . $blName);
        }

        // Ajouter les photos des lignes
        foreach ($arrivage->lignes as $index => $ligne) {
            if ($ligne->photo_path && Storage::disk('public')->exists($ligne->photo_path)) {
                $photoPath = Storage::disk('public')->path($ligne->photo_path);
                $photoName = basename($ligne->photo_path);
                $zip->addFile($photoPath, 'photos/' . ($index + 1) . '_' . $photoName);
            }
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Export PDF global avec filtres
     */
    public function exportPdfGlobal(Request $request)
    {
        $query = Arrivage::with('fournisseur', 'lignes.produit');

        if ($request->filled('date_debut')) {
            $query->where('date_arrivage', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_arrivage', '<=', $request->date_fin);
        }
        if ($request->filled('fournisseur_id')) {
            $query->where('fournisseur_id', $request->fournisseur_id);
        }

        $arrivages = $query->orderBy('date_arrivage', 'desc')->get();

        // Récupérer les lots
        $lotsQuery = LotUtilisation::with(['produit', 'user']);

        if ($request->filled('date_debut')) {
            $lotsQuery->whereDate('started_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $lotsQuery->whereDate('started_at', '<=', $request->date_fin);
        }
        if ($request->filled('type_operation')) {
            $lotsQuery->where('type_operation', $request->type_operation);
        }

        $lots = $lotsQuery->orderBy('started_at', 'desc')->get();

        $pdf = Pdf::loadView('controle.pdf-global', [
            'arrivages' => $arrivages,
            'lots' => $lots,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        $filename = 'controle_complet_' . now()->format('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}
