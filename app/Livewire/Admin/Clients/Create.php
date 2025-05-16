<?php

namespace App\Livewire\Admin\Clients;

use Livewire\Component;
use App\Models\Client;

class Create extends Component
{
    public $name;
    public $email;
    public $phone;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:clients',
        'phone' => 'nullable|string'
    ];

    public function save()
    {
        $this->validate();

        Client::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('clients.index')
            ->with('success', 'Cliente creado correctamente');
    }

    public function render()
    {
        return view('livewire.admin.clients.create')
            ->layout('layouts.app');
    }
}
