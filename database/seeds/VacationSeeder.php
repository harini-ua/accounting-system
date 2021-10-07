<?php

use App\Models\CalendarMonth;
use App\Models\Person;
use App\Models\Vacation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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
        $calendarMonths = CalendarMonth::ofYear(Carbon::now()->year)->get();
        factory(Vacation::class, 200)->create([
            'person_id' => function () use ($people) {
                return $people->random()->id;
            },
            'calendar_month_id' => function ($vacation) use ($calendarMonths) {
                return $calendarMonths->where('name', Carbon::parse($vacation['date'])->monthName)->first()->id;
            }
        ]);
    }
}
