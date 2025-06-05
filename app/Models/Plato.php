<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Plato extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'precio_tapa', 'precio_racion', 'categoria_plato_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaPlato::class, 'categoria_plato_id');
    }
}
