<?php

namespace App\Models;

use App\Casts\Date;
use App\Services\Calculators\Calculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneyFlow extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = 'money_flows';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'account_from_id', 'sum_from', 'account_to_id', 'sum_to', 'currency_rate', 'fee', 'comment'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => Date::class,
    ];

    /**
     * The array of booted models.
     *
     * @var array
     */
    protected static function booted()
    {
        static::creating(function ($moneyFlow) {
            Calculator::create($moneyFlow);
        });
        static::updating(function ($moneyFlow) {
            Calculator::update($moneyFlow);
        });
        static::deleting(function ($moneyFlow) {
            Calculator::delete($moneyFlow);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountFrom()
    {
        return $this->belongsTo(Account::class, 'account_from_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountTo()
    {
        return $this->belongsTo(Account::class, 'account_to_id');
    }
}
