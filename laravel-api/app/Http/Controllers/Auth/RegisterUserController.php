<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\Auth\RegisterUserRequest;
use Exception;

class RegisterUserController extends Controller
{
    public function __invoke(RegisterUserRequest $request)
    {

        // no typical registeruser functionality in this portal.
        // users are to be created:
        // - Staff users can only be created by System Administrator.
        // - Surveyor users can be created by System Administrator and staff users with relevant permissions.


        try {
            $data = $request->validated();
            $user = RegisterUserAction::run($data);
            return UserResource::make($user);
        } catch (Exception $e) {
            $this->logError($e, 'User registration failed', $data);
            return $this->somethingWentWrong();
        }
    }
}
