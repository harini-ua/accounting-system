<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;

/**
 * @method static static CEO()
 * @method static static COO()
 * @method static static ProjectManager()
 * @method static static Manager()
 * @method static static SalesManager()
 * @method static static Developer()
 * @method static static SysAdmin()
 * @method static static Accountant()
 * @method static static Designer()
 * @method static static Recruiter()
 */
final class Position extends Enum implements LocalizedEnum
{
    use CollectionTrait;

    const CEO = 1;
    const COO = 2;
    const ProjectManager = 3;
    const Manager = 4;
    const SalesManager = 5;
    const Developer = 6;
    const SysAdmin = 7;
    const Accountant = 8;
    const Designer = 9;
    const Recruiter = 10;

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
            default:
                $values = ['grey', '#9e9e9e'];
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }
}
