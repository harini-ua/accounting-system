<?php

use Illuminate\Database\Seeder;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        \App\Models\Invoice::chunk(1000, static function($invoices) {
            $allInvoiceItems = [];

            foreach ($invoices as $invoice) {
                $createdAt = \Illuminate\Support\Carbon::now()->subDays(random_int(1, 365));
                $invoiceItems = factory(\App\Models\InvoiceItem::class, random_int(3, 6))
                    ->make([
                        'invoice_id' => $invoice->id,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ])->toArray();

                $allInvoiceItems = array_merge($allInvoiceItems, $invoiceItems);
            }

            \App\Models\InvoiceItem::insert($allInvoiceItems);
        });
    }
}
