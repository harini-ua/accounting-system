<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletType extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'account_types' => 'array',
    ];
}
