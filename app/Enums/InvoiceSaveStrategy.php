<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class InvoiceSaveStrategy extends Enum implements LocalizedEnum
{
    use CollectionTrait;

    const SAVE = 'SAVE';
    const SEND = 'SEND';
    const DRAFT = 'DRAFT';
    const UPDATE = 'UPDATE';

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
            case self::UPDATE:
                $values = ['blue', '#2196f3'];
                break;
            case self::SAVE:
                $values = ['green', '#4caf50'];
                break;
            case self::DRAFT:
            default:
                $values = ['grey', '#9e9e9e'];
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }
}
