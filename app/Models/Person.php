<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected static function booted()
    {
        static::saving(function ($person) {
            $person->rate = round($person->salary / 160, 2);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
