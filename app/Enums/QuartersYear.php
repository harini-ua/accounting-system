<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class QuartersYear extends Enum implements LocalizedEnum
{
    use CollectionTrait;

    const FIRST_QUARTER  = 1;
    const SECOND_QUARTER = 2;
    const THIRD_QUARTER  = 3;
    const FORTH_QUARTER  = 4;

    /**
     * Get roman number by quarter
     *
     * @param $value
     * @return string
     */
    public static function roman($value): string
    {
        return integerToRoman(self::getKey($value));
    }

    /**
     * @return string[]
     */
    public static function firstQuarter()
    {
        return [Month::January, Month::February, Month::March];
    }

    /**
     * @return string[]
     */
    public static function secondQuarter()
    {
        return [Month::April, Month::May, Month::June];
    }

    /**
     * @return string[]
     */
    public static function thirdQuarter()
    {
        return [Month::July, Month::August, Month::September];
    }

    /**
     * @return string[]
     */
    public static function forthQuarter()
    {
        return [Month::October, Month::November, Month::December];
    }
}
