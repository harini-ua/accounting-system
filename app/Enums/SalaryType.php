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
    use CollectionTrait;

    const Fixed40 = 'fixed_40';
    const Fixed30 = 'fixed_30';
    const Fixed20 = 'fixed_20';
    const Hourly = 'hourly';

    /**
     * @param string $value
     * @return mixed|string
     */
    public static function hours(string $value)
    {
        if ($value == self::Hourly) {
            return null;
        }
        return explode('_', $value)[1] / 5;
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isHourly(string $value)
    {
        return $value === self::Hourly;
    }
}
