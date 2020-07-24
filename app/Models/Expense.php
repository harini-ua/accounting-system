<?php

namespace App\Models;

use App\Casts\Date;
use App\Services\Calculators\Calculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'plan_date' => Date::class,
        'real_date' => Date::class,
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            Calculator::create($model);
        });
        static::updating(function ($model) {
            Calculator::update($model);
        });
        static::deleting(function ($model) {
            Calculator::delete($model);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

}
