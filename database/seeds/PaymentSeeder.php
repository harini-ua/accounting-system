<?php

use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
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

        $allPayments = [];

        foreach ($invoiceIds as $invoiceId) {
            if (rand(0, 3)) {
                $payments = factory(\App\Models\Payment::class, random_int(1, 3))
                    ->make([
                        'invoice_id' => $invoiceId,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ])->toArray();

                $allPayments = array_merge($allPayments, $payments);
            }
        }

        \App\Models\Payment::insert($allPayments);
    }
}
