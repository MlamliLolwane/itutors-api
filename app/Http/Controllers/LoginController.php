<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        // //Authenticate the user
        if (Auth::attempt($credentials)) {
            return $this->successResponse(Auth::user(), Response::HTTP_OK);
        }

        return $this->failureResponse(["message" => "Invalid email address or password entered. Please try again."], 
        Response::HTTP_UNAUTHORIZED);
    }
}
