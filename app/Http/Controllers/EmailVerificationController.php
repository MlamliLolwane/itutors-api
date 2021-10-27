<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\StandardizedResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    use StandardizedResponse;

    public function resendEmailVerificationNotification(Request $request)
    {
        //Get user from database and check if they have verified their email

        $user = User::where('email', '=', $request->email)->firstOrFail();

        if ($user->email_verified_at == null) {
            $user->sendEmailVerificationNotification();

            return $this->successResponse("Verification link sent", Response::HTTP_OK);
        }

        return $this->successResponse("Email already verified", Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function verifyEmail(Request $request)
    {
        //Need to figure out if the user has already verified their email without them logging in.

        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return $this->successResponse(
                "Email address already verified",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->successResponse("Eamil verified", Response::HTTP_OK);
    }
}
