<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioImagen extends Model
{
    use HasFactory;

    protected $fillable = ['servicio_id', 'imagen_path', 'orden'];

    public function getImagenUrlAttribute()
    {
        return Storage::url($this->imagen_path);
    }
}
