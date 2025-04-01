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
