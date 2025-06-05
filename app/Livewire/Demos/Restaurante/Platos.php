<?php

namespace App\Livewire\Demos\Restaurante;

use Http;
use Livewire\Component;

class Platos extends Component

{
    public $platos;
    protected $pexelsApiKey = 'tHTkM4F1A7doxVR0dhkYE5fi7myKA4uej5jysw2XKGw9olDMdiafhmLQ';

    public function mount($platos)
    {
        $this->platos = $platos;

        foreach ($this->platos as &$plato) {
            $plato->imagen_url = $this->buscarImagenPexels($plato->nombre);
        }
    }

    private function buscarImagenPexels($query)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->pexelsApiKey,
        ])->get('https://api.pexels.com/v1/search', [
            'query' => $query,
            'per_page' => 1,
        ]);

        if ($response->ok()) {
            $json = $response->json();
            if (!empty($json['photos'])) {
                return $json['photos'][0]['src']['medium'];
            }
        }

        return 'https://via.placeholder.com/100?text=Sin+imagen';
    }

    public function render()
    {
        return view('livewire.demos.restaurante.platos');
    }
}
