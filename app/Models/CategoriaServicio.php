<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class CategoriaServicio extends Model
{

    protected $fillable = ['nombre', 'slug', 'descripcion', 'icono'];

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }
}
