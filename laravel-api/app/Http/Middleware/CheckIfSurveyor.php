<?php

namespace App\Http\Middleware;

use App\Models\SurveyorProfile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfSurveyor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user->profileable && $user->profileable instanceof SurveyorProfile) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
