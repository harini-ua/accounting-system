<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static January()
 * @method static static February()
 * @method static static March()
 * @method static static April()
 * @method static static May()
 * @method static static June()
 * @method static static July()
 * @method static static August()
 * @method static static September()
 * @method static static October()
 * @method static static November()
 * @method static static December()
 */
final class Month extends Enum implements LocalizedEnum
{
    const January = 'January';
    const February = 'February';
    const March = 'March';
    const April = 'April';
    const May = 'May';
    const June = 'June';
    const July = 'July';
    const August = 'August';
    const September = 'September';
    const October = 'October';
    const November = 'November';
    const December = 'December';

    /**
     * @return string[]
     */
    public static function firstQuarter()
    {
        return [self::January, self::February, self::March];
    }

    /**
     * @return string[]
     */
    public static function secondQuarter()
    {
        return [self::April, self::May, self::June];
    }

    /**
     * @return string[]
     */
    public static function firstHalfYear()
    {
        return array_merge(self::firstQuarter(), self::secondQuarter());
    }

    /**
     * @return string[]
     */
    public static function thirdQuarter()
    {
        return [self::July, self::August, self::September];
    }

    /**
     * @return string[]
     */
    public static function forthQuarter()
    {
        return [self::October, self::November, self::December];
    }

    /**
     * @return string[]
     */
    public static function secondHalfYear()
    {
        return array_merge(self::thirdQuarter(), self::forthQuarter());
    }

    /**
     * Get months by quarter
     *
     * @param $quarter
     *
     * @return string[]
     */
    public static function byQuarter($quarter)
    {
        switch ($quarter) {
            case 1:
            default:
                return self::firstQuarter();
            case 2:
                return self::secondQuarter();
            case 3:
                return self::thirdQuarter();
            case 4:
                return self::forthQuarter();
        }
    }
}
