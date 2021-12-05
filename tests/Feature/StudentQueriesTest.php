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

class StudentQueriesTest extends TestCase
{
   use RefreshDatabase;

    public function test_students_can_search_for_advertisements()
    {
        //Create tutor
        $this->create_user_and_profile();

        //Create advertisements
        TutorAdvertisement::factory()->create();

        TutorAdvertisement::factory()->create([
            'title' => 'One on one tutoring',
            'content' => 'I will tutor you one on one based on your requerements on Software Development 1',
            'price' => 300,
            'subject_id' => 'ONT2000'
        ]);

        $response = $this->json(
            "GET",
            "api/query/tutor_advertisement",
            ['subject_id' => 'ONT1000'],
            ['ACCEPT' => 'application/json']
        );

        
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
