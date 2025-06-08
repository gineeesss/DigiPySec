<?php

namespace App\Livewire\Admin\Clients;

use App\Models\User;
use Livewire\Component;
use App\Models\Client;

class Edit extends Component
{
    public Client $client;
    public User $user;
    public $phone;

    protected $rules = [
        'user.name' => 'required|min:3',
        'user.email' => 'required|email|unique:users,email,{user->id}',
        'phone' => 'nullable|string'
    ];

    public function mount(Client $client)
    {
        $this->client = $client;
        $this->user = $client->user ?? new User(); // Si no tiene usuario, crea uno vacío
        $this->phone = $client->phone;
    }

    public function update()
    {
        $this->validate();

        $this->user->save();

        $this->client->update([
            'phone' => $this->phone
        ]);
        $this->emit('refreshComponent');
        return redirect()->route('admin.clients.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    public function render()
    {
        return view('livewire.admin.clients.edit')
            ->layout('layouts.app');
    }
}
