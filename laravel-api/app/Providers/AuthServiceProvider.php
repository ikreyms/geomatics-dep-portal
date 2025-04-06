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

            // Extract only the path from the verify URL
            $path = parse_url($verifyUrl, PHP_URL_PATH); 
            // This will give us something like /api/verify-email/{user}/{emailHash}

            // Remove the /api part of the path
            $path = Str::replaceFirst('/api', '', $path);

            return $frontEndUrl . '?verify_url=' . urlencode($path);
            // http:://localhost:3000/email/verify?verify_url=verify-email/{user}/{emailHash}
        });
    }
}