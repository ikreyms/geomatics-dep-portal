<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        VerifyEmail::createUrlUsing(function(User $user) {
            $frontEndUrl = config('app.client_url') . '/email/verify';
            // http:://localhost:3000/email/verify

            $baseUrl = config('app.url');
            // http://localhost:8000

            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                [
                    'userhashid' => $user->hashid,
                    'emailHash' => sha1($user->getEmailForVerification()),
                ]
            );
            // http://localhost:8000/api/verify-email/{user}/{emailHash}

            return $frontEndUrl . '?verify_url=' . urlencode(Str::of($verifyUrl)->replace($baseUrl . '/api', ''));
            // http:://localhost:3000/email/verify?verify_url=verify-email/{user}/{emailHash}
        });
    }
}