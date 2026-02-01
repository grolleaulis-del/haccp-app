<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipementTemperature extends Model
{
    use HasFactory;

    protected $table = 'equipements_temperature';
    protected $fillable = ['nom', 'actif', 'temperature_min', 'temperature_max'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function releves(): HasMany
    {
        return $this->hasMany(ReleveTemperature::class);
    }
}
