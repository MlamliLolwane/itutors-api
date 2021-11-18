<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\Tutor\TutorProfileController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\GlobalControllers\LoginController;
use App\Http\Controllers\Tutor\TutorAdvertisementController;
use App\Http\Controllers\GlobalControllers\RegisterController;
use App\Http\Controllers\GlobalControllers\SchoolSubjectController;
use App\Http\Controllers\GlobalControllers\UniversityModuleController;

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
Route::post('/login', [LoginController::class, "authenticate"])->middleware(['verified']);
Route::post('/logoff', [LoginController::class, "logoff"])->middleware(['auth:sanctum', 'verified']);

//Password reset
Route::post('/forgot-password', [PasswordResetController::class, "sendPasswordResetLink"])->middleware(['verified']);;
Route::post('/reset-password', [PasswordResetController::class, "resetPassword"])->middleware(['verified']);;

//Email verification
Route::post('/send-verification-link', [EmailVerificationController::class, "resendEmailVerificationNotification"]);
Route::post('/verify-email/{id}/{hash}', [EmailVerificationController::class, "verifyEmail"])->name('verification.verify');

//School Subjects 
Route::get('/school_subject/show', [SchoolSubjectController::class, "show"]);
Route::post('/school_subject/create', [SchoolSubjectController::class, "store"]);
Route::put('/school_subject/update', [SchoolSubjectController::class, "update"]);
Route::delete('/school_subject/delete', [SchoolSubjectController::class, "destroy"]);

//University Modules
Route::get('/university_module/show', [UniversityModuleController::class, "show"]);
Route::post('/university_module/create', [UniversityModuleController::class, "store"]);
Route::put('/university_module/update', [UniversityModuleController::class, "update"]);
Route::delete('/university_module/delete', [UniversityModuleController::class, "destroy"]);




/**
 * -------------------------------------------------------------------------
 * Tutor Routes
 * -------------------------------------------------------------------------
 */

//Profile routes
Route::middleware(['verified', 'auth:sanctum'])->group(function () {
    Route::get('/tutor/profile/show', [TutorProfileController::class, "show"]);
    Route::post('/tutor/profile/create', [TutorProfileController::class, "store"]);
    Route::put('/tutor/profile/update', [TutorProfileController::class, "update"]);
    Route::delete('/tutor/profile/delete', [TutorProfileController::class, "destroy"]);
});

//Advertisement routes
Route::middleware(['verified', 'auth:sanctum'])->group(function () {
    Route::get('/tutor/advertisement/show', [TutorAdvertisementController::class, "show"]);
    Route::post('/tutor/advertisement/create', [TutorAdvertisementController::class, "store"]);
    Route::put('/tutor/advertisement/update', [TutorAdvertisementController::class, "update"]);
    Route::delete('/tutor/advertisement/delete', [TutorAdvertisementController::class, "destroy"]);
});




/**
 * -------------------------------------------------------------------------
 * Student Routes
 * -------------------------------------------------------------------------
 */

//Profile routes
Route::middleware(['verified', 'auth:sanctum'])->group(function () {
    Route::get('/student/profile/show', [StudentProfileController::class, "show"]);
    Route::post('/student/profile/create', [StudentProfileController::class, "store"]);
    Route::put('/student/profile/update', [StudentProfileController::class, "update"]);
    Route::delete('/student/profile/delete', [StudentProfileController::class, "destroy"]);
});
