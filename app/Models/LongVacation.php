<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Model;

class LongVacation extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'long_vacation_started_at' => Date::class,
        'long_vacation_plan_finished_at' => Date::class,
        'long_vacation_finished_at' => Date::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
