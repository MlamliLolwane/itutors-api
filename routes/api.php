<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordResetController;

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
//Route::post('/login', [AuthController::class, "authenticate"]);

//Password reset
Route::post('forgot-password', [PasswordResetController::class, "sendPasswordResetLink"]);
Route::post('reset-password', [PasswordResetController::class, "resetPassword"]);
