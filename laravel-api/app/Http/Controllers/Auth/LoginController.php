<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\Request;
use App\Actions\Auth\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            $token = new LoginAction($credentials);
    
            $cookie = cookie(
                name: config('site.cookie_name'),
                value: $token,
                minutes: time() + 60 * 60 * 24 * 60, // 60 days valid
            );
    
            return response()
                ->json(['token' => $token, 'tokenType' => 'Bearer'])
                ->cookie($cookie);
        } catch (UnauthorizedHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        } catch (Exception $e) {
            $this->logError($e, 'Login failed', $credentials);
            return $this->somethingWentWrong();
        }
    }

    public function destroy(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(null, 204)
                ->withoutCookie(config('site.cookie_name'));
        } catch (Exception $e) {
            $this->logError($e, 'Logout failed');
            return $this->somethingWentWrong();
        }
    }
}
