<?php

namespace App\Http\Controllers\GlobalControllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use StandardizedResponse;

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6']
        ]);

        //Retrieve only the email and password from the request
        $credentials = $request->only('email', 'password');

        // //Authenticate the user and check what their role is and return the profile of the user
        if (Auth::attempt($credentials)) {
            switch (Auth::user()->roles->pluck('name')[0]) {
                case 'Tutor':
                    $user = User::with('TutorProfile')->get();
                    break;
                case 'Student':
                    $user = User::with('StudentProfile')->get();
                    break;
                default:
                    return $this->failureResponse(
                        ["message" => "An error occured on our side and we are attending to it. 
                        Please try again later."],
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
            }
            return $this->successResponse(
                ['profile' => $user, 'role' => Auth::user()->roles->pluck('name')[0]],
                Response::HTTP_OK
            );
        }

        return $this->failureResponse(
            ["message" => "Invalid email address or password entered. Please try again."],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function logoff()
    {
        Auth::logout();
        //Auth::guard('web')->logout();
    }
}
