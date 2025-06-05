<?php

// app/Models/Peluquero.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peluquero extends Model
{
    protected $fillable = ['nombre', 'especialidad', 'foto', 'activo'];

    public function horariosDisponibles(): HasMany
    {
        return $this->hasMany(HorarioDisponible::class);
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }
}
