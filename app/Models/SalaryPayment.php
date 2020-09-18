<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

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
