<?php

namespace App\Livewire\Admin\Servicio;

use App\Models\CategoriaServicio;
use App\Models\Servicio;
use App\Models\ServicioImagen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServicioEdit extends Component
{
    use WithFileUploads;

    public Servicio $servicio;
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
        'slug' => 'required|string|max:255|unique:servicios,slug,' . ':servicioId',
        'descripcion_corta' => 'required|string|max:500',
        'descripcion_larga' => 'required|string',
        'precio_base' => 'required|numeric|min:0',
        'es_personalizable' => 'boolean',
        'tiempo_estimado' => 'required|integer|min:1',
        'activo' => 'boolean',
        'imagen_principal' => 'nullable|image|max:2048',
        'imagenes.*' => 'nullable|image|max:2048',
    ];

    public function mount(Servicio $servicio)
    {

        $this->servicio = $servicio;
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
        $this->imagenesSubidas = $servicio->imagenes->map(function ($imagen) {
            return [
                'id' => $imagen->id,
                'url' => Storage::disk('public')->url($imagen->imagen_path),
                'name' => basename($imagen->imagen_path)
            ];
        })->toArray();
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
                        'url' => Storage::disk('public')->url($imagen->imagen_path),
                        'name' => basename($imagen->imagen_path)
                    ];
                })->toArray();
        }
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
        ];

        // Actualizar imagen principal si se subió una nueva
        if ($this->imagen_principal) {
            $servicio = Servicio::find($this->servicioId);
            if ($servicio->imagen_principal) {
                Storage::disk('public')->delete($servicio->imagen_principal);
            }
            $servicioData['imagen_principal'] = $this->imagen_principal->store('servicios', 'public');
        }

        // Actualizar el servicio
        $servicio = Servicio::find($this->servicioId);
        $servicio->update($servicioData);

        // Añadir nuevas imágenes
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

        session()->flash('success', 'Servicio actualizado correctamente');
        return redirect()->route('admin.servicios.index');
    }

    public function render()
    {
        return view('livewire.admin.servicios.edit', [
            'categorias' => CategoriaServicio::all(),
            'imagenesSubidas' => $this->imagenesSubidas
        ])->layout('layouts.app');
    }
}
