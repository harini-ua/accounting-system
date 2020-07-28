<?php

namespace App\Observers;

use App\Helpers\InvoiceHelper;
use App\Models\Invoice;

class InvoiceObserver
{
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
}
