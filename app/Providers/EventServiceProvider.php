<?php

namespace App\Providers;

use App\Listeners\CreateClientForRegisteredUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateClientForRegisteredUser::class,
            \App\Listeners\SendWelcomeEmail::class,
            \App\Listeners\EnviarCorreoCambioEstado::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
