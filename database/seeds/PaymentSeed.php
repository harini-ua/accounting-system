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
        $createdAt = \Illuminate\Support\Carbon::now();

        $allPayments = [];

        foreach ($invoiceIds as $invoiceId) {
            $payments = factory(\App\Modules\Payment::class, random_int(1, 3))
                ->make([
                    'invoice_id' => $invoiceId,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ])->toArray();

            $allPayments = array_merge($allPayments, $payments);
        }

        \App\Modules\Payment::insert($allPayments);
    }
}
