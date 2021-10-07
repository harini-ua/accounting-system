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
     * @param int $value
     * @return string
     */
    public static function getDescription($value): string
    {
        //

        return parent::getDescription($value);
    }

    /**
     * Get the color values for an status
     *
     * @param string $status
     * @param string $value
     *
     * @return string
     */
    public static function getColor($status, $value = 'hash'): string
    {
        switch ($status) {
            case self::DEFAULT:
            default:
                $values = ['grey', '#9e9e9e'];
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }
}
