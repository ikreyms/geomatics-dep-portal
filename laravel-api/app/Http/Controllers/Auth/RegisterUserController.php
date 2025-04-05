<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Models\StaffProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterStaffRequest;

class RegisterUserController extends Controller
{
    public function registerStaff(RegisterStaffRequest $request)
    {
        $data = $request->validated();

        $userDataFields = ['username', 'email'];
        $profileDataFields = array_diff_key($data, array_flip($userDataFields));

        $profileData = array_intersect_key($data, $profileDataFields);
        $profile = StaffProfile::create($profileData);

        $userData = array_intersect_key($data, $userDataFields);
        $user = User::create($userData);
        $user->update([
            'profile_type' => StaffProfile::class,
            'profile_id' => $profile->id,
        ]);
        return response(null, 200);
    }
}
