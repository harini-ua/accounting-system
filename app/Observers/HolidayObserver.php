<?php

namespace App\Observers;

use App\Models\CalendarMonth;
use App\Models\Holiday;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HolidayObserver
{
    /**
     * Handle the holiday "created" event.
     *
     * @param Holiday $holiday
     *
     * @return void
     * @throws InvalidFormatException
     */
    public function created(Holiday $holiday)
    {
        $this->calculationMonthHolidays($holiday);
    }

    /**
     * Handle the holiday "updated" event.
     *
     * @param Holiday $holiday
     *
     * @return void
     * @throws InvalidFormatException
     */
    public function updated(Holiday $holiday)
    {
        $this->calculationMonthHolidays($holiday);
        $this->calculationMonthHolidays($holiday, true);
    }

    /**
     * Handle the holiday "deleted" event.
     *
     * @param Holiday $holiday
     *
     * @return void
     * @throws InvalidFormatException
     */
    public function deleted(Holiday $holiday)
    {
        $this->calculationMonthHolidays($holiday);
    }

    /**
     * Handle the holiday "restored" event.
     *
     * @param Holiday $holiday
     * @return void
     */
    public function restored(Holiday $holiday)
    {
        //
    }

    /**
     * Handle the holiday "force deleted" event.
     *
     * @param Holiday $holiday
     * @return void
     */
    public function forceDeleted(Holiday $holiday)
    {
        //
    }

    /**
     * @param Holiday $holiday
     * @param false $original
     *
     * @throws InvalidFormatException
     */
    private function calculationMonthHolidays(Holiday $holiday, $original = false)
    {
        $date = $original
            ? Carbon::parse($holiday->getOriginal('moved_date') ?? $holiday->getOriginal('date'))
            : Carbon::parse($holiday->moved_date ?? $holiday->date);
        $month = $date->format('F');
        $calendarYear = $holiday->calendarYear;
        $firstDay = $date->startOfMonth();
        $lastDay = (clone $firstDay)->addMonth();

        $holidaysCount = DB::table('holidays')
            ->selectRaw("sum(
            case
                when `moved_date` between '$firstDay' and '$lastDay' then 1
                when date between '$firstDay' and '$lastDay' then 1 else 0 end
            ) as holidays_count")
            ->where('calendar_year_id', $calendarYear->id)
            ->first()
            ->holidays_count;

        $calendarMonth = CalendarMonth::where('name', $month)->where('calendar_year_id', $calendarYear->id)->first();
        $calendarMonth->holidays = $holidaysCount;
        $calendarMonth->save();
    }
}
