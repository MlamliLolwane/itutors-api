<?php

namespace Database\Factories;

use App\Models\TutorProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TutorProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tutor_id' => '1',
            'first_name' => 'Thabo',
            'last_name' => 'Mbeki',
            'job_title' => 'Software Developer',
            'description' => 'Passionate software developer hailing all the way from Mafikeng',
            'file_name' => '',
            'file_path' => ''
        ];
    }
}
