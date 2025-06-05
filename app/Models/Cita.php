<?php
// app/Models/Cita.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cita extends Model
{
    protected $fillable = [
        'peluquero_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'notas',
        'nombre_cliente',
        'email_cliente',
        'telefono_cliente'
    ];

    public function peluquero(): BelongsTo
    {
        return $this->belongsTo(Peluquero::class);
    }

    public function tratamientos()
    {
        return $this->belongsToMany(Tratamiento::class)->withPivot('cantidad');
    }
}
