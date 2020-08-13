<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['deleteLink'];

    public function getDeleteLinkAttribute()
    {
        return route('holidays.destroy', $this);
    }
}
