<?php

namespace App\Livewire\Admin;

use http\Client;
use Livewire\Component;

class Dashboard extends Component
{
    public $clientCount;

    public function mount() {
        $this->clientCount = Client::count();
    }

    public function render() {
        return view('livewire.admin.dashboard');
    }
}
