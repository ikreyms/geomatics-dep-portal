<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permissions to permissions table using route names';

    public function handle()
    {
        $existingPermissions = Permission::pluck('name')->toArray();

        $routes = collect(Route::getRoutes());
        $newPermissions = [];

        $routes->each(function ($route) use (&$existingPermissions, &$newPermissions) {
            $permissionName = $route->getName();

            if ($permissionName && ! in_array($permissionName, $existingPermissions)) {
                $newPermissions[] = [
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ];
            }
        });

        if (! empty($newPermissions)) {
            Permission::insert($newPermissions);
            $this->info(count($newPermissions) . " new permissions added.");
        } else {
            $this->info("No new permissions to add.");
        }

        $this->info('Permissions sync completed successfully.');
    }
}
