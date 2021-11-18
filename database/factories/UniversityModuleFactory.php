<?php

namespace Database\Factories;

use App\Models\UniversityModule;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UniversityModule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'module_code' => 'ONT1000',
            'module_name' => 'Software Development 1',
            'university' => 'Nelson Mandela University',
        ];
    }
}
