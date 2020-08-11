<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarMonth extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function calendarYear()
    {
        return $this->belongsTo(CalendarYear::class);
    }
}
