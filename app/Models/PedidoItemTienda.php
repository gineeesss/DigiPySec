<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoItemTienda extends Model
{
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario'
    ];
    protected $table = 'pedido_items_tienda';

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(PedidoTienda::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(ProductoTienda::class);
    }
}
