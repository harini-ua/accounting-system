<?php

namespace App\Observers;

use App\Enums\SalaryReviewReason;
use App\Enums\SalaryReviewType;
use App\Models\SalaryReview;

class SalaryReviewObserver
{
    /**
     * Handle the invoice "saving" event.
     *
     * @param  SalaryReview $salaryReview
     * @return void
     */
    public function saving(SalaryReview $salaryReview)
    {
        if($salaryReview->isDirty(['reason'])) {
            if ($salaryReview->get('reason') !== SalaryReviewReason::PROFESSIONAL_GROWTH) {
                $salaryReview->prof_growth = null;
            }
        }
    }
}
