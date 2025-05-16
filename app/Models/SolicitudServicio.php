<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class SolicitudServicio extends Model
{

    protected $fillable = [
        'cliente_id', 'user_id', 'estado', 'total', 'notas',
        'fecha_aprobacion', 'fecha_completacion'
    ];

    protected $casts = [
        'fecha_aprobacion' => 'datetime',
        'fecha_completacion' => 'datetime'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(SolicitudServicioItem::class);
    }

    public function calcularTotal()
    {
        return $this->items->sum(function ($item) {
            return $item->precio_unitario * $item->cantidad;
        });
    }

    public function actualizarEstado($nuevoEstado)
    {
        $this->estado = $nuevoEstado;

        if ($nuevoEstado === 'aprobada' && !$this->fecha_aprobacion) {
            $this->fecha_aprobacion = now();
        }

        if ($nuevoEstado === 'completada' && !$this->fecha_completacion) {
            $this->fecha_completacion = now();
        }

        $this->save();
    }
}
