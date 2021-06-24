<?php

namespace App\Observers;

use App\Enums\Month;
use App\Models\CalendarMonth;
use App\Models\CalendarYear;
use App\Models\Holiday;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class CalendarYearObserver
{
    /**
     * Handle the calendar year "creating" event.
     *
     * @param CalendarYear $calendarYear
     *
     * @return void
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function creating(CalendarYear $calendarYear)
    {
        if ($lastCalendarYear = CalendarYear::latest()->first()) {
            $calendarYear->name = Carbon::createFromDate($lastCalendarYear->name)->addYear()->year;
        }
    }

    /**
     * Handle the calendar year "created" event.
     *
     * @param CalendarYear $calendarYear
     *
     * @return void
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function created(CalendarYear $calendarYear)
    {
        // Create holidays
        if ($calendarYear->id != 1) {
            $holidays = new Collection();

            // Get $lastYearHolidays to copy them in next year
            $lastYearHolidays = Holiday::where('calendar_year_id', function($query) {
                $query->select('calendar_year_id')
                    ->from('holidays')
                    ->orderByDesc('calendar_year_id')
                    ->limit(1);
            })->get();

            foreach ($lastYearHolidays as $lastYearHoliday) {

                $date = Carbon::parse($lastYearHoliday->date);
                $newDate = Carbon::createFromDate($calendarYear->name, $date->month, $date->day);
                $moved = $newDate->isWeekend();

                $holiday = Holiday::withoutEvents(function() use ($calendarYear, $lastYearHoliday, $newDate, $moved) {
                    return Holiday::create([
                        'calendar_year_id' => $calendarYear->id,
                        'name' => $lastYearHoliday->name,
                        'date' => $newDate,
                        'moved_date' => $moved ? (clone $newDate)->nextWeekday() : null,
                    ]);
                });

                $holidays->push($holiday);
            }
        } else {
            $holidays = $calendarYear->holidays;
        }

        // Create Calendar months
        foreach (Month::asArray() as $month) {
            $firstDay = Carbon::parse("$month {$calendarYear->name}")->startOfMonth();
            $lastDay = (clone $firstDay)->addMonth();

            $weekends = $firstDay->diffInDaysFiltered(function(Carbon $date) {
                return $date->isWeekend();
            }, $lastDay);

            $holidaysCount = $holidays->filter(function($holiday) use ($firstDay, $lastDay) {
                return Carbon::parse($holiday->moved_date ?? $holiday->date)->isBetween($firstDay, $lastDay);
            })->count();

            CalendarMonth::create([
                'calendar_year_id' => $calendarYear->id,
                'date' => $firstDay,
                'name' => $month,
                'calendar_days' => $firstDay->diffInDays($lastDay),
                'weekends' => $weekends,
                'holidays' => $holidaysCount,
            ]);
        }
    }

    /**
     * Handle the calendar year "updated" event.
     *
     * @param  CalendarYear  $calendarYear
     * @return void
     */
    public function updated(CalendarYear $calendarYear)
    {
        //
    }

    /**
     * Handle the calendar year "deleted" event.
     *
     * @param  CalendarYear  $calendarYear
     * @return void
     */
    public function deleted(CalendarYear $calendarYear)
    {
        //
    }

    /**
     * Handle the calendar year "restored" event.
     *
     * @param  CalendarYear  $calendarYear
     * @return void
     */
    public function restored(CalendarYear $calendarYear)
    {
        //
    }

    /**
     * Handle the calendar year "force deleted" event.
     *
     * @param  CalendarYear  $calendarYear
     * @return void
     */
    public function forceDeleted(CalendarYear $calendarYear)
    {
        //
    }
}
