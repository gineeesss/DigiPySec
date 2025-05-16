<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\NewMessage;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public string $message = '';
    public $messages = []; // Cambiado a propiedad pública estándar

    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::latest()
            ->take(10)
            ->pluck('content')
            ->toArray();
    }

    public function sendMessage()
    {
        // Validar mensaje no vacío
        if (empty(trim($this->message))) return;

        // Crear mensaje en BD
        $newMessage = Message::create([
            'user_id' => Auth::id(),
            'content' => Auth::user()->name . ': ' . $this->message
        ]);

        // Transmitir a otros
        broadcast(new NewMessage($newMessage->content))->toOthers();

        // Actualizar lista local
        $this->messages[] = $newMessage->content;
        $this->reset('message');
    }

    protected $listeners = ['echo:chat,message.sent' => 'handleBroadcastMessage'];
    public function handleBroadcastMessage(array $payload)
    {
        $this->messages[] = $payload['message'];
        $this->dispatch('scroll-down');
    }

    #On['message.sent' => 'loadMessages']
    public function render()
    {
        return view('livewire.chat')->layout('layouts.app');
    }
}
