<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name', 'wallet_type_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function walletType()
    {
        return $this->belongsTo(WalletType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     *
     */
    public function createAccounts()
    {
        $accountTypes = $this->walletType->account_types;
        foreach($accountTypes as $accountType) {
            Account::create([
                'account_type_id' => $accountType,
                'wallet_id' => $this->id,
            ]);
        }
    }
}
