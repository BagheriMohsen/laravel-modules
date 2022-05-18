<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\AuthenticatedSessionController;
use Modules\Auth\Http\Controllers\Api\V1\EmailVerificationNotificationController;
use Modules\Auth\Http\Controllers\Api\V1\NewPasswordController;
use Modules\Auth\Http\Controllers\Api\V1\PasswordResetLinkController;
use Modules\Auth\Http\Controllers\Api\V1\RegisteredUserController;
use Modules\Auth\Http\Controllers\Api\V1\VerifyEmailController;

Route::group(['middleware' => 'guest', 'prefix' => 'auth/v1/', 'as' => 'auth.v1.'], function() {
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.update');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
});
