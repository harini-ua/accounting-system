<?php

namespace App\Observers;

use App\Helpers\InvoiceHelper;
use App\Models\Invoice;

class InvoiceObserver
{
    /**
     * Handle the contract "creating" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function creating(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the invoice "created" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $invoice->number = InvoiceHelper::serialNumber($invoice->id);
    }

    /**
     * Handle the contract "updating" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updating(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the invoice "updated" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
