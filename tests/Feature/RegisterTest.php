<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
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
            "api/signup",
            ['ACCEPT' => 'application/json']
        );

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(["email", "password", "role"]);
    }

    public function test_users_can_register()
    {
        //$this->withoutExceptionHandling();

        Role::create(["name" => "Tutor"]);
        
        $response = $this->json(
            "POST",
            "api/signup",
            $this->user_data(),
            ['ACCEPT' => 'application/json']
        );

        $this->assertCount(1, User::all());
    }

    private function user_data()
    {
        $user_data = [
            "email" => "mrlolwane96@gmail.com",
            "password" => "Mlamli123",
            "password_confirmation" => "Mlamli123",
            "role" => "Tutor"
        ];

        return $user_data;
    }
}
