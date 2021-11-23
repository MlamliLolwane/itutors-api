<?php

namespace Database\Factories;

use App\Models\TutoringRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutoringRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TutoringRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'student_id' => 2,
            'tutor_id' => 1,
            'advertisement_id' => 1,
            'requested_date' => Carbon::tomorrow(),
            'requested_time' => Carbon::now(),
            'tutorial_joining_url' => $this->faker->url(),
        ];
    }
}
