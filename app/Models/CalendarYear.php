<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarYear extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendarMonths()
    {
        return $this->hasMany(CalendarMonth::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }
}
