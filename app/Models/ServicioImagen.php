<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;
use Illuminate\Support\Facades\Storage;

class ServicioImagen extends Model
{
    protected $table = "servicio_imagenes";
    protected $fillable = ['servicio_id', 'imagen_path', 'orden'];

    public function getImagenUrlAttribute()
    {
        return Storage::url($this->imagen_path);
    }

}
