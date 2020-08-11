<?php

use App\Enums\Month;
use App\Models\CalendarMonth;
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
        factory(CalendarYear::class, 5)->create();

        $days = [
            Month::January => [
                'holidays' => 2,
            ],
            Month::February => [
                'holidays' => 0,
            ],
            Month::March => [
                'holidays' => 1,
            ],
            Month::April => [
                'holidays' => 1,
            ],
            Month::May => [
                'holidays' => 2,
            ],
            Month::June => [
                'holidays' => 2,
            ],
            Month::July => [
                'holidays' => 0,
            ],
            Month::August => [
                'holidays' => 1,
            ],
            Month::January => [
                'holidays' => 2,
            ],
            Month::September => [
                'holidays' => 0,
            ],
            Month::October => [
                'holidays' => 1,
            ],
            Month::November => [
                'holidays' => 0,
            ],
            Month::December => [
                'holidays' => 1,
            ],
        ];

        $months = CalendarMonth::where('calendar_year_id', 1)->get();
        foreach ($months as $month) {
            $month->fill($days[$month->name]);
            $month->save();
        }

    }
}
