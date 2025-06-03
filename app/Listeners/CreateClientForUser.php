<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateClientForUser
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
    public function handle(UserCreated $event)
    {
        // Solo crear cliente para usuarios normales
        if ($event->user->hasRole('user')) {
            $event->user->client()->create([
                'phone' => null,
                'company_name' => null,
                'tax_id' => null
            ]);
        }
    }
}
