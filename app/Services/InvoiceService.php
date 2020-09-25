<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    /**
     * Save invoice strategy
     *
     * @param array $invoiceData
     *
     * @return Invoice
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function save($invoiceData): Invoice
    {
        $invoiceItems = [];
        foreach ($invoiceData['items'] as $item) {
            $invoiceItems[] = new InvoiceItem($item);
        }
        unset($invoiceData['items']);

        DB::beginTransaction();
        try {
            $invoice = new Invoice();
            $invoice->fill($invoiceData);
            $invoice->save();

            $invoice->items()->saveMany($invoiceItems);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        alert()->success($invoice->number, __('Create invoice has been successful'));

        return $invoice;
    }

    /**
     * Update invoice strategy
     *
     * @param Invoice $invoice
     * @param array   $invoiceData
     *
     * @return Invoice
     */
    public function update(Invoice $invoice, $invoiceData): Invoice
    {
        $invoiceItems = [];
        foreach ($invoiceData['items'] as $item) {
            $invoiceItems[] = new InvoiceItem($item);
        }
        unset($invoiceData['items']);

        DB::beginTransaction();
        try {
            $invoice->update($invoiceData);

            $invoice->items()->delete();
            $invoice->items()->saveMany($invoiceItems);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        alert()->success($invoice->number, __('Update invoice has been successful'));

        return $invoice;
    }
}
