<?php

namespace Database\Factories;

use App\Models\TutorAdvertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorAdvertisementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TutorAdvertisement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => "Test and Exam Preparation",
            'content' => "I will help with your software development assignments and test preparation.",
            'price' => 200,
            'max_participants' => 1,
            'duration' => "60",
            'ad_type' => "Reoccuring",
            'tutor_id' => 1,
            'subject_id' => "ONT1000",
        ];
    }
}
