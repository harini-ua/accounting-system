<?php

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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
        Invoice::chunk(1000, static function ($invoices) {
            $allInvoiceItems = [];

            foreach ($invoices as $invoice) {
                $createdAt = Carbon::now()->subDays(random_int(1, 365));
                $invoiceItems = factory(InvoiceItem::class, random_int(3, 6))
                    ->make([
                        'invoice_id' => $invoice->id,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ])->toArray();

                $allInvoiceItems = array_merge($allInvoiceItems, $invoiceItems);
            }

            InvoiceItem::insert($allInvoiceItems);
        });
    }
}
