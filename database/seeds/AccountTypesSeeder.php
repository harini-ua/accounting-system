<?php

use App\Models\AccountType;
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
            'symbol' => '₴',
        ]);
        AccountType::create([
            'name' => 'USD',
            'symbol' => '$',
        ]);
        AccountType::create([
            'name' => 'EUR',
            'symbol' => '€',
        ]);
        AccountType::create([
            'name' => 'Deposit UAH',
            'symbol' => '₴',
        ]);
    }
}
