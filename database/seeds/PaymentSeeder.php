<?php

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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
        $invoiceIds = Invoice::all()->pluck('id');
        $createdAt = Carbon::now();

        $allPayments = [];

        foreach ($invoiceIds as $invoiceId) {
            if (random_int(0, 3)) {
                $payments = factory(Payment::class, random_int(1, 3))
                    ->make([
                        'invoice_id' => $invoiceId,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ])->toArray();

                $allPayments = array_merge($allPayments, $payments);
            }
        }

        Payment::insert($allPayments);
    }
}
