<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Individual2()
 * @method static static Individual3()
 * @method static static Contract()
 * @method static static Employee()
 */
final class PersonContractType extends Enum implements LocalizedEnum
{
    const Individual2 = 'individual_2';
    const Individual3 = 'individual_3';
    const Contract = 'contract';
    const Employee = 'employee';
}
