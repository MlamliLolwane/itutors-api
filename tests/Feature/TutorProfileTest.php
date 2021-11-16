<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TutorProfile;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TutorProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_errors()
    {
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        //Login user 
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        $this->assertAuthenticatedAs(Auth::user());

        //Attempt to update tutor profile
        $response = $this->json(
            "POST",
            "api/tutor/profile/create",
            ['ACCEPT' => 'application/json']
        );

        //dd($response);
        //$response->assertStatus(422);

        $response->assertJsonValidationErrors([
            "tutor_id",
            "first_name",
            "last_name",
            "job_title",
            "description",
        ]);
    }

    public function test_tutor_can_create_profile()
    {
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        //Login user 
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        $this->assertAuthenticatedAs(Auth::user());

        //Attempt to update tutor profile
        $response = $this->json(
            "POST",
            "api/tutor/profile/create",
            [
                "tutor_id" => 1,
                "first_name" => "Mlamli",
                "last_name" => "Lolwane",
                "job_title" => "Software Developer",
                "description" => "Developing software for a big firm",
            ],
            ['ACCEPT' => 'application/json']
        );

        //dd($response);

        $this->assertCount(1, TutorProfile::all());
    }

    public function test_tutor_can_update_profile()
    {
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        //Login user 
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        $this->assertAuthenticatedAs(Auth::user());

        //Create profile for the tutor
        $tutor_profile = TutorProfile::factory()->create();

        //Ensure that the tutor's profile is created
        $this->assertCount(1, TutorProfile::all());

        //Update the tutor's profile
        $response = $this->json(
            "PUT",
            "api/tutor/profile/update",
            [
                "tutor_id" => 1,
                "first_name" => "Mlamli",
                "last_name" => "Lolwane",
                "job_title" => "Software Developer",
                "description" => "Developing software for a big firm",
            ],
            ['ACCEPT' => 'application/json']
        );

        $response->assertJsonFragment(['job_title' => 'Software Developer']);

    }

    public function test_tutor_can_delete_profile()
    {
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        //Login user 
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        $this->assertAuthenticatedAs(Auth::user());

        //Create profile for the tutor
        $tutor_profile = TutorProfile::factory()->create();

        //Ensure that the tutor's profile is created
        $this->assertCount(1, TutorProfile::all());

        //Delete tutor profile
        $response = $this->json(
            "DELETE",
            "api/tutor/profile/delete",
            ["tutor_id" => 1],
            ['ACCEPT' => 'application/json']
        );

        //Assert that the tutor's profile has been soft deleted
        $this->assertSoftDeleted('tutor_profiles');

        //dd($profile);
    }
}
