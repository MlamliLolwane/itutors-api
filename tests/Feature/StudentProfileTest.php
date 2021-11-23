<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\StudentProfile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_errors()
    {
        //Signup and login student
        $this->initialize_student_details();

        //Attempt to update tutor profile
        $response = $this->json(
            "POST",
            "api/student/profile/create",
            ['ACCEPT' => 'application/json']
        );

        //dd($response);
        //$response->assertStatus(422);

        $response->assertJsonValidationErrors([
            "student_id",
            "first_name",
            "last_name",
            "study_level",
            "description",
        ]);
    }

    public function student_profile_can_be_retrieved_from_database()
    {
       //Signup and login student
       $this->initialize_student_details();

       //Create profile for the tutor
       $student_profile = StudentProfile::factory()->create();

        //Get all student profile from database
        $response = $this->json(
            "GET",
            "api/student/profile/show",
            ['student_id' => 1],
            ['ACCEPT' => 'application/json']
        );

        $response->assertSee(['Mlamli', 'Lolwane']);
    }

    public function test_student_can_create_profile()
    {
        //Signup and login student
        $this->initialize_student_details();

        //Attempt to update tutor profile
        $response = $this->json(
            "POST",
            "api/student/profile/create",
            [
                "student_id" => 1,
                "first_name" => "Mlamli",
                "last_name" => "Lolwane",
                "study_level" => "University",
                "description" => "Upcoming software developer",
            ],
            ['ACCEPT' => 'application/json']
        );

        $this->assertCount(1, StudentProfile::all());
    }

    public function test_student_can_update_profile()
    {
        //Signup and login student
        $this->initialize_student_details();

        //Create profile for the tutor
        $student_profile = StudentProfile::factory()->create();

        //Ensure that the tutor's profile is created
        $this->assertCount(1, StudentProfile::all());

        //Update the tutor's profile
        $response = $this->json(
            "PUT",
            "api/student/profile/update",
            [
                "student_id" => 1,
                "first_name" => "Mlamli",
                "last_name" => "Lolwane",
                "study_level" => "School",
                "description" => "Developing software for a big firm",
            ],
            ['ACCEPT' => 'application/json']
        );

        $response->assertJsonFragment([
            'study_level' => "School",
            'description' => "Developing software for a big firm"
        ]);
    }

    public function test_student_can_delete_profile()
    {
        $this->withoutExceptionHandling();
        //Signup and login student
        $this->initialize_student_details();

        //Create profile for the student
        $student_profile = StudentProfile::factory()->create();

        //Ensure that the tutor's profile is created
        $this->assertCount(1, StudentProfile::all());

        //Delete tutor profile
        $response = $this->json(
            "DELETE",
            "api/student/profile/delete",
            ["student_id" => 1],
            ['ACCEPT' => 'application/json']
        );

        //dd($student_profile);

        //Assert that the tutor's profile has been soft deleted
        $this->assertSoftDeleted('student_profiles');

        //dd($profile);
    }

    public function initialize_student_details()
    {
        //Create role
        Role::create(["name" => "Student"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Student');

        //Login user 
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        $this->assertAuthenticatedAs(Auth::user());
    }
}
