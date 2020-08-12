<?php

use App\Models\CalendarYear;
use Illuminate\Database\Seeder;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CalendarYear::class)->create();
    }
}
