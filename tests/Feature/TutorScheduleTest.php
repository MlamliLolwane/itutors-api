<?php

namespace Tests\Feature;

use App\Models\Day;
use Tests\TestCase;
use App\Models\User;
use App\Models\TutorProfile;
use App\Models\TutorSchedule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Database\Factories\TutorScheduleFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TutorScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_errors()
    {
        //Create tutor
        $this->create_user_and_profile();

        //Attempt to create schedule
        $response = $this->json(
            "POST",
            "api/tutor/schedule/create",
            ['ACCEPT' => 'application/json']
        );

        //Test validation errors
        $response->assertJsonValidationErrors([
            'tutor_id',
            'day_id',
            'schedule'
        ]);
    }

    public function test_tutor_can_create_schedule()
    {
        $this->withoutExceptionHandling();

        $this->create_user_and_profile();

        //Ensure that a day is there in the database
        $day = Day::create(['day_name' => 'Monday']);


        //Create schedule
        $response = $this->json(
            "POST",
            "api/tutor/schedule/create",
            [
                "tutor_id" => 1,
                "day_id" => 1,
                "schedule" => "[{\"end_time\": \"12:00\", \"start_time\": \"09:00\"}, {\"end_time\": \"17:00\", \"start_time\": \"13:00\"}]"
            ],
            ['ACCEPT' => 'application/json']
        );

        $this->assertCount(1, TutorSchedule::all());
    }

    public function test_tutor_can_get_schedule_from_database()
    {
        $this->withoutExceptionHandling();

        $this->create_user_and_profile();

        //Ensure that a day is there in the database
        $day = Day::create(['day_name' => 'Monday']);

        //Create schedule
        TutorSchedule::factory()->create();

        $response = $this->json(
            "GET",
            "api/tutor/schedule/list/1",
            ['ACCEPT' => 'application/json']
        );

        $this->assertNotEmpty($response);
    }

    public function test_tutor_can_update_schedule()
    {
        $this->withoutExceptionHandling();

        $this->create_user_and_profile();

        //Ensure that a day is there in the database
        Day::create(['day_name' => 'Monday']);

        //Create schedule
        $schedule = TutorSchedule::factory()->create(); 

        $this->assertCount(1, TutorSchedule::all());

        //dd(TutorSchedule::all());
        //Update the tutor's schedule
        $response = $this->json(
            "PUT",
            "api/tutor/schedule/update/1",
            [
                "schedule" => "[{\"end_time\": \"13:00\", \"start_time\": \"08:00\"}]"
            ],
            ['ACCEPT' => 'application/json']
        );
        //dd($response);
        $response->assertJsonFragment(["schedule" => "[{\"end_time\": \"13:00\", \"start_time\": \"08:00\"}]"]);
    }

    public function test_tutor_can_delete_schedule()
    {
        $this->withoutExceptionHandling();

        $this->create_user_and_profile();

        //Ensure that a day is there in the database
        $day = Day::create(['day_name' => 'Monday']);

        //Create schedule
        TutorSchedule::factory()->create();

        //Check to see record is created
        $this->assertCount(1, TutorSchedule::all());

        $response = $this->json(
            "DELETE",
            "api/tutor/schedule/delete/1",
            ['ACCEPT' => 'application/json']
        );

        $this->assertDeleted('tutor_schedules');
    }

    public function create_user_and_profile()
    {
        //Create role
        Role::create(["name" => "Tutor"]);

        //Create user & assign role of tutor
        $user = User::factory()->create();
        $user->assignRole('Tutor');

        $this->assertCount(1, User::all());


        //Login tutor
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);
        $this->assertAuthenticatedAs(Auth::user());

        //Create tutor's profile
        TutorProfile::factory()->create();
        $this->assertCount(1, TutorProfile::all());
    }
}
