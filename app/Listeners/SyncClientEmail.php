<?php

namespace App\Listeners;

use App\Events\ClientUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncClientEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClientUpdated $event)
    {
        // Sincronizar email con el usuario
        if ($event->client->user->email !== $event->client->email) {
            $event->client->user->update(['email' => $event->client->email]);
        }
    }
}
