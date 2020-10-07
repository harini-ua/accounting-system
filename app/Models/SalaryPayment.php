<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Model;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendarMonth()
    {
        return $this->belongsTo(CalendarMonth::class);
    }

    /**
     * Get the account that owns the contract.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
