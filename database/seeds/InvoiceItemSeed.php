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
        \App\Models\Invoice::chunk(1000, function($invoices) {
            $allInvoiceItems = [];
            $invoiceIds = $invoices->pluck('id');

            foreach ($invoiceIds as $invoiceId) {
                $createdAt = \Illuminate\Support\Carbon::now()->subDays(rand(1, 365));
                $invoiceItems = factory(\App\Models\InvoiceItem::class, random_int(3, 6))
                    ->make([
                        'invoice_id' => $invoiceId,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ])->toArray();

                $allInvoiceItems = array_merge($allInvoiceItems, $invoiceItems);
            }

            \App\Models\InvoiceItem::insert($allInvoiceItems);
        });
    }
}
