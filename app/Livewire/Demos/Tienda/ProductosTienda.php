<?php

namespace App\Livewire\Demos\Tienda;

use App\Models\ProductoTienda;
use Livewire\Component;

class ProductosTienda extends Component
{
    public $categoriaSlug;

    public function mount($categoriaSlug = null)
    {
        $this->categoriaSlug = $categoriaSlug;
    }
    /*public function añadirAlCarrito($productoId)
    {
        $this->dispatch('productoAñadido', productoId: $productoId)->to(CarritoTienda::class);
        $this->dispatch('productoAñadido')->to(CarritoIcono::class);
    }*/
// app/Livewire/Demos/Tienda/ProductosTienda.php
    public function añadirAlCarrito($productoId)
    {
        try {
            $producto = ProductoTienda::findOrFail($productoId);

            $carrito = session()->get('carrito', []);

            if (isset($carrito[$productoId])) {
                $carrito[$productoId]['cantidad']++;
            } else {
                $carrito[$productoId] = [
                    'producto' => $producto,
                    'cantidad' => 1,
                    'precio' => $producto->precio
                ];
            }

            session()->put('carrito', $carrito);


            $this->js('window.dispatchEvent(new CustomEvent("carrito-actualizado"))');

        } catch (\Exception $e) {
            $this->dispatch('error', message: 'No se pudo añadir el producto');
        }
    } function render()
    {
        $productos = ProductoTienda::where('activo', true)
            ->when($this->categoriaSlug, function($query) {
                $query->whereHas('categoria', function($q) {
                    $q->where('slug', $this->categoriaSlug);
                });
            })
            ->with('categoria')
            ->get();

        return view('livewire.demos.tienda.productos-tienda', [
            'productos' => $productos
        ])->layout('layouts.demo-tienda');
    }
}
