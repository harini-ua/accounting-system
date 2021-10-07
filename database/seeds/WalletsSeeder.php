<?php

use App\Models\Wallet;
use App\Models\WalletType;
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
        $walletTypes = WalletType::all();
        factory(Wallet::class, 15)->create([
            'wallet_type_id' => function () use ($walletTypes) {
                return $walletTypes->random()->id;
            }
        ])->each(function ($wallet) {
            $wallet->createAccounts();
        });
    }
}
