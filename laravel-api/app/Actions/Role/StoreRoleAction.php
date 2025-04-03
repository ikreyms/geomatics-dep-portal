<?php

namespace App\Actions\Role;

use Spatie\Permission\Models\Role;

class StoreRoleAction
{
    public static function run(array $data)
    {
        $role = Role::create([
            'name' => $data['name'],
        ]);

        return $role;
    }
}