<?php

namespace Database\Factories;

use App\Models\TutorSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TutorSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tutor_id' => 1,
            'day_id' => 1,
            'schedule' => "[{\"end_time\": \"12:00\", \"start_time\": \"09:00\"}, {\"end_time\": \"17:00\", \"start_time\": \"13:00\"}]"
        ];
    }
}
