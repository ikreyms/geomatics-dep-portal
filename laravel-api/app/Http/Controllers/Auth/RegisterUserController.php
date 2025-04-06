<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterStaffAction;
use Exception;
use App\Models\User;
use App\Models\StaffProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterStaffRequest;
use App\Http\Resources\StaffProfileResource;
use App\Http\Resources\UserResource;

class RegisterUserController extends Controller
{
    public function registerStaff(RegisterStaffRequest $request)
    {
        $data = $request->validated();
        [$user, $profile] = RegisterStaffAction::run($data);
        return response()->json([
            'user' => UserResource::make($user),
            'profile' => StaffProfileResource::make($profile),
        ]);
    }
}
