<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaTienda extends Model
{
    protected $fillable = ['nombre', 'slug', 'icono', 'activa'];
    protected $table = 'categorias_tienda';

    public function productos(): HasMany
    {
        return $this->hasMany(ProductoTienda::class);
    }
}
