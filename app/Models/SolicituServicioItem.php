<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudServicioItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'solicitud_servicio_id', 'servicio_id', 'cantidad',
        'precio_unitario', 'opciones_personalizacion', 'notas'
    ];

    protected $casts = [
        'opciones_personalizacion' => 'array'
    ];

    public function solicitud()
    {
        return $this->belongsTo(SolicitudServicio::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->precio_unitario * $this->cantidad;
    }
}
