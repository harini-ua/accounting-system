<?php

namespace App\Models;

use App\Casts\Date;
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
}
