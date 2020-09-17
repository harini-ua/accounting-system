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
            $offer->end_trial_period_date = Carbon::parse($offer->start_date)->addMonths($offer->trial_period);
        }
    }
}
