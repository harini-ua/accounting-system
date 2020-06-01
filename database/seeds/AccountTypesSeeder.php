<?php

use App\AccountType;
use Illuminate\Database\Seeder;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountType::create([
            'name' => 'UAH',
        ]);
        AccountType::create([
            'name' => 'USD',
        ]);
        AccountType::create([
            'name' => 'EUR',
        ]);
        AccountType::create([
            'name' => 'Deposit UAH',
        ]);
    }
}
