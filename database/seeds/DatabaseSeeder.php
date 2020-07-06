<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PositionsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AccountTypesSeeder::class);
        $this->call(WalletTypesSeeder::class);
        $this->call(WalletsSeeder::class);
        $this->call(MoneyFlowsSeeder::class);
        $this->call(ClientsSeed::class);
        $this->call(ContractsSeed::class);
        $this->call(InvoicesSeed::class);
        $this->call(InvoiceItemSeed::class);
        $this->call(PaymentSeed::class);
        $this->call(IncomeSeeder::class);
    }
}
