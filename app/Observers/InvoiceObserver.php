<?php

namespace App\Observers;

use App\Enums\InvoiceStatus;
use App\Helpers\InvoiceHelper;
use App\Models\Invoice;
use App\Notifications\SendInvoice;

class InvoiceObserver
{
    /**
     * Handle the invoice "saving" event.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function saving(Invoice $invoice)
    {
        if ($invoice->isDirty('status')) {
            if ($invoice->status === InvoiceStatus::SEND) {
//                $invoice->load(['contract.client']);
//
//                /** @var Client $client */
//                $client = $invoice->contract->client;
//                $client->notifications(new SendInvoice($invoice));
            }
        }
    }

    /**
     * Handle the invoice "created" event.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $invoice->number = InvoiceHelper::serialNumber($invoice->id);
        $invoice->save();
    }

    /**
     * Handle the invoice "deleting" event.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function deleting(Invoice $invoice)
    {
        $invoice->items()->delete();
        $invoice->payments()->delete();
    }

    /**
     * Handle the invoice "restored" event.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        $invoice->items()->withTrashed()->restore();
        $invoice->payments()->withTrashed()->restore();
    }
}
