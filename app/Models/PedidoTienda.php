<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PedidoTienda extends Model
{
    protected $fillable = [
        'codigo',
        'cliente_nombre',
        'cliente_email',
        'cliente_telefono',
        'notas',
        'estado',
        'total'
    ];
    protected $table = 'pedidos_tienda';

    public function items(): HasMany
    {
        return $this->hasMany(PedidoItemTienda::class);
    }
}
