<?php

namespace App;

use App\Services\Formatter;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountType
 * @package App
 */
class AccountType extends Model
{
    const UAH = 1;
    const USD = 2;
    const EUR = 3;
    const DEPOSIT_UAH = 4;

    protected $appends = ['accountsSum'];

    protected $hidden = ['accountsSum'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function accountsSum()
    {
        return $this->hasOne(Account::class)
            ->selectRaw('sum(balance) as balance_sum, account_type_id')
            ->groupBy('account_type_id');
    }

    /**
     * @return int|string
     */
    public function getAccountsSumAttribute()
    {
        if (!array_key_exists('accountsSum', $this->relations)) {
            $this->load('accountsSum');
        }

        $related = $this->getRelation('accountsSum');

        return $related ? Formatter::currency($related->balance_sum, $this) : 0;
    }
}
