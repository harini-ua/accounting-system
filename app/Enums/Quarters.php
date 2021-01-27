<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Quarters extends Enum
{
    use CollectionTrait;

    const FIRST_QUARTER = 1;
    const SECOND_QUARTER = 2;
    const THIRD_QUARTER = 3;
    const FOURTH_QUARTER = 4;
}
