<?php

namespace App\Models;

use App\Enums\Month;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CalendarYear extends Model
{
    protected static function booted()
    {
        static::created(function ($calendarYear) {
            foreach (Month::toArray() as $month) {

                $firstDay = Carbon::parse("$month {$calendarYear->id}")->startOfMonth();
                $lastDay = (clone $firstDay)->endOfMonth();
                $weekends = $firstDay->diffInDaysFiltered(function(Carbon $date) {
                    return $date->isWeekend();
                }, $lastDay);

                CalendarMonth::create([
                    'calendar_year_id' => $calendarYear->id,
                    'name' => $month,
                    'calendar_days' => $firstDay->diffInDays($lastDay),
                    'weekends' => $weekends,
                ]);
            }
        });
    }
    public function calendarMonths()
    {
        return $this->hasMany(CalendarMonth::class);
    }
}
