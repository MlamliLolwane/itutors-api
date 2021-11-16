<?php

namespace Database\Factories;

use App\Models\StudentProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_id' => 1,
            'first_name' => 'Mlamli',
            'last_name' => 'Lolwane',
            'study_level' => 'University',
            'description' => 'Passionate about Software Development',
        ];
    }
}
