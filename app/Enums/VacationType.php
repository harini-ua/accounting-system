<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Planned()
 * @method static static Actual()
 * @method static static Sick()
 */
final class VacationType extends Enum implements LocalizedEnum
{
    const Planned = 'planned';
    const Actual = 'actual';
    const Sick = 'sick';

    /**
     * @return array
     */
    public static function actualAndSick()
    {
        return [self::Actual, self::Sick];
    }
}
