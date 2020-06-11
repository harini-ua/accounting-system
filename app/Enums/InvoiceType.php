<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class InvoiceType extends Enum implements LocalizedEnum
{
    const DEFAULT = 'DEFAULT';

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
