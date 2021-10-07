<?php

namespace App\Models;

use App\Casts\Date;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['moneyFlowsFrom', 'moneyFlowsTo', 'invoices', 'incomes', 'salaryPayments'];

    public const TABLE_NAME = 'accounts';

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
    protected $fillable = ['account_type_id', 'wallet_id', 'started_at', 'balance', 'status'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'started_at' => Date::class,
    ];

    /**
     * @return BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * @return BelongsTo
     */
    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    /**
     * @return HasMany
     */
    public function moneyFlowsFrom()
    {
        return $this->hasMany(MoneyFlow::class, 'account_from_id');
    }

    /**
     * @return HasMany
     */
    public function moneyFlowsTo()
    {
        return $this->hasMany(MoneyFlow::class, 'account_to_id');
    }

    /**
     * @return HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * @return HasMany
     */
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    /**
     * @return HasMany
     */
    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class);
    }
}
