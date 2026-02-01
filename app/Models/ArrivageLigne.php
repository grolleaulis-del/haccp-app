<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArrivageLigne extends Model
{
    use HasFactory;

    protected $table = 'arrivage_lignes';

    protected $fillable = [
        'arrivage_id',
        'produit_id',
        'numero_lot',
        'photo_path',
        'commentaire',
    ];

    /**
     * L'arrivage parent
     */
    public function arrivage(): BelongsTo
    {
        return $this->belongsTo(Arrivage::class);
    }

    /**
     * Le produit de cette ligne
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
