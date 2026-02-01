<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nettoyage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tache_nettoyage_id',
        'done_at',
        'commentaire',
        'user_id',
    ];

    protected $casts = [
        'done_at' => 'datetime',
    ];

    public function tache(): BelongsTo
    {
        return $this->belongsTo(TacheNettoyage::class, 'tache_nettoyage_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
