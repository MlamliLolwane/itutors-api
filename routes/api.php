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
use App\Http\Controllers\GlobalControllers\TutoringRequestController;
use App\Http\Controllers\GlobalControllers\UniversityModuleController;
use App\Http\Controllers\Student\StudentQueries;
use App\Http\Controllers\Student\StudentQueriesController;
use App\Http\Controllers\Tutor\TutorScheduleController;

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
Route::post('/logoff', [LoginController::class, "logoff"])->middleware(['auth:sanctum']);

//Password reset
Route::post('/forgot-password', [PasswordResetController::class, "sendPasswordResetLink"])->middleware(['verified']);;
Route::post('/reset-password', [PasswordResetController::class, "resetPassword"])->middleware(['verified']);;

//Email verification
Route::post('/send-verification-link', [EmailVerificationController::class, "resendEmailVerificationNotification"]);
Route::post('/verify-email/{id}/{hash}', [EmailVerificationController::class, "verifyEmail"])->name('verification.verify');

//School Subjects 
Route::get('/school_subject/list', [SchoolSubjectController::class, "index"]);
Route::post('/school_subject/create', [SchoolSubjectController::class, "store"]);
Route::put('/school_subject/update', [SchoolSubjectController::class, "update"]);
Route::delete('/school_subject/delete', [SchoolSubjectController::class, "destroy"]);

//University Modules
Route::get('/university_module/show', [UniversityModuleController::class, "show"]);
Route::post('/university_module/create', [UniversityModuleController::class, "store"]);
Route::put('/university_module/update', [UniversityModuleController::class, "update"]);
Route::delete('/university_module/delete', [UniversityModuleController::class, "destroy"]);

//Tutoring requests
Route::get('/tutoring_request/show', [TutoringRequestController::class, "show"]);
//Route::delete('/tutoring_request/delete', [TutoringRequestController::class, "destroy"]);




/**
 * -------------------------------------------------------------------------
 * Tutor Routes
 * -------------------------------------------------------------------------
 */

//Profile routes
//Should remember to add 'verified' middleware
Route::middleware(['auth:sanctum', 'role:Tutor'])->group(function () {
    Route::get('/tutor/profile/show/{tutor_id}', [TutorProfileController::class, "show"]);
    Route::post('/tutor/profile/create', [TutorProfileController::class, "store"]);
    Route::put('/tutor/profile/update', [TutorProfileController::class, "update"]);
    Route::delete('/tutor/profile/delete', [TutorProfileController::class, "destroy"]);

    //Advertisement Routes
    Route::get('/tutor/advertisement/list/{tutor_id}', [TutorAdvertisementController::class, "list"]);
    Route::get('/tutor/advertisement/show', [TutorAdvertisementController::class, "show"]);
    Route::post('/tutor/advertisement/create', [TutorAdvertisementController::class, "store"]);
    Route::put('/tutor/advertisement/update', [TutorAdvertisementController::class, "update"]);
    Route::delete('/tutor/advertisement/delete', [TutorAdvertisementController::class, "destroy"]);

    //Tutoring Requests
    Route::get('/tutoring_request/list', [TutoringRequestController::class, "turor_list_tutoring_requests"]);
    Route::put('/tutoring_request/accept', [TutoringRequestController::class, "tutor_accept_request"]);
    Route::put('/tutoring_request/reject', [TutoringRequestController::class, "tutor_reject_request"]);

    //Tutor Schedule Routes
    Route::get('/tutor/schedule/list/{tutor_id}', [TutorScheduleController::class, "index"]);
    Route::post('/tutor/schedule/create', [TutorScheduleController::class, "store"]);
    Route::put('/tutor/schedule/update/{id}', [TutorScheduleController::class, 'update']);
    Route::delete('/tutor/schedule/delete', [TutorScheduleController::class, 'destroy']);
});




/**
 * -------------------------------------------------------------------------
 * Student Routes
 * -------------------------------------------------------------------------
 */

 //Should remember to add 'verified' middleware
Route::middleware(['auth:sanctum', 'role:Student'])->group(function () {
    //Profile routes
    Route::get('/student/profile/show', [StudentProfileController::class, "show"]);
    Route::post('/student/profile/create', [StudentProfileController::class, "store"]);
    Route::put('/student/profile/update', [StudentProfileController::class, "update"]);
    Route::delete('/student/profile/delete', [StudentProfileController::class, "destroy"]);

    //Tutoring Requests routes
    Route::get('/tutoring_request/list_student_tutoring_request', [TutoringRequestController::class, "student_list_tutoring_requests"]);
    Route::post('/tutoring_request/create', [TutoringRequestController::class, "store"]);
    Route::put('/tutoring_request/cancel', [TutoringRequestController::class, "student_cancel_request"]);
});

//Queries
Route::get('/query/tutor_advertisement', [StudentQueriesController::class, "find_tutor"]);

// Route::middleware(['verified', 'auth:sanctum'])->group(function () {
    
// });
