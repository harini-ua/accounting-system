<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * @package App
 */
class Account extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['account_type_id', 'wallet_id', 'started_at', 'start_sum', 'status'];
    /**
     * @var string[]
     */
    protected $dates = ['started_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
}
