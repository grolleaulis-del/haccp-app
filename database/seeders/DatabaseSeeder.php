<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Produit;
use App\Models\Fournisseur;
use App\Models\EquipementTemperature;
use App\Models\TacheNettoyage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer 1 utilisateur test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Fournisseurs (3)
        $fournisseurs = [
            ['nom' => 'Poissonnerie Côtière', 'telephone' => '02 XX XX XX XX', 'email' => 'contact@poissonneriecotiere.fr'],
            ['nom' => 'Crustacés Atlantique', 'telephone' => '02 YY YY YY YY', 'email' => 'contact@crustaces-atlantique.fr'],
            ['nom' => 'Conserverie Locale', 'telephone' => '02 ZZ ZZ ZZ ZZ', 'email' => 'contact@conserverie-locale.fr'],
        ];
        foreach ($fournisseurs as $data) {
            Fournisseur::create($data);
        }

        // Produits (10)
        $produits = [
            ['famille' => 'Coquillage', 'nom' => 'Huître Creuse', 'mode_tracabilite' => 'etiquette_photo', 'dlc_cuisson_defaut_jours' => 3, 'dlc_congelation_defaut_jours' => 30],
            ['famille' => 'Coquillage', 'nom' => 'Moule', 'mode_tracabilite' => 'etiquette_photo', 'dlc_cuisson_defaut_jours' => 2, 'dlc_congelation_defaut_jours' => 45],
            ['famille' => 'Coquillage', 'nom' => 'Palourde', 'mode_tracabilite' => 'etiquette_photo', 'dlc_cuisson_defaut_jours' => 3, 'dlc_congelation_defaut_jours' => 30],
            ['famille' => 'Crustacé', 'nom' => 'Crevette Royale', 'mode_tracabilite' => 'code_interne', 'dlc_cuisson_defaut_jours' => 4, 'dlc_congelation_defaut_jours' => 60],
            ['famille' => 'Crustacé', 'nom' => 'Langouste', 'mode_tracabilite' => 'etiquette_photo', 'dlc_cuisson_defaut_jours' => 5, 'dlc_congelation_defaut_jours' => 90],
            ['famille' => 'Poisson', 'nom' => 'Saumon', 'mode_tracabilite' => 'etiquette_photo', 'dlc_cuisson_defaut_jours' => 2, 'dlc_congelation_defaut_jours' => 120],
            ['famille' => 'Poisson', 'nom' => 'Dorade', 'mode_tracabilite' => 'code_interne', 'dlc_cuisson_defaut_jours' => 2, 'dlc_congelation_defaut_jours' => 90],
            ['famille' => 'Conserve', 'nom' => 'Anchois à l\'huile', 'mode_tracabilite' => 'code_interne', 'dlc_cuisson_defaut_jours' => null, 'dlc_congelation_defaut_jours' => null],
            ['famille' => 'Conserve', 'nom' => 'Sardines Grillées', 'mode_tracabilite' => 'code_interne', 'dlc_cuisson_defaut_jours' => null, 'dlc_congelation_defaut_jours' => null],
            ['famille' => 'Surgelé', 'nom' => 'Filet de Cabillaud', 'mode_tracabilite' => 'etiquette_photo', 'dlc_cuisson_defaut_jours' => 7, 'dlc_congelation_defaut_jours' => 180],
        ];
        foreach ($produits as $data) {
            Produit::create($data);
        }

        // Équipements température (3)
        $equipements = [
            ['nom' => 'Frigo Arrivage 1', 'actif' => true],
            ['nom' => 'Vitrine Présentation', 'actif' => true],
            ['nom' => 'Congélateur Stockage', 'actif' => true],
        ];
        foreach ($equipements as $data) {
            EquipementTemperature::create($data);
        }

        // Tâches de nettoyage (5)
        $taches = [
            ['nom' => 'Plan de travail', 'actif' => true],
            ['nom' => 'Sol zone dégustation', 'actif' => true],
            ['nom' => 'Éviers et robinetterie', 'actif' => true],
            ['nom' => 'Vitrine réfrigérée', 'actif' => true],
            ['nom' => 'Frigos de stockage', 'actif' => true],
        ];
        foreach ($taches as $data) {
            TacheNettoyage::create($data);
        }
    }
}
