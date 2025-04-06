<?php

namespace App\Actions\Auth;

use App\Contracts\ControllerAction;
use App\Models\StaffProfile;
use App\Services\RegisterUserService;

class RegisterStaffAction implements ControllerAction
{
    public static function handle(array $data)
    {
        return (new RegisterUserService(StaffProfile::class))->handle($data);
    }
}