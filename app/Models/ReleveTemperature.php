<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReleveTemperature extends Model
{
    use HasFactory;

    protected $table = 'releves_temperature';
    protected $fillable = [
        'equipement_temperature_id',
        'temperature',
        'conforme',
        'action_corrective',
        'user_id',
    ];

    protected $casts = [
        'temperature' => 'float',
        'conforme' => 'boolean',
    ];

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(EquipementTemperature::class, 'equipement_temperature_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
