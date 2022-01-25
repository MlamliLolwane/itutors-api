<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UniversityModule;

class UniversityModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UniversityModule::create([
            'module_code' => 'ONT1000',
            'module_name' => 'Software Development 1',
            'university' => 'Nelson Mandela University',
        ]);

        UniversityModule::create([
            'module_code' => 'PRT2000',
            'module_name' => 'Internet Programming 2',
            'university' => 'Nelson Mandela University',
        ]);
    }
}
