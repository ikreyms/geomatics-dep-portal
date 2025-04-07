<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\IdEncoderService;
use Illuminate\Console\Command;
use Spatie\Activitylog\Facades\CauserResolver;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetupSystemAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup system administrator account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line('Getting all permissions...');
        $this->call('sync:permissions');
        
        $this->line('Creating account...');
        $user = User::where('username', 'sadmin')->orWhere('email', 'sadmin@geomaticsdepartment.mv')->first();
        if ($user) {
            $this->line('System administrator account already setup.');
            return Command::FAILURE;
        }
        $user = User::create([
            'username' => 'sadmin',
            'password' => env('SUPERADMIN_PASSWORD', 'secret'),
            'email' => 'sadmin@geomaticsdepartment.mv',
        ]);
        $user->update([config('hashid.field') => IdEncoderService::encodeHashid($user->id)]);
        $this->line('Account created...');

        CauserResolver::setCauser($user);

        $this->line('Creating system administrator role...');
        $adminRole = Role::findOrCreate(config('permission.system_admin_role_name'));
        $adminRoleName = $adminRole->name;
        $this->info('Role created: ' . $adminRoleName . '.');

        $this->line("Granting all permissions to {$adminRoleName} role...");
        $adminRole->givePermissionTo(Permission::all());
        $this->info('All permissions granted.');

        $this->line("Assigning {$adminRoleName} role to {$user->name}...");
        $user->assignRole($adminRole);

        $this->info("System administrator account setup successfully.");
        return Command::SUCCESS;
    }
}