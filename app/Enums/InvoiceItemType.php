<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class InvoiceItemType extends Enum
{
    const HOURLY = 'HOURLY';
    const FIXED = 'FIXED';

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
