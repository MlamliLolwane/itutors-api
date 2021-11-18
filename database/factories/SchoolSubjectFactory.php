<?php

namespace Database\Factories;

use App\Models\SchoolSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolSubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SchoolSubject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject_name' => "Physical Science",
            'grade' => 12
        ];
    }
}
