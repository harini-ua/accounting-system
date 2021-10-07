<?php

namespace App\Observers;

use App\Models\Offer;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class OfferObserver
{
    /**
     * Handle the invoice "saving" event.
     *
     * @param Offer $offer
     *
     * @return void
     * @throws InvalidFormatException
     */
    public function saving(Offer $offer)
    {
        if ($offer->isDirty(['start_date', 'trial_period'])) {
            $trialPeriod = ($offer->trial_period) ?? config('people.trial_period.value');
            $offer->end_trial_period_date = Carbon::parse($offer->start_date)->addMonths($trialPeriod);
        }
    }
}
