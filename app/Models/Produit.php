<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'famille',
        'nom',
        'mode_tracabilite',
        'dlc_cuisson_defaut_jours',
        'dlc_congelation_defaut_jours',
        'actif',
    ];

    /**
     * Récupère le lot actif du produit (il ne peut y en avoir qu'un)
     */
    public function lotActif()
    {
        return $this->hasOne(LotUtilisation::class, 'produit_id')
            ->where('statut', 'actif');
    }

    /**
     * Tous les lots du produit
     */
    public function lots()
    {
        return $this->hasMany(LotUtilisation::class, 'produit_id');
    }
}
