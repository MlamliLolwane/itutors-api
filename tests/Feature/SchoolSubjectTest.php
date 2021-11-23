<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\SchoolSubject;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolSubjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_rules()
    {
        $this->initial_admin_details();

        //Attempt to create a subject
        $response = $this->json(
            "POST",
            "api/school_subject/create",
            ['ACCEPT' => 'application/json']
        );

        $response->assertJsonValidationErrors([
            'subject_name',
            'grade'
        ]);
    }

    public function test_all_subjects_can_be_retrieved_from_database()
    {
        $this->initial_admin_details();

        //Create subjects
        SchoolSubject::factory()->create();
        SchoolSubject::factory()->create(['subject_name' => 'Life Science']);
        $this->assertCount(2, SchoolSubject::all());

        //Get all subjects from database
        $response = $this->json(
            "GET",
            "api/school_subject/list",
            ['ACCEPT' => 'application/json']
        );

        $response->assertSee(['Physical Science', 'Life Science']);
    }


    public function test_admin_can_create_school_subject()
    {
        $this->initial_admin_details();

        //Attempt to create a subject
        $response = $this->json(
            "POST",
            "api/school_subject/create",
            ['subject_name' => 'English Home Language', 'grade' => 10],
            ['ACCEPT' => 'application/json']
        );

        $this->assertCount(1, SchoolSubject::all());
    }

    public function test_admin_can_update_school_subject()
    {
        $this->initial_admin_details();

        //Create a subject
        SchoolSubject::factory()->create();
        $this->assertCount(1, SchoolSubject::all());

        //Attempt to update a subject
        $response = $this->json(
            "PUT",
            "api/school_subject/update",
            ['id' => 1, 'subject_name' => 'Physical Sciences', 'grade' => 10],
            ['ACCEPT' => 'application/json']
        );

        $response->assertJsonFragment(['subject_name' => 'Physical Sciences', 'grade' => 10]);
    }

    public function test_admin_can_delete_school_subject()
    {
        $this->initial_admin_details();

        SchoolSubject::factory()->create();
        $this->assertCount(1, SchoolSubject::all());

        //Delete school subject
        $response = $this->json(
            "DELETE",
            "api/school_subject/delete",
            ["id" => 1],
            ['ACCEPT' => 'application/json']
        );

        //Assert that the school subject has been soft deleted
        $this->assertSoftDeleted('school_subjects');
    }

    public function initial_admin_details()
    {
        //Create role
        Role::create(["name" => "Admin"]);

        //Create user
        $user = User::factory()->create();
        $user->assignRole('Admin');

        //Login user 
        Auth::attempt(['email' => 'mrlolwane96@gmail.com', 'password' => 'Mlamli123']);

        $this->assertAuthenticated();
    }
}
