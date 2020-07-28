<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Fixed40()
 * @method static static Fixed30()
 * @method static static Fixed20()
 * @method static static Hourly()
 */
final class SalaryType extends Enum implements LocalizedEnum
{
    const Fixed40 = 'fixed_40';
    const Fixed30 = 'fixed_30';
    const Fixed20 = 'fixed_30';
    const Hourly = 'hourly';
}
