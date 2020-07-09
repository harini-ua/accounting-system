<?php

namespace App\Models;

use App\Casts\Date;
use App\Services\Calculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneyFlow extends Model
{
    use SoftDeletes;

    protected $fillable = ['date', 'account_from_id', 'sum_from', 'account_to_id', 'sum_to', 'currency_rate',
        'fee', 'comment'];

    protected $casts = [
        'date' => Date::class,
    ];

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
