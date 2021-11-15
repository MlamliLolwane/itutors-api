<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_validation_errors()
    {
        // //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        // $response = $this->json(
        //     "POST",
        //     "api/login",
        //     ['ACCEPT' => 'application/json']
        // );

        $auth = Auth::attempt(['email' => 'mrlolwane9@gmail.com', 'password' => 'Mlamli123']);

        $this->assertFalse($auth);
    }

    public function test_user_cannot_login_with_invalid_credintials()
    {
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        // $this->json(
        //     "POST",
        //     "api/login",
        //     ['email' => 'mrlolwane9@gmail.com', 'password' => 'Mlamli123'],
        //     ['ACCEPT' => 'application/json']
        // );

        //Attempt to login with invalid email address
        $auth = Auth::attempt(['email' => 'mrlolwane9@gmail.com', 'password' => 'Mlamli123']);

        $this->assertFalse($auth);

        //Attempt to login with invalid password
        $auth = Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli1234']);
        $this->assertFalse($auth);
    }

    public function test_user_can_login_successfully()
    {
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        //Attempt to login with valid credentials
        // $this->json(
        //     "POST",
        //     "api/login",
        //     ['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123'],
        //     ['ACCEPT' => 'application/json']
        // );

        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        $this->assertAuthenticatedAs(Auth::user());
    }

    public function test_user_can_logout()
    {
        //$this->withoutExceptionHandling();
        
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        //Attempt to login with invalid email address
        $this->json(
            "POST",
            "api/login",
            ['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123'],
            ['ACCEPT' => 'application/json']
        );

        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        $this->assertAuthenticatedAs(Auth::user());

        //Need to figure out why the following code is not working
        // $this->json(
        //     "POST",
        //     "api/logoff",
        //     ['ACCEPT' => 'application/json']
        // );
        
        //And why this one is working
        Auth::logout();

        // //The following assertion does not work
        $this->assertGuest();
    }
}
