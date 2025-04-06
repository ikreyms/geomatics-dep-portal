<?php

namespace App\Actions\Role;

use App\Contracts\ControllerAction;
use Spatie\Permission\Models\Role;

class StoreRoleAction implements ControllerAction
{
    public static function run(array $data)
    {
        $role = Role::create([
            'name' => strtolower($data['name']),
        ]);

        return $role;
    }
}