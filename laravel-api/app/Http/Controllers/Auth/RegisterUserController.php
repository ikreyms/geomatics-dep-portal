<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Actions\Auth\RegisterStaffAction;
use App\Actions\Auth\RegisterSurveyorAction;
use App\Http\Resources\StaffProfileResource;
use App\Http\Resources\SurveyorProfileResource;
use App\Http\Requests\Auth\RegisterStaffRequest;
use App\Http\Requests\Auth\RegisterSurveyorRequest;

class RegisterUserController extends Controller
{
    public function registerStaff(RegisterStaffRequest $request)
    {
        try {
            $data = $request->validated();
            [$user, $profile] = new RegisterStaffAction($data);
            return response()->json([
                'user' => UserResource::make($user),
                'profile' => StaffProfileResource::make($profile),
            ]);
        } catch (Exception $e) {
            $this->logError($e, "Staff registration failed", $data ?? null);
            return $this->somethingWentWrong();
        }
    }

    public function registerSurveyor(RegisterSurveyorRequest $request)
    {
        try {
            $data = $request->validated();
            [$user, $profile] = new RegisterSurveyorAction($data);
            return response()->json([
                'user' => UserResource::make($user),
                'profile' => SurveyorProfileResource::make($profile),
            ]);
        } catch (Exception $e) {
            $this->logError($e, "Surveyor registration failed", $data ?? null);
            return $this->somethingWentWrong();
        }
    }
}
