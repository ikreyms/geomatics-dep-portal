<?php

namespace App\Actions\Auth;

use App\Contracts\ControllerAction;
use App\Models\SurveyorProfile;
use App\Services\RegisterUserService;

class RegisterSurveyorAction implements ControllerAction
{
    public static function handle(array $data)
    {
       return (new RegisterUserService(SurveyorProfile::class))->handle($data);
    }
}
