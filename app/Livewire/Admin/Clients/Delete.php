<?php

namespace App\Livewire\Admin\Clients;

use Livewire\Component;

class Delete extends Component
{
    public function render()
    {
        return view('livewire.admin.clients.delete')->layout('layouts.app');
    }
}
