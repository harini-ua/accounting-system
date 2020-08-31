<?php

namespace App\Models;

use App\Casts\Date;
use App\Scopes\YearScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['destroyLink', 'updateLink'];

    protected $casts = [
        'date' => Date::class,
        'moved_date' => Date::class,
    ];

    /**
     * @return string
     */
    public function getDestroyLinkAttribute()
    {
        return route('holidays.destroy', $this);
    }

    /**
     * @return string
     */
    public function getUpdateLinkAttribute()
    {
        return route('holidays.update', $this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendarYear()
    {
        return $this->belongsTo(CalendarYear::class);
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
