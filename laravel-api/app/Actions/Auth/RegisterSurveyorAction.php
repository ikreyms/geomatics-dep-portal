<?php

namespace App\Actions\Auth;

use App\Contracts\ControllerAction;
use App\Models\SurveyorProfile;
use App\Services\RegisterUserService;

class RegisterSurveyorAction implements ControllerAction
{
    public function __invoke(array $data)
    {
       return (new RegisterUserService(SurveyorProfile::class))->handle($data);
    }
}
