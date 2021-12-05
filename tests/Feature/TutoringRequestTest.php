<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TutorProfile;
use App\Models\StudentProfile;
use Illuminate\Support\Carbon;
use App\Models\TutoringRequest;
use App\Models\TutorAdvertisement;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TutoringRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_errors()
    {
        $this->tutor_details();
        $this->student_details();

        $response = $this->json(
            "POST",
            "api/tutoring_request/create",
            ['ACCEPT' => 'application/json']
        );

        $response->assertJsonValidationErrors([
            'student_id',
            'tutor_id',
            'advertisement_id',
            'requested_date',
            'requested_time',
        ]);
    }

    public function test_all_the_tutors_advertisements_can_be_fetched_from_database()
    {
        $this->tutor_details();
        $this->student_details();

        //Create another advertisement 
        TutorAdvertisement::factory()->create(['price' => '300']);

        //Create a tutoring request
        TutoringRequest::factory()->create();
        TutoringRequest::factory()->create(['advertisement_id' => 2]);
        $this->assertCount(2, TutoringRequest::all());

        //Get all tutoring requests from database for a certain tutor
        $response = $this->json(
            "GET",
            "api/tutoring_request/list",
            ['tutor_id' => 1],
            ['ACCEPT' => 'application/json']
        );

        //This assertion is not correct
        $response->assertSee([
            'student_id' => 2,
            'tutor_id' => 1
        ]);
    }

    public function test_student_can_request_a_tutorial()
    {
        $this->tutor_details();
        $this->student_details();

        $response = $this->json(
            "POST",
            "api/tutoring_request/create",
            [
                'student_id' => 2,
                'tutor_id' => 1,
                'advertisement_id' => 1,
                'requested_date' => Carbon::tomorrow(),
                'requested_time' => Carbon::now(),
                //'request_status' => 'Pending',
                'tutorial_joining_url' => 'google.com'
            ],
            ['ACCEPT' => 'application/json']
        );

        $this->assertCount(1, TutoringRequest::all());
    }

    public function test_student_can_cancel_tutoring_request()
    {
        $this->tutor_details();
        $this->student_details();

        //Create a tutoring request
        TutoringRequest::factory()->create();
        $this->assertCount(1, TutoringRequest::all());

        //Cancel tutoring request
        $response = $this->json(
            "PUT",
            "api/tutoring_request/cancel",
            [
                'id' => 1,
            ],
            ['ACCEPT' => 'application/json']
        );

        $this->assertEquals($response['request_status'], 'Cancelled');
    }

    public function test_tutor_can_reject_tutoring_request()
    {
        $this->withoutExceptionHandling();
        $this->tutor_details();
        $this->student_details();
        
        //Logout student and login tutor
        Auth::logout();
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        //Create a tutoring request
        TutoringRequest::factory()->create();
        $this->assertCount(1, TutoringRequest::all());

        //Reject tutoring request
        $response = $this->json(
            "PUT",
            "api/tutoring_request/reject",
            [
                'id' => 1,
            ],
            ['ACCEPT' => 'application/json']
        );

        $this->assertEquals($response['request_status'], 'Rejected');
    }

    public function test_tutor_can_accept_tutoring_request()
    {
        $this->tutor_details();
        $this->student_details();

        //Logout student and login tutor
        Auth::logout();
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        //Create a tutoring request
        TutoringRequest::factory()->create();
        $this->assertCount(1, TutoringRequest::all());

        //Accept tutoring request
        $response = $this->json(
            "PUT",
            "api/tutoring_request/accept",
            [
                'id' => 1,
            ],
            ['ACCEPT' => 'application/json']
        );

        $this->assertEquals($response['request_status'], 'Accepted');
    }

    public function tutor_details()
    {
        //Create role
        Role::create(["name" => "Tutor"]);
        Role::create(["name" => "Student"]);

        //Create Tutor
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        //Login Tutor 
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);
        $this->assertAuthenticated();

        //Create Tutor Profile
        TutorProfile::factory()->create();

        //Create Advertisement
        TutorAdvertisement::factory()->create();
    }

    public function student_details()
    {
        //Create Student
        $student = User::factory()->create(['email' => 'mrlolwane1@gmail.com']);
        $student->assignRole('Student');

        //Login Student
        $student = Auth::attempt(['email' => 'mrlolwane1@gmail.com', 'password' => 'Mlamli123']);
        $this->assertAuthenticated();

        //Create Student Profile
        StudentProfile::factory()->create(['student_id' => 2]);
    }
}
