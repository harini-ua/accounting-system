<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public const TABLE_NAME = 'offers';

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
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['employee_id', 'start_date', 'trial_period', 'end_trial_period_date', 'bonuses', 'salary', 'salary_review', 'sum', 'salary_after_review', 'additional_conditions'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'start_date' => Date::class,
        'end_trial_period_date' => Date::class,
    ];

    /**
     * Get the client that owns the contract.
     */
    public function employee()
    {
        return $this->belongsTo(Person::class, 'employee_id', 'id');
    }
}
