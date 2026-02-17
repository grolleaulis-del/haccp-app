<?php

namespace App\Http\Controllers;

use App\Models\Famille;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Liste des produits
     */
    public function index(Request $request)
    {
        $query = Produit::query();

        // Filtrer par famille si demandé
        if ($request->filled('famille')) {
            $query->where('famille', $request->famille);
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom', 'LIKE', '%' . $request->search . '%');
        }

        $produits = $query->orderBy('famille')->orderBy('nom')->paginate(20);
        $familles = Produit::distinct()->orderBy('famille')->pluck('famille');

        return view('produits.index', compact('produits', 'familles'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $familles = Famille::orderBy('nom')->pluck('nom');
        return view('produits.create', compact('familles'));
    }

    /**
     * Enregistrer un nouveau produit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'famille' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'mode_tracabilite' => 'required|in:etiquette_photo,code_interne',
            'dlc_cuisson_defaut_jours' => 'nullable|integer|min:1',
            'dlc_congelation_defaut_jours' => 'nullable|integer|min:1',
            'dlc_fournisseur' => 'nullable|date',
        ]);

        $data = $validated;
        $data['actif'] = $request->has('actif');
        $data['visible_scan'] = $request->has('visible_scan');
        $data['visible_cuisson'] = $request->has('visible_cuisson');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);

        return redirect()->route('produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Produit $produit)
    {
        $familles = Famille::orderBy('nom')->pluck('nom');
        return view('produits.edit', compact('produit', 'familles'));
    }

    /**
     * Mettre à jour un produit
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'famille' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'mode_tracabilite' => 'required|in:etiquette_photo,code_interne',
            'dlc_cuisson_defaut_jours' => 'nullable|integer|min:1',
            'dlc_congelation_defaut_jours' => 'nullable|integer|min:1',
            'dlc_fournisseur' => 'nullable|date',
        ]);

        $data = $validated;
        $data['actif'] = $request->has('actif');
        $data['visible_scan'] = $request->has('visible_scan');
        $data['visible_cuisson'] = $request->has('visible_cuisson');

        if ($request->hasFile('image')) {
            if ($produit->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);

        return redirect()->route('produits.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprimer un produit
     */
    public function destroy(Produit $produit)
    {
        // Vérifier s'il y a des lots liés
        if ($produit->lots()->exists()) {
            return redirect()->route('produits.index')
                ->with('error', 'Impossible de supprimer ce produit car il a des lots associés.');
        }

        if ($produit->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    /**
     * Supprimer plusieurs produits
     */
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('selected', []);
        
        // Support pour le format array simple (si envoyé via JSON/Input hidden) ou checkbox standard
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (empty($ids)) {
             $validated = $request->validate([
                'produits' => 'required|array|min:1',
                'produits.*' => 'exists:produits,id',
            ]);
            $ids = $validated['produits'];
        }

        $deleted = 0;
        $errors = [];

        foreach ($ids as $produitId) {
            $produit = Produit::find($produitId);

            if ($produit && !$produit->lots()->exists()) {
                if ($produit->image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($produit->image);
                }
                $produit->delete();
                $deleted++;
            } elseif ($produit) {
                $errors[] = $produit->nom;
            }
        }

        if ($deleted === 0 && !empty($errors)) {
            return redirect()->route('produits.index')
                ->with('error', 'Aucun produit supprimé (lots associés).');
        }

        $message = "$deleted produit(s) supprimé(s).";
        if (!empty($errors)) {
            $message .= " Non supprimés : " . implode(', ', array_slice($errors, 0, 5));
        }

        return redirect()->route('produits.index')->with('success', $message);
    }

    /**
     * Toggle Visibilité (Nouveau)
     */
    public function toggleVisibility(Request $request)
    {
        $ids = $request->input('selected', []);
        if (is_string($ids)) $ids = json_decode($ids, true);
        
        $target = $request->input('target'); // 'scan' or 'cuisson'
        $action = $request->input('action'); // 'show' or 'hide'
        
        if (empty($ids) || !in_array($target, ['scan', 'cuisson']) || !in_array($action, ['show', 'hide'])) {
            return back()->with('error', 'Requete invalide.');
        }
        
        $field = ($target === 'scan') ? 'visible_scan' : 'visible_cuisson';
        $value = ($action === 'show');
        
        Produit::whereIn('id', $ids)->update([$field => $value]);
        
        return back()->with('success', 'Visibilité mise à jour.');
    }

    /**
     * Afficher le formulaire d'import
     */
    public function showImport()
    {
        return view('produits.import');
    }

    /**
     * Importer des produits depuis un fichier CSV/Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        try {
            $imported = 0;
            $errors = [];

            if (in_array($extension, ['csv', 'txt'])) {
                // Import CSV
                $handle = fopen($file->getRealPath(), 'r');
                $header = fgetcsv($handle, 1000, ';'); // En-têtes

                if (!$header || count($header) < 3) {
                    fclose($handle);
                    return back()->with('error', 'Format de fichier invalide. En-têtes attendus : Nom;Catégorie;Mode Traçabilité;DLC Cuisson;DLC Congélation;Actif');
                }

                $row = 0;
                while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                    $row++;

                    if (count($data) < 3 || empty($data[0])) {
                        continue; // Ligne vide ou incomplète
                    }

                    try {
                        Produit::create([
                            'nom' => $data[0],
                            'famille' => $data[1],
                            'mode_tracabilite' => isset($data[2]) && $data[2] === 'code_interne' ? 'code_interne' : 'etiquette_photo',
                            'dlc_cuisson_defaut_jours' => !empty($data[3]) ? (int)$data[3] : null,
                            'dlc_congelation_defaut_jours' => !empty($data[4]) ? (int)$data[4] : null,
                            'actif' => !isset($data[5]) || $data[5] !== '0',
                        ]);
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Ligne $row : " . $e->getMessage();
                    }
                }
                fclose($handle);
            } else {
                // Import Excel (nécessite PhpSpreadsheet)
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                // Ignorer la première ligne (en-têtes)
                array_shift($rows);

                $row = 1;
                foreach ($rows as $data) {
                    $row++;

                    if (empty($data[0])) {
                        continue; // Ligne vide
                    }

                    try {
                        Produit::create([
                            'nom' => $data[0],
                            'famille' => $data[1],
                            'mode_tracabilite' => isset($data[2]) && $data[2] === 'code_interne' ? 'code_interne' : 'etiquette_photo',
                            'dlc_cuisson_defaut_jours' => !empty($data[3]) ? (int)$data[3] : null,
                            'dlc_congelation_defaut_jours' => !empty($data[4]) ? (int)$data[4] : null,
                            'actif' => !isset($data[5]) || $data[5] !== 0,
                        ]);
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Ligne $row : " . $e->getMessage();
                    }
                }
            }

            $message = "$imported produit(s) importé(s) avec succès.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " erreur(s) : " . implode(', ', array_slice($errors, 0, 3));
            }

            return redirect()->route('produits.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'import : ' . $e->getMessage());
        }
    }

    /**
     * Télécharger le modèle CSV
     */
    public function downloadTemplate()
    {
        $filename = 'modele_import_produits.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = ['Nom', 'Catégorie', 'Mode Traçabilité', 'DLC Cuisson (jours)', 'DLC Congélation (jours)', 'Actif'];
        $examples = [
            ['Saumon frais', 'Poissons', 'etiquette_photo', '3', '90', '1'],
            ['Crevettes roses', 'Crustacés', 'code_interne', '2', '60', '1'],
            ['Huîtres', 'Coquillages', 'etiquette_photo', '', '', '1'],
        ];

        $callback = function () use ($columns, $examples) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
            fputcsv($file, $columns, ';');
            foreach ($examples as $example) {
                fputcsv($file, $example, ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
