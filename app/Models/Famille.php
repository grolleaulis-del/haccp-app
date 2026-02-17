<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'emoji',
    ];

    /**
     * Produits appartenant à cette famille
     */
    public function produits()
    {
        return $this->hasMany(Produit::class, 'famille', 'nom');
    }

    /**
     * Nombre de produits dans cette famille
     */
    public function getProduitsCountAttribute()
    {
        return $this->produits()->count();
    }
}
