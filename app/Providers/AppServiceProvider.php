<?php

namespace App\Providers;

use App\Events\ClientUpdated;
use App\Events\UserCreated;
use App\Listeners\CreateClientForUser;
use App\Listeners\SyncClientEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-servicios', function ($user) {
            return $user->hasRole('admin');
        });
    }

    // app/Providers/EventServiceProvider.php

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            CreateClientForUser::class,
        ],
        ClientUpdated::class => [
            SyncClientEmail::class,
        ],
    ];
}
