<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeController;
use App\Http\Controllers\AtollController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\EmailVerificationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function() {
    Route::post('register', RegisterUserController::class)->name('auth.register');
    Route::post('login', [LoginController::class, 'store'])->name('auth.login');

    Route::post('logout', [LoginController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('auth.logout');
});

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('me', MeController::class)->name('me');

    Route::controller(EmailVerificationController::class)->group(function() {
        Route::post('email/verification-notification', 'sendVerificationEmail')
            ->middleware('throttle:6,1')
            ->name('email.verification.notification');
        Route::get('verify-email/{userhashid}/{emailHash}', 'verify')
            ->name('verification.verify');
    });

    Route::apiResource('atolls', AtollController::class);
});
