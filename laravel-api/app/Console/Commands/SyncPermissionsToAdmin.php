<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class SyncPermissionsToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:admin-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grants any permissions not granted to system administrator';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminUser = User::role('System Administrator')->first();

        if (! $adminUser) {
            $this->line('Unable to find System administrator account.');
            return Command::FAILURE;
        }

        $role = $adminUser->roles->first();
        
        $this->line("Granting all permissions to {$role->name}...");
        $role->givePermissionTo(Permission::all());

        $this->info('All permissions granted.');
        return Command::SUCCESS;
    }
}
