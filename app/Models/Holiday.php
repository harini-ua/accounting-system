<?php

namespace App\Models;

use App\Casts\Date;
use App\Scopes\YearScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Holiday extends Model
{
    public const TABLE_NAME = 'holidays';

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
    protected $appends = ['destroyLink', 'updateLink'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
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
     * @return BelongsTo
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
