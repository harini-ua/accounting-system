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
        $this->call(HolidaySeeder::class);
        $this->call(CalendarSeeder::class);
        if (app()->isLocal()) {
            $this->call(WalletsSeeder::class);
            $this->call(MoneyFlowsSeeder::class);
            $this->call(ClientsSeeder::class);
            $this->call(PeopleSeeder::class);
            $this->call(ContractsSeeder::class);
            $this->call(InvoicesSeeder::class);
            $this->call(InvoiceItemSeeder::class);
            $this->call(PaymentSeeder::class);
            $this->call(IncomeSeeder::class);
            $this->call(ExpensesSeeder::class);
            $this->call(CertificationsSeeder::class);
            $this->call(VacationSeeder::class);
            $this->call(SalaryPaymentSeeder::class);
            $this->call(OffersSeeder::class);
        }
    }
}
