<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\RoleResource;
use App\Actions\Role\StoreRoleAction;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function store(StoreRoleRequest $request)
    {
        return $this->storeModel(
            $request, 
            StoreRoleAction::class, 
            RoleResource::class, 
            'Role'
        );
    }

    public function index()
    {
        return RoleResource::collection(Role::all());
    }
    
    public function show(Role $role)
    {
        return RoleResource::make($role);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        return $this->updateModel($request, $role, 'Role');
    }

    public function destroy(Role $role)
    {
        $systemAdminRoleName = config('permission.system_admin_role_name');

        if ($role->name === $systemAdminRoleName) {
            Log::warning("Attempt to delete {$systemAdminRoleName} role", [
                'user' => Auth::user()->username
            ]);
            return response(null, 403);
        }
        
        return $this->destroyModel($role, 'Role');
    }
}
