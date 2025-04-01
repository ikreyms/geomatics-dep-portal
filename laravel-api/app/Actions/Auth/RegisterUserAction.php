<?php

namespace App\Actions\Auth;

use App\Data\Auth\RegisterUserData;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public static function run(array $data): User
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        event(new Registered($user));
        return $user;
    }
}
