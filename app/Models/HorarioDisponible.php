<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioDisponible extends Model
{
    protected $fillable = ['peluquero_id', 'dia_semana', 'hora_inicio', 'hora_fin', 'activo'];

    public function peluquero(): BelongsTo
    {
        return $this->belongsTo(Peluquero::class);
    }
}
