<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\CalendarMonth;
use App\Models\Vacation;
use App\Models\Person;

class VacationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $people = Person::all();
        $calendarMonths = \App\Models\CalendarMonth::ofYear(Carbon::now()->year)->get();
        factory(Vacation::class, 200)->create([
            'person_id' => function() use ($people) {
                return $people->random()->id;
            },
            'calendar_month_id' => function($vacation) use ($calendarMonths) {
                return $calendarMonths->where('name', Carbon::parse($vacation['date'])->monthName)->first()->id;
            }
        ]);
    }
}
