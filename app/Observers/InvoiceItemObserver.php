<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceItemObserver
{
    /**
     * Handle the invoice item "saving" event.
     *
     * @param  \App\Models\InvoiceItem  $item
     * @return void
     */
    public function saving(InvoiceItem $item)
    {
        $item->sum = $item->rate * $item->qty;
    }

    /**
     * Handle the invoice item "creating" event.
     *
     * @param  \App\Models\InvoiceItem  $item
     * @return void
     */
    public function saved(InvoiceItem $item)
    {
        /** @var Invoice $invoice */
        $invoice = $item->invoice;
        $invoice->recalculate();
    }

    /**
     * Handle the invoice item "deleted" event.
     *
     * @param  \App\Models\InvoiceItem  $item
     * @return void
     */
    public function deleted(InvoiceItem $item)
    {
        /** @var Invoice $invoice */
        $invoice = $item->invoice;
        $invoice->recalculate();
    }
}
