<?php

namespace App\Livewire\Admin\Clients;

use App\Models\Client;
use Livewire\WithPagination;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function render()
    {
        return view('livewire.admin.clients.index', [
            'clients' => Client::with('user')
                ->where(function ($query) {
                    $query->whereHas('user', function ($subquery) {
                        $subquery->where('name', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%");
                    })->orWhere('company_name', 'like', "%{$this->search}%");
                })
                ->paginate($this->perPage)
        ])->layout('layouts.app');
    }
    public function delete(Client $client)
    {
        $client->delete();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => '¡Cliente eliminado!'
        ]);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
