<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoTienda extends Model
{
    protected $fillable = [
        'categoria_id',
        'nombre',
        'slug',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'activo'
    ];
    protected $table = 'productos_tienda';


    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaTienda::class);
    }
}
