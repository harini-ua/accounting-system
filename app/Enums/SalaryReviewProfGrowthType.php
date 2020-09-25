<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SalaryReviewProfGrowthType extends Enum implements LocalizedEnum
{
    use CollectionTrait;

    const BEFORE_PLANNED = 'BEFORE_PLANNED';
    const ON_TIME = 'ON_TIME';
    const OVERDUE = 'OVERDUE';
}
