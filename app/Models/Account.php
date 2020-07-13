<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Account
 * @package App
 */
class Account extends Model
{
    use SoftDeletes;
    /**
     * @var string[]
     */
    protected $fillable = ['account_type_id', 'wallet_id', 'started_at', 'start_sum', 'status'];
    /**
     * @var string[]
     */
    protected $casts = [
        'started_at' => Date::class,
    ];

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
