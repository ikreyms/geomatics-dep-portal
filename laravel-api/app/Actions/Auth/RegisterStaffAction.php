<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\StaffProfile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RegisterStaffAction
{
    public static function run(array $data)
    {
        $profile = null;
        $user = null;

        $userDataFields = ['username', 'email'];

        $userData = Arr::only($data, $userDataFields);
        $profileData = Arr::except($data, $userDataFields);

        $generatedPassword = static::generateRandomPassword();

        $userData['password'] = $generatedPassword;
        $userData['profileable_type'] = StaffProfile::class;

        DB::transaction(function () use (&$profile, &$user, $profileData, $userData) {
            $profile = StaffProfile::create($profileData);

            $user = new User($userData);
            $user->profileable_id = $profile->id;
            $user->save();
        });

        // Mail::to($user->email)->send(new WelcomeUserMail($user->username, $generatedPassword));

        return [$user, $profile];
    }

    private static function generateRandomPassword()
    {
        return bin2hex(random_bytes(10));
    }
}