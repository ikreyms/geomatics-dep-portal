<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginAction
{
    public static function run(array $credentials): string
    {
        $user = User::where('username', $credentials['username'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw new UnauthorizedHttpException('Bearer', __('auth.failed'));
        }

        return $user->createToken('web')->plainTextToken;
    }
}