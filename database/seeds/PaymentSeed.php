<?php

use Illuminate\Database\Seeder;

class PaymentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Modules\Payment::class, 10)->create();
    }
}
