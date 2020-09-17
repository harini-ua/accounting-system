<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletType extends Model
{
    public const TABLE_NAME = 'wallet_types';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'account_types' => 'array',
    ];
}
