<?php

use Illuminate\Database\Seeder;

class WalletsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $walletTypes = \App\WalletType::all();
        factory(\App\Wallet::class, 15)->create([
            'wallet_type_id' => function() use ($walletTypes) {
                return $walletTypes->random()->id;
            }
        ])->each(function($wallet) {
            $wallet->createAccounts();
        });
    }
}
