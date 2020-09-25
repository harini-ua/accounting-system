<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryReview extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = 'salary_reviews';

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
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['person_id', 'date', 'type', 'sum', 'reason', 'comment', 'prof_growth'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => Date::class,
    ];

    /**
     * Get the person for invoice.
     */
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
