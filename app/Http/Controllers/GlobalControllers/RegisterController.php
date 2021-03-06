<?php

namespace App\Http\Controllers\GlobalControllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\StandardizedResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use StandardizedResponse;


    public function create(Request $request)
    {
        //Valid user input
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:255|confirmed',
            'role' => 'required|string',
        ]);

        //Add user to database
        $user = User::create([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);


        try {
            //Assign the user a role
            switch ($request['role']) {
                case "Tutor":
                    $user->assignRole('Tutor');
                    break;

                case "Admin":
                    $user->assignRole('Admin');
                    break;

                default:
                    $user->assignRole('Student');
            }

            //$user->sendEmailVerificationNotification();

            return $this->successResponse(['message' => 'User created successfully'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            $user->delete();
            throw $th;
            //return $this->feedbackResponse($th, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
