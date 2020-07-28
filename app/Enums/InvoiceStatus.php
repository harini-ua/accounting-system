<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;

final class InvoiceStatus extends Enum implements LocalizedEnum
{
    use CollectionTrait;

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
            case self::SEND:
                $values = ['blue', '#2196f3'];
                break;
            case self::PAID:
                $values = ['green', '#4caf50'];
                break;
            case self::DEBT:
            case self::OVERDUE:
                $values = ['orange', '#ff9800'];
                break;
            case self::CANCELED:
                $values = ['red', '#f44336'];
                break;
            case self::DRAFT:
            default:
                $values = ['grey', '#9e9e9e'];
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }
}
