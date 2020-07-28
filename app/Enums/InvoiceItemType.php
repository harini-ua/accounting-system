<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class InvoiceItemType extends Enum implements LocalizedEnum
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


    /**
     * Get the color values for an type
     *
     * @param string $status
     * @param string $value
     *
     * @return string
     */
    public static function getColor($status, $value = 'hash'): string
    {
        switch ($status) {
            case self::HOURLY:
                $values = ['blue', '#2196f3'];
                break;
            case self::FIXED:
            default:
                $values = ['green', '#4caf50'];
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }
}
