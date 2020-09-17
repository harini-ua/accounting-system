<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarYear extends Model
{
    public const TABLE_NAME = 'calendar_years';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

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
