<?php

use Illuminate\Database\Seeder;

class InvoicesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Modules\Invoice::class, 10)->create();
    }
}
