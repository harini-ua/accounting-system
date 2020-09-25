<?php

namespace App\Models;

use App\Enums\Month;
use App\Scopes\YearScope;
use App\Services\SalaryPaymentService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CalendarMonth extends Model
{
    public const TABLE_NAME = 'calendar_months';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that are appends.
     *
     * @var array
     */
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
        if (in_array($this->name, Month::firstQuarter(), true)) {
            return 'first';
        }
        if (in_array($this->name, Month::secondQuarter(), true)) {
            return 'second';
        }
        if (in_array($this->name, Month::thirdQuarter(), true)) {
            return 'third';
        }
        if (in_array($this->name, Month::forthQuarter(), true)) {
            return 'fourth';
        }
    }

    /**
     * @return string
     */
    public function getHalfYearAttribute()
    {
        if (in_array($this->name, array_merge(Month::firstQuarter(), Month::secondQuarter()), true)) {
            return 'first';
        }

        if (in_array($this->name, array_merge(Month::thirdQuarter(), Month::forthQuarter()), true)) {
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

    /**
     * @param string $salaryType
     * @return float|int
     */
    public function getWorkingHours(string $salaryType)
    {
        return SalaryPaymentService::calcHours($this->working_days, $salaryType);
    }
}
