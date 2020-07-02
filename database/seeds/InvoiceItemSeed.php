<?php

use Illuminate\Database\Seeder;

class InvoiceItemSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $invoiceIds = \App\Models\Invoice::all()->pluck('id');
        $createdAt = \Illuminate\Support\Carbon::now();

        $allInvoiceItems = [];

        foreach ($invoiceIds as $invoiceId) {
            $invoiceItems = factory(\App\Models\InvoiceItem::class, random_int(3, 6))
                ->make([
                    'invoice_id' => $invoiceId,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
            ])->toArray();

            $allInvoiceItems = array_merge($allInvoiceItems, $invoiceItems);
        }

        \App\Models\InvoiceItem::insert($allInvoiceItems);
    }
}
