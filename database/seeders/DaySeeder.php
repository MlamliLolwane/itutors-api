<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Day::create(['day_name' => 'Monday']);
        Day::create(['day_name' => 'Tuesday']);
        Day::create(['day_name' => 'Wednesday']);
        Day::create(['day_name' => 'Thursday']);
        Day::create(['day_name' => 'Friday']);
        Day::create(['day_name' => 'Saturday']);
        Day::create(['day_name' => 'Sunday']);
    }
}
