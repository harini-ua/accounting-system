<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyFlow extends Model
{
    protected $fillable = ['date', 'account_from_id', 'sum_from', 'account_to_id', 'sum_to', 'currency_rate',
        'fee', 'comment'];
    protected $dates = ['date'];
    public function accountFrom()
    {
        return $this->belongsTo(Account::class, 'account_from_id');
    }
    public function accountTo()
    {
        return $this->belongsTo(Account::class, 'account_to_id');
    }
}
