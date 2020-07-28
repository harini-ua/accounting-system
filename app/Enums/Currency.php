<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static USD()
 * @method static static EUR()
 * @method static static UAH()
 */
final class Currency extends Enum
{
    const USD = 'USD';
    const EUR = 'EUR';
    const UAH = 'UAH';

    /**
     * @var string[]
     */
    private static $symbols = [
        self::USD => '$',
        self::EUR => '€',
        self::UAH => '₴',
    ];

    /**
     * @param $value
     * @return string
     */
    public static function symbol($value): string
    {
        return self::$symbols[self::getKey($value)];
    }

}
