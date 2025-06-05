<?php
// app/Livewire/Demos/Barberia/Admin/Panel.php
namespace App\Livewire\Demos\Barberia\Admin;

use Livewire\Component;

class Panel extends Component
{
    public function render()
    {
        return view('livewire.demos.barberia.admin.panel')
            ->layout('layouts.demo-barberia');
    }
}
