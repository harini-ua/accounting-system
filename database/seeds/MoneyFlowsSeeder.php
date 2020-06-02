<?php

use Illuminate\Database\Seeder;

class MoneyFlowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = \App\Account::all();
        factory(\App\MoneyFlow::class, 100)->create([
            'account_from_id' => function() use ($accounts) {
                return $accounts->random()->id;
            },
            'account_to_id' =>  function() use ($accounts) {
                return $accounts->random()->id;
            },
        ]);
    }
}
