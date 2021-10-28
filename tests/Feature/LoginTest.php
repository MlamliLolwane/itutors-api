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
        $response = $this->json(
            "POST",
            "api/login",
            ['ACCEPT' => 'application/json']
        );

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(["email", "password"]);
    }

    public function test_user_cannot_login_with_invalid_credintials()
    {
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        //Attempt to login with invalid email address
        $this->json(
            "POST",
            "api/login",
            ['email' => 'mrlolwane9@gmail.com', 'password' => 'Mlamli123'],
            ['ACCEPT' => 'application/json']
        );

        $auth = Auth::attempt(['email' => 'mrlolwane9@gmail.com', 'password' => 'Mlamli123']);

        $this->assertEquals(false, $auth);

        //Attempt to login with invalid password
        $auth = Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli1234']);
        $this->assertEquals(false, $auth);
    }

    public function test_user_can_login_successfully()
    {
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
    }
}
