<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TacheNettoyage extends Model
{
    use HasFactory;
    protected $table = 'taches_nettoyage';

    protected $fillable = [
        'nom',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function nettoyages()
    {
        return $this->hasMany(Nettoyage::class);
    }
}
