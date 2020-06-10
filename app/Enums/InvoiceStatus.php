<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class InvoiceStatus extends Enum implements LocalizedEnum
{
    const DRAFT = 'DRAFT';
    const SEND = 'SEND';
    const PAID = 'PAID';
    const OVERDUE = 'OVERDUE';
    const CANCELED = 'CANCELED';
    const DEBT = 'DEBT';

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
