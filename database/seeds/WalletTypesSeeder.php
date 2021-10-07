<?php

use App\Models\AccountType;
use App\Models\WalletType;
use Illuminate\Database\Seeder;

class WalletTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WalletType::create([
            'name' => 'Bank',
            'account_types' => [AccountType::UAH, AccountType::USD, AccountType::EUR, AccountType::DEPOSIT_UAH],
        ]);
        WalletType::create([
            'name' => 'Upwork',
            'account_types' => [AccountType::USD],
        ]);
        WalletType::create([
            'name' => 'Payoneer',
            'account_types' => [AccountType::USD],
        ]);
        WalletType::create([
            'name' => 'Individual',
            'account_types' => [AccountType::UAH, AccountType::USD, AccountType::EUR, AccountType::DEPOSIT_UAH],
        ]);
        WalletType::create([
            'name' => 'Payment Card',
            'account_types' => [AccountType::UAH],
        ]);
        WalletType::create([
            'name' => 'Cash',
            'account_types' => [AccountType::UAH, AccountType::USD, AccountType::EUR],
        ]);
    }
}
