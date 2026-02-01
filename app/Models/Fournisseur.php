<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'telephone',
        'email',
        'commentaire',
    ];

    /**
     * Les arrivages de ce fournisseur
     */
    public function arrivages()
    {
        return $this->hasMany(Arrivage::class);
    }
}
