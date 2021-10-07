<?php

use App\Enums\Currency;
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
            'currency_type' => Currency::UAH,
        ]);
        AccountType::create([
            'name' => 'USD',
            'symbol' => '$',
            'currency' => 28.09,
            'currency_type' => Currency::USD,
        ]);
        AccountType::create([
            'name' => 'EUR',
            'symbol' => '€',
            'currency' => 33.35,
            'currency_type' => Currency::EUR,
        ]);
        AccountType::create([
            'name' => 'Deposit UAH',
            'symbol' => '₴',
            'currency_type' => Currency::UAH,
        ]);
    }
}
