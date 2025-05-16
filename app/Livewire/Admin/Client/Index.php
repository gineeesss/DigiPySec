<?php

namespace App\Livewire\Admin\Client;

use http\Client;
use Livewire\Component;

class Index extends Component
{
    public $clients;

    public function mount() {
        $this->clients = Client::all();
    }

    public function render() {
        return view('livewire.admin.client.index');
    }
}
