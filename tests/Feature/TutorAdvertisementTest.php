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
            'tutor_id',
            'subject_id'
        ]);
    }

    public function test_all_the_tutors_advertisements_can_be_fetched_from_database()
    {
         //Create tutor
         $this->create_user_and_profile();

         //Create advertisements
         TutorAdvertisement::factory()->create();
         TutorAdvertisement::factory()->create(['subject_id' => 'PRT2000']);

         //Get all tutor's advertisements from database
        $response = $this->json(
            "GET",
            "api/tutor/advertisement/list",
            ['tutor_id' => 1],
            ['ACCEPT' => 'application/json']
        );

        $response->assertSee(['ONT1000', 'PRT2000']);
    }

    public function test_a_tutors_advertisement_can_be_fetched_from_database()
    {
         //Create tutor
         $this->create_user_and_profile();

         //Create advertisements
         TutorAdvertisement::factory()->create();

         //Get all tutor's advertisements from database
        $response = $this->json(
            "GET",
            "api/tutor/advertisement/show",
            ['id' => 1],
            ['ACCEPT' => 'application/json']
        );

        $response->assertSee([
            "id" => 1,
            "title" => "Test and Exam Preparation",
            "content" => "I will help with your software development assignments and test preparation.",
            "price" => "200.0",
            "max_participants" => 1,
            "duration" => "60",
            "tutor_id" => 1,
            "subject_id" => "ONT1000"
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
                'price' => 100,
                'max_participants' => '2',
                'duration' => '60 minutes',
                'tutor_id' => '1',
                'subject_id' => 'ONT1000'
            ],
            ['ACCEPT' => 'application/json']
        );

        $this->assertCount(1, TutorAdvertisement::all());
    }

    // public function test_tutor_can_update_advertisement()
    // {
    //     //Create tutor
    //     $this->create_user_and_profile();

    //     //Create advertisement
    //     TutorAdvertisement::factory()->create();
        
    //     $response = $this->json(
    //         "PUT",
    //         "api/tutor/advertisement/update",
    //         [
    //             'title' => "Test and Exam Preparation",
    //             'content' => "I will help with your software development assignments and test preparation.",
    //             'price' => 300,
    //             'max_participants' => 1,
    //             'duration' => "60",
    //             'id' => 1,
    //             'subject_id' => "ONT1000",
    //         ],
    //         ['ACCEPT' => 'application/json']
    //     );
    //     //Assert record has been updated
    //     $response->assertJsonFragment([
    //         'price' => 300
    //     ]);
    // }

    public function test_tutor_can_delete_advertisement()
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
