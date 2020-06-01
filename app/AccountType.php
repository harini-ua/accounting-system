<?php

namespace App;

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
}
