<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/**
 * -------------------------------------------------------------------------
 * Global Routes
 * -------------------------------------------------------------------------
 */

//Registration & Authentication
Route::post('/signup', [RegisterController::class, "create"]);
Route::post('/login', [LoginController::class, "authenticate"]);

//Password reset
Route::post('/forgot-password', [PasswordResetController::class, "sendPasswordResetLink"]);
Route::post('/reset-password', [PasswordResetController::class, "resetPassword"]);

//Email verification
Route::post('/send-verification-link', [EmailVerificationController::class, "resendEmailVerificationNotification"]);
Route::post('/verify-email/{id}/{hash}', [EmailVerificationController::class, "verifyEmail"])->name('verification.verify');
