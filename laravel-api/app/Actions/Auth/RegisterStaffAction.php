<?php

namespace App\Actions\Auth;

use App\Contracts\ControllerAction;
use App\Models\StaffProfile;
use App\Services\RegisterUserService;

class RegisterStaffAction implements ControllerAction
{
    public function __invoke(array $data)
    {
        return (new RegisterUserService(StaffProfile::class, $data));
    }
}