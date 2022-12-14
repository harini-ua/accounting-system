<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['accounts'];

    public const TABLE_NAME = 'wallets';

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
    protected $fillable = ['name', 'wallet_type_id'];

    /**
     * @return BelongsTo
     */
    public function walletType()
    {
        return $this->belongsTo(WalletType::class);
    }

    /**
     * @return HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Create Accounts
     */
    public function createAccounts()
    {
        $accountTypes = $this->walletType->account_types;
        foreach ($accountTypes as $accountType) {
            Account::create([
                'account_type_id' => $accountType,
                'wallet_id' => $this->id,
            ]);
        }
    }
}
