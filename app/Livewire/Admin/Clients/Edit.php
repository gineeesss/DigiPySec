<?php

namespace App\Livewire\Admin\Clients;

use Livewire\Component;
use App\Models\Client;

class Edit extends Component
{
    public Client $client;
    public $name;
    public $email;
    public $phone;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:clients,email,{client->id}',
        'phone' => 'nullable|string'
    ];

    public function mount(Client $client)
    {
        $this->client = $client;
        $this->fill($client->only('name', 'email', 'phone'));
    }

    public function update()
    {
        $this->validate();

        $this->client->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    public function render()
    {
        return view('livewire.admin.clients.edit')
            ->layout('layouts.app');
    }
}
