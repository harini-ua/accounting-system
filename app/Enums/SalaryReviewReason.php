<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class SalaryReviewReason extends Enum implements LocalizedEnum
{
    use CollectionTrait;

    const TRIAL_PERIOD_COMPLETED = 'TRIAL_PERIOD_COMPLETED';
    const DESERVED               = 'DESERVED';
    const PROFESSIONAL_GROWTH    = 'PROFESSIONAL_GROWTH';
    const CERTIFICATE            = 'CERTIFICATE';
    const DEMOTION               = 'DEMOTION';
    const POOR_PERFORMANCE       = 'POOR_PERFORMANCE';
    const OTHER                  = 'OTHER';
}
