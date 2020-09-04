<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Quited()
 * @method static static NotStarted()
 * @method static static LongVacation()
 * @method static static Holiday()
 * @method static static Weekday()
 * @method static static Planned()
 * @method static static Actual()
 * @method static static Sick()
 */
final class DayType extends Enum
{
    const Quited = 'quited';
    const NotStarted = 'not_started';
    const LongVacation = 'long_vacation';
    const Holiday = 'holiday';
    const Weekday = 'weekday';
    const Planned = VacationType::Planned;
    const Actual = VacationType::Actual;
    const Sick = VacationType::Sick;


    /**
     * @return array[]
     */
    public static function days()
    {
        return [
            self::Quited => [
                'color' => 'quited-color',
                'available' => false,
                'value' => '',
            ],
            self::NotStarted => [
                'color' => 'not-started-color',
                'available' => false,
                'value' => '',
            ],
            self::LongVacation => [
                'color' => 'long-vacation-color',
                'available' => false,
                'value' => '',
            ],
            self::Holiday => [
                'color' => 'light-red',
                'available' => false,
                'value' => '',
            ],
            self::Weekday => [
                'color' => 'white',
                'available' => true,
                'value' => '',
            ],
            self::Planned => [
                'color' => 'yellow',
                'available' => true,
                'value' => '',
            ],
            self::Actual => [
                'color' => 'green',
                'available' => true,
                'value' => '1',
            ],
            self::Sick => [
                'color' => 'blue',
                'available' => true,
                'value' => '1',
            ],
        ];
    }
}
