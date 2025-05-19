<?php

namespace App\Livewire\Admin;

use App\Models\CategoriaServicio;
use App\Models\Servicio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

// app/Http/Livewire/Admin/ServicioForm.php
class ServicioForm extends Component
{
    public $servicioId;
    public $categoria_servicio_id;
    public $nombre;
    public $slug;
    public $descripcion_corta;
    public $descripcion_larga;
    public $precio_base;
    public $es_personalizable = false;
    public $tiempo_estimado;
    public $activo = true;
    public $caracteristicas = [];
    public $nuevaCaracteristica = '';
    public $imagen_principal;
    public $imagenes = [];
    public $imagenesSubidas = [];
    public $imagenesAEliminar = [];
    protected $rules = [
        'categoria_servicio_id' => 'required|exists:categoria_servicios,id',
        'nombre' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:servicios,slug',
        'descripcion_corta' => 'required|string|max:500',
        'descripcion_larga' => 'required|string',
        'precio_base' => 'required|numeric|min:0',
        'es_personalizable' => 'boolean',
        'tiempo_estimado' => 'required|integer|min:1',
        'activo' => 'boolean',
        'imagen_principal' => 'nullable|image|max:2048',
        'imagenes.*' => 'nullable|image|max:2048',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $servicio = Servicio::with('incluyes')->findOrFail($id);
            $this->servicioId = $servicio->id;
            $this->categoria_servicio_id = $servicio->categoria_servicio_id;
            $this->nombre = $servicio->nombre;
            $this->slug = $servicio->slug;
            $this->descripcion_corta = $servicio->descripcion_corta;
            $this->descripcion_larga = $servicio->descripcion_larga;
            $this->precio_base = $servicio->precio_base;
            $this->es_personalizable = $servicio->es_personalizable;
            $this->tiempo_estimado = $servicio->tiempo_estimado;
            $this->activo = $servicio->activo;
            $this->caracteristicas = $servicio->incluyes->pluck('caracteristica')->toArray();
        }
    }

    public function updatedNombre($value)
    {
        $this->slug = Str::slug($value);
    }

    public function addCaracteristica()
    {
        if (!empty($this->nuevaCaracteristica)) {
            $this->caracteristicas[] = $this->nuevaCaracteristica;
            $this->nuevaCaracteristica = '';
        }
    }

    public function removeCaracteristica($index)
    {
        unset($this->caracteristicas[$index]);
        $this->caracteristicas = array_values($this->caracteristicas);
    }

    public function save()
    {
        $this->validate();

        $servicioData = [
            'categoria_servicio_id' => $this->categoria_servicio_id,
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            'descripcion_corta' => $this->descripcion_corta,
            'descripcion_larga' => $this->descripcion_larga,
            'precio_base' => $this->precio_base,
            'es_personalizable' => $this->es_personalizable,
            'tiempo_estimado' => $this->tiempo_estimado,
            'activo' => $this->activo,
            'imagen_principal' => $this->imagen_principal ? $this->imagen_principal->store('servicios', 'public') : null,
        ];

        if ($this->servicioId) {
            $servicio = Servicio::find($this->servicioId);
            if ($this->imagen_principal && $servicio->imagen_principal) {
                Storage::disk('public')->delete($servicio->imagen_principal);
            }
            $servicio->update($servicioData);
        } else {
            $servicio = Servicio::create($servicioData);
            $this->servicioId = $servicio->id;
        }

        foreach ($this->imagenes as $imagen) {
            $path = $imagen->store('servicios', 'public');
            $servicio->imagenes()->create(['imagen_path' => $path]);
        }

        // Eliminar imágenes marcadas para eliminación
        if (!empty($this->imagenesAEliminar)) {
            $imagenesAEliminar = $servicio->imagenes()->whereIn('id', $this->imagenesAEliminar)->get();

            foreach ($imagenesAEliminar as $imagen) {
                Storage::disk('public')->delete($imagen->imagen_path);
                $imagen->delete();
            }
        }
        // Sincronizar características
        $servicio->incluyes()->delete();
        foreach ($this->caracteristicas as $caracteristica) {
            $servicio->incluyes()->create(['caracteristica' => $caracteristica]);
        }

        session()->flash('message', 'Servicio guardado correctamente');
        return redirect()->route('admin.servicios.index');
    }


    public function removeImagen($index)
    {
        if (isset($this->imagenesSubidas[$index]['id'])) {
            $this->imagenesAEliminar[] = $this->imagenesSubidas[$index]['id'];
        }
        unset($this->imagenesSubidas[$index]);
        $this->imagenesSubidas = array_values($this->imagenesSubidas);
    }

    public function reorderImagenes($orderedIds)
    {
        foreach ($orderedIds as $order => $id) {
            $imagen = ServicioImagen::find($id);
            if ($imagen) {
                $imagen->update(['orden' => $order]);
            }
        }
        $this->loadImagenes();
    }

    protected function loadImagenes()
    {
        if ($this->servicioId) {
            $this->imagenesSubidas = Servicio::find($this->servicioId)
                ->imagenes()
                ->orderBy('orden')
                ->get()
                ->map(function ($imagen) {
                    return [
                        'id' => $imagen->id,
                        'url' => $imagen->imagen_url,
                        'name' => basename($imagen->imagen_path)
                    ];
                })->toArray();
        }
    }

    public function render()
    {
        $this->loadImagenes();
        return view('livewire.admin.servicio-form', [
            'categorias' => CategoriaServicio::all(),
            'imagenesSubidas' => $this->imagenesSubidas
        ])->layout('layouts.app');
    }
}
