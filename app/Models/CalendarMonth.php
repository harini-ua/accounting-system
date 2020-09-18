<?php

namespace App\Models;

use App\Enums\Month;
use App\Scopes\YearScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CalendarMonth extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['quarter', 'halfYear'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendarYear()
    {
        return $this->belongsTo(CalendarYear::class);
    }

    /**
     * @return string
     */
    public function getQuarterAttribute()
    {
        if (in_array($this->name, Month::firstQuarter())) {
            return 'first';
        }
        if (in_array($this->name, Month::secondQuarter())) {
            return 'second';
        }
        if (in_array($this->name, Month::thirdQuarter())) {
            return 'third';
        }
        if (in_array($this->name, Month::forthQuarter())) {
            return 'fourth';
        }
    }

    /**
     * @return string
     */
    public function getHalfYearAttribute()
    {
        if (in_array($this->name, array_merge(Month::firstQuarter(), Month::secondQuarter()))) {
            return 'first';
        }
        if (in_array($this->name, array_merge(Month::thirdQuarter(), Month::forthQuarter()))) {
            return 'second';
        }
    }

    /**
     * @return mixed
     */
    public function getWorkingDaysAttribute()
    {
        return $this->calendar_days - $this->holidays - $this->weekends;
    }

    /**
     * @param Builder $query
     * @param string $year
     * @return Builder
     */
    public function scopeOfYear(Builder $query, string $year)
    {
        (new YearScope($year))->apply($query, $this);
        return $query;
    }
}
