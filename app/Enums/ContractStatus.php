<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static STATUS_OPENED()
 * @method static static STATUS_CLOSED()
 */
final class ContractStatus extends Enum implements LocalizedEnum
{
    const OPENED = 'OPENED';
    const CLOSED = 'CLOSED';

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        //

        return parent::getDescription($value);
    }
}
