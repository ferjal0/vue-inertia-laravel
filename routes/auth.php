<?php

use App\Http\Controllers\Auth\ConfirmablePasswordController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return Inertia::render('Auth/Register', [
            'isRegisterEnabled' => Features::enabled(Features::registration()),
        ]);
    })->name('register');

    Route::get('/login', function () {
        return Inertia::render('Auth/Login', [
            'isRegisterEnabled' => Features::enabled(Features::registration()),
        ]);
    })->name('login');

    Route::get('/login/challenge', function () {
        return Inertia::render('Auth/TwoFactorChallenge');
    })->name('two-factor.login');

    Route::get('/forgot-password', function () {
        return Inertia::render('Auth/ForgotPassword');
    })->name('auth.forgot-password');

    Route::get('/reset-password/{token}', function (string $token) {
        return Inertia::render('Auth/PasswordReset', [
            'token' => $token,
            'email' => request('email'),
        ]);
    })->name('password.reset');

    Route::get('/forgot-password/sent', function () {
        return Inertia::render('Auth/ForgotPasswordSent');
    })->name('forgot-password.sent');
});

Route::middleware('auth')->group(function () {
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])->name('password.confirm');

    Route::get('/verify-email', function () {
        return Inertia::render('Auth/VerifyEmail');
    })->name('verification.notice');
});
