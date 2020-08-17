<?php

namespace App\Enums;

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
final class Month extends Enum
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


}