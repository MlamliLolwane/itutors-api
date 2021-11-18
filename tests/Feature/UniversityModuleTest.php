<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UniversityModule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UniversityModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_rules()
    {
        $this->initial_admin_details();

        //Attempt to create a module
        $response = $this->json(
            "POST",
            "api/university_module/create",
            ['ACCEPT' => 'application/json']
        );

        $response->assertJsonValidationErrors([
            'module_code',
            'module_name',
            'university'
        ]);
    }

    public function test_admin_can_create_university_module()
    {
        $this->withoutExceptionHandling();
        $this->initial_admin_details();

        //Attempt to create a subject
        $response = $this->json(
            "POST",
            "api/university_module/create",
            ['module_code' => 'ONT1000', 'module_name' => 'Software Development 1', 
            'university' => 'Nelson Mandela University'],
            ['ACCEPT' => 'application/json']
        );

        //dd($response);

        $this->assertCount(1, UniversityModule::all());
    }

    public function test_admin_can_update_university_module()
    {
        $this->initial_admin_details();

        //Create a subject
        UniversityModule::factory()->create();
        $this->assertCount(1, UniversityModule::all());

        //Attempt to update a subject
        $response = $this->json(
            "PUT",
            "api/university_module/update",
            ['module_code' => 'ONT1000', 'module_name' => 'Software Development 1A'],
            ['ACCEPT' => 'application/json']
        );

        $response->assertJsonFragment(['module_name' => 'Software Development 1A']);
    }

    public function test_admin_can_delete_university_module()
    {
        $this->initial_admin_details();

        UniversityModule::factory()->create();
        $this->assertCount(1, UniversityModule::all());

        //Delete school subject
        $response = $this->json(
            "DELETE",
            "api/university_module/delete",
            ["module_code" => 'ONT1000'],
            ['ACCEPT' => 'application/json']
        );

        //Assert that the school subject has been soft deleted
        $this->assertSoftDeleted('university_modules');
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
