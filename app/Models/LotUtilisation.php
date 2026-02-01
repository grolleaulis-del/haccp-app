<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LotUtilisation extends Model
{
    use HasFactory;

    protected $table = 'lots_utilisation';

    protected $fillable = [
        'produit_id',
        'arrivage_ligne_id',
        'statut',
        'started_at',
        'ended_at',
        'photo_path',
        'photo_etiquette',
        'code_interne',
        'commentaire',
        'user_id',
        'type_operation',
        'quantite',
        'date_production',
        'dlc',
        'temperature_cuisson',
        'temperature_refroidissement',
        'observations',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'date_production' => 'datetime',
        'dlc' => 'datetime',
    ];

    /**
     * Le produit de ce lot
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * L'utilisateur qui a créé/modifié ce lot
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * La ligne d'arrivage optionnelle
     */
    public function arrivageLigne(): BelongsTo
    {
        return $this->belongsTo(ArrivageLigne::class, 'arrivage_ligne_id');
    }
}
