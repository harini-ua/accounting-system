<?php

namespace App\Observers;

use App\Enums\SalaryReviewReason;
use App\Models\SalaryReview;

class SalaryReviewObserver
{
    /**
     * Handle the invoice "saving" event.
     *
     * @param SalaryReview $salaryReview
     * @return void
     */
    public function saving(SalaryReview $salaryReview)
    {
        if (
            $salaryReview->isDirty(['reason']) &&
            $salaryReview->reason !== SalaryReviewReason::PROFESSIONAL_GROWTH) {
            $salaryReview->prof_growth = null;
        }
    }
}
