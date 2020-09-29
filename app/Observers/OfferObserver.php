<?php

namespace App\Observers;

use App\Models\Offer;
use Carbon\Carbon;

class OfferObserver
{
    /**
     * Handle the invoice "saving" event.
     *
     * @param  \App\Models\Offer $offer
     * @return void
     */
    public function saving(Offer $offer)
    {
        if($offer->isDirty(['start_date', 'trial_period'])) {
            $trialPeriod = ($offer->trial_period) ?? config('people.trial_period.value');
            $offer->end_trial_period_date = Carbon::parse($offer->start_date)->addMonths($trialPeriod);
        }
    }
}
