<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Paid()
 * @method static static Unpaid()
 */
final class VacationPaymentType extends Enum implements LocalizedEnum
{
    const Paid = 'paid';
    const Unpaid = 'unpaid';
}
