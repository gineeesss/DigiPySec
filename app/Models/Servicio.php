<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_servicio_id', 'nombre', 'slug', 'descripcion_corta',
        'descripcion_larga', 'precio_base', 'es_personalizable', 'tiempo_estimado', 'activo'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaServicio::class, 'categoria_servicio_id');
    }

    public function incluyes()
    {
        return $this->hasMany(ServicioIncluye::class, 'servicio_id');
    }

    public function imagenes()
    {
        return $this->hasMany(ServicioImagen::class)->orderBy('orden');
    }

    public function getImagenPrincipalUrlAttribute()
    {
        return $this->imagen_principal
            ? Storage::url($this->imagen_principal)
            : asset('images/default-service.png');
    }
}
