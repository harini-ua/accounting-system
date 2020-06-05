<?php

use Illuminate\Database\Seeder;

class InvoiceItemSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Modules\InvoiceItem::class, 10)->create();
    }
}
