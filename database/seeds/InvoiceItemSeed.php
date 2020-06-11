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
        $invoiceIds = \App\Modules\Invoice::all()->pluck('id');
        foreach ($invoiceIds as $invoiceId) {
            factory(\App\Modules\InvoiceItem::class, random_int(3, 6))
                ->create([
                    'invoice_id' => $invoiceId,
            ]);
        }
    }
}
