<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Arrivage extends Model
{
    use HasFactory;

    protected $fillable = [
        'fournisseur_id',
        'date_arrivage',
        'bl_path',
        'commentaire',
    ];

    protected $casts = [
        'date_arrivage' => 'date',
    ];

    /**
     * Le fournisseur de cet arrivage
     */
    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    /**
     * Les lignes de cet arrivage
     */
    public function lignes(): HasMany
    {
        return $this->hasMany(ArrivageLigne::class);
    }
}
