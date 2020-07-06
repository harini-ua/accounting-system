<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static CEO()
 * @method static static COO()
 * @method static static ProjectManager()
 * @method static static Manager()
 * @method static static SalesManager()
 * @method static static Developer()
 * @method static static SysAdmin()
 * @method static static Accountant()
 */
final class Position extends Enum implements LocalizedEnum
{
    const CEO = 1;
    const COO = 2;
    const ProjectManager = 3;
    const Manager = 4;
    const SalesManager = 5;
    const Developer = 6;
    const SysAdmin = 7;
    const Accountant = 8;
}
