<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FixClientsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-clients-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    // app/Console/Commands/FixClientsCommand.php
    public function handle()
    {
        $users = User::doesntHave('client')->get();

        foreach ($users as $user) {
            $user->client()->create([
                'phone' => null,
                'company_name' => null,
                'tax_id' => null
            ]);
        }

        $this->info("Se crearon {$users->count()} registros de clientes");
    }
}
