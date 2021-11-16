<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TutorProfile;
use App\Models\TutorAdvertisement;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TutorAdvertisementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_errors()
    {
        //Create tutor
        $this->create_user_and_profile();

        //Create advertisement
        $response = $this->json(
            "POST",
            "api/tutor/advertisement/create",
            ['ACCEPT' => 'application/json']
        );

        //Test validation errors
        $response->assertJsonValidationErrors([
            'title',
            'content',
            'price',
            'max_participants',
            'duration',
            'ad_type',
            'tutor_id',
            'subject_id'
        ]);
    }

    public function test_tutor_can_create_advertisement()
    {
        //Create tutor
        $this->create_user_and_profile();

        $response = $this->json(
            "POST",
            "api/tutor/advertisement/create",
            [
                'title' => '1st Year Software Development Tutorial',
                'content' => 'I will give you a tutorial on whatever firs year software development topic
                you are struggling with.',
                'price' => '100',
                'max_participants' => '2',
                'duration' => '60 minutes',
                'ad_type' => 'Reoccuring tutorials',
                'tutor_id' => '1',
                'subject_id' => 'ONT1000'
            ],
            ['ACCEPT' => 'application/json']
        );

        $this->assertCount(1, TutorAdvertisement::all());
    }

    public function test_tutor_can_update_profile()
    {
        //Create tutor
        $this->create_user_and_profile();

        //Create advertisement
        TutorAdvertisement::factory()->create();
        
        $response = $this->json(
            "PUT",
            "api/tutor/advertisement/update",
            [
                'title' => "Test and Exam Preparation",
                'content' => "I will help with your software development assignments and test preparation.",
                'price' => "300",
                'max_participants' => 1,
                'duration' => "60",
                'ad_type' => "Reoccuring",
                'id' => 1,
                'subject_id' => "ONT1000",
            ],
            ['ACCEPT' => 'application/json']
        );

        //Assert record has been updated
        $response->assertJsonFragment([
            'price' => '300'
        ]);
    }

    public function test_tutor_can_delete_profile()
    {
        //Create tutor
        $this->create_user_and_profile();

        //Create advertisement
        $tutor_advertisement = TutorAdvertisement::factory()->create();

        //Delete tutor profile
        $response = $this->json(
            "DELETE",
            "api/tutor/advertisement/delete",
            ["id" => 1],
            ['ACCEPT' => 'application/json']
        );

        //dd($tutor_advertisement);

        //Assert that the tutor's profile has been soft deleted
        $this->assertSoftDeleted('tutor_advertisements');
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
