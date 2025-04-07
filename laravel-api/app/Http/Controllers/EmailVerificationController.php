<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Mail\EmailVerificationMail;
use Exception;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        try {
            $user = $request->user();

            if ($user->hasVerifiedEmail()) {
                return response()->json([
                    'status' => 'Email already verified'
                ]);
            }

            SendMailJob::dispatch(
                emails: [$user->email],
                mailableClass: EmailVerificationMail::class,
                mailableArgs: [$user],
            );
    
            // $request->user()->sendEmailVerificationNotification();
            return response(null, 200);
        } catch (Exception $e) {
            $this->logError($e, 'Failed to send verification email');
            return $this->somethingWentWrong();
        }
    }

    public function verify(Request $request)
    {
        try {
            if (! URL::hasValidSignature($request)) {
                return response()->json([
                    'status' => 'Invalid verification link or signature. Link maybe expired',
                ]);
            }
    
            if ($request->user()->hasVerifiedEmail()) {
                return response()->json([
                    'status' => 'Email already verified',
                ]);
            }
    
            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request));
            }
    
            return response(null, 200);
        } catch (Exception $e) {
            $this->logError($e, 'Failed to verify email');
            return $this->somethingWentWrong();
        }
    }
}
