<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(public string $message) {}

    public function broadcastOn()
    {
        return [
            new Channel('chat')
        ];
    }

    public function broadcastAs()
    {
        return 'message.sent'; // Antes era 'NewMessage'
    }
    public function broadcastWith()
    {
        return [
            'message' => $this->message // Asegura que el payload tenga estructura clara
        ];
    }
}
