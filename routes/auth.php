<?php

use App\Http\Controllers\Auth\{AuthenticatedSessionController, ConfirmablePasswordController, EmailVerificationNotificationController, EmailVerificationPromptController, NewPasswordController, PasswordResetLinkController, RegisteredUserController, VerifyEmailController};
use Illuminate\Support\Facades\Route;

Route::get('auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);

Route::get('/registrar-aluno', [RegisteredUserController::class, 'registrarAluno'])
    ->middleware('auth')
    ->name('registrar-aluno');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('auth');

Route::post('/registrar-aluno', [RegisteredUserController::class, 'store'])
    ->middleware('auth')->name('registrar-aluno');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('auth')
    ->name('password.update');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('auth')
    ->name('reset-password');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
