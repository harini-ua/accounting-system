<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'calendar_month_id',
        'person_id',
        'account_id',
        'worked_days',
        'worked_hours',
        'earned',
        'overtime_hours',
        'vacations',
        'vacation_compensation',
        'monthly_bonus',
        'fines',
        'tax_compensation',
        'other_compensation',
        'other_compensation_description',
        'total_usd',
        'currency',
        'payment_date',
        'comments'
    ];

    protected $casts = [
        'payment_date' => Date::class,
        'bonuses' => 'object',
    ];

    /**
     * Get the person that owns the salary payment.
     *
     * @return BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the calendar month that owns the salary payment.
     *
     * @return BelongsTo
     */
    public function calendarMonth()
    {
        return $this->belongsTo(CalendarMonth::class);
    }

    /**
     * Get the account that owns the salary payment.
     *
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Scope a query by status contract.
     *
     * @param Builder $query
     * @param string                                status
     *
     * @return Builder
     */
    public function scopeByDate($query, $year, $month = null)
    {
        if ($year) {
            $query->whereRaw("year(payment_date)={$year}");
        }

        if ($month) {
            $query->whereRaw("month(payment_date)={$month}");
        }

        return $query;
    }
}
