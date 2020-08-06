<?php

namespace App\Models;

use App\Casts\Date;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'start_date' => Date::class,
        'contract_type_changed_at' => Date::class,
        'salary_type_changed_at' => Date::class,
        'salary_changed_at' => Date::class,
        'long_vacation_started_at' => Date::class,
        'long_vacation_plan_finished_at' => Date::class,
        'long_vacation_finished_at' => Date::class,
        'quited_at' => Date::class,
    ];

    /**
     * @var mixed|null
     */
    private $long_vacation_started_at;
    /**
     * @var mixed|null
     */
    private $long_vacation_reason;
    /**
     * @var mixed|null
     */
    private $long_vacation_compensation;
    /**
     * @var mixed|null
     */
    private $long_vacation_comment;
    /**
     * @var mixed|null
     */
    private $long_vacation_plan_finished_at;
    /**
     * @var mixed|null
     */
    private $long_vacation_finished_at;

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
