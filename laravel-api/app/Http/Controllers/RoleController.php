<?php

namespace App\Http\Controllers;

use App\Actions\Role\StoreRoleAction;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;

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
        try {
            $role->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
