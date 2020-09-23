<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class SalaryReviewType extends Enum implements LocalizedEnum
{
    use CollectionTrait;

    const ACTUAL = 'ACTUAL';
    const PENDING = 'PENDING';

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
            case self::ACTUAL:
                $values = ['green', '#4caf50'];
                break;
            case self::PENDING:
            default:
                $values = ['blue', '#2196f3'];
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }

    /**
     * Get the icon name for an type
     *
     * @param string $status
     *
     * @return string
     */
    public static function getIcon($status)
    {
        switch ($status) {
            case self::ACTUAL:
                $icon = 'done_all';
                break;
            case self::PENDING:
                $icon = 'hourglass_empty';
                break;
            default:
                $icon = 'local_atm';
        }

        return $icon;
    }
}
