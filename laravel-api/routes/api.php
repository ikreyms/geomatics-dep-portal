<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AtollController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IslandCategoryController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\IslandController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication Routes (Login, Logout, and Registration)
Route::group(['prefix' => 'auth'], function () {
    // Login & Logout Routes
    Route::post('login', [LoginController::class, 'store'])->name('auth.login');
    Route::post('logout', [LoginController::class, 'destroy'])->name('auth.logout')
        ->middleware(['auth:sanctum']);

    // Registration Routes
    Route::controller(RegisterUserController::class)->middleware(['auth:sanctum'])->group(function () {
        Route::post('register-staff', 'registerStaff')->name('auth.register.staff');
        Route::post('register-surveyor', 'registerSurveyor')->name('auth.register.surveyor');
    });
});

// Email Verification Routes (With Throttling)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(EmailVerificationController::class)->group(function () {
        Route::post('email/verification-notification', 'sendVerificationEmail')
            ->middleware('throttle:6,1') // Throttle to limit requests to 6 per minute
            ->name('email.verification.notification');
        Route::get('verify-email/{userhashid}/{emailHash}', 'verify')
            ->name('verification.verify');
    });
});

// Authenticated User Routes (Protected by Sanctum Middleware)
Route::middleware(['auth:sanctum'])->group(function () {
    // Resource Routes
    Route::apiResource('atolls', AtollController::class);
    Route::apiResource('island-categories', IslandCategoryController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('islands', IslandController::class);
});
