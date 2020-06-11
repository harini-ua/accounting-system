<?php

use Illuminate\Database\Seeder;

class PaymentSeed extends Seeder
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
            factory(\App\Modules\Payment::class, random_int(1, 3))
                ->create([
                    'invoice_id' => $invoiceId,
                ]);
        }
    }
}
