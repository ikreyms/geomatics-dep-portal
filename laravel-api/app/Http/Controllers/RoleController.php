<?php

namespace App\Http\Controllers;

use App\Actions\Role\StoreRoleAction;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    // public function store(StoreRoleRequest $request)
    // {
    //     try {
    //         $data = $request->validated();
    //         $role = StoreRoleAction::run($data);
    //         return RoleResource::make($role);
    //     } catch (\Exception $e) {
    //         $this->logError($e, 'Role creation failed', $data);
    //         return $this->somethingWentWrong();
    //     }
    // }
}
