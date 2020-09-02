<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'date' => Date::class,
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
}
