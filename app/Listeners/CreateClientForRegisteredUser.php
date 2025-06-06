<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateClientForRegisteredUser
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
    public function handle(Registered $event)
    {
        // Solo si el usuario no es admin/tecnico (ajusta según tus roles)
        /*if(!$event->user->hasRole(['admin', 'technician'])) {
            $event->user->client()->create([
                'phone' => null,
                'company_name' => null,
                'tax_id' => null
            ]);
        }*/
    }
}
