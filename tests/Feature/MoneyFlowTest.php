<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\MoneyFlow;
use App\Models\Wallet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MoneyFlowTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMoneyFlow()
    {
        $accounts = $this->createAccounts();
        /**
         * @var $accountFrom Account
         * @var $accountTo Account
         */
        extract($accounts);

        $moneyFlow = $this->create($accountFrom, $accountTo);

        $accounts = $this->update($accountFrom, $accountTo, $moneyFlow);
        extract($accounts);

        $this->delete($accountFrom, $accountTo, $moneyFlow);
    }

    /**
     *
     */
    public function testMoneyFlowForm()
    {
        $user = factory(User::class)->create();

        $this->successForm($user);
        $this->unSuccessForm($user);
        $this->unSuccessFormFee($user);
    }

    /**
     * @param $user
     */
    public function successForm($user)
    {
        $accounts = $this->createAccounts();
        /**
         * @var $accountFrom Account
         * @var $accountTo Account
         */
        extract($accounts);

        $date = Carbon::now();
        $data = [
            'account_from_id' => $accountFrom->id,
            'sum_from' => $accountFrom->balance - 1,
            'account_to_id' => $accountTo->id,
            'sum_to' => $accountFrom->balance - 1,
            'date' => $date->format('d-m-Y'),
        ];

        $response = $this->actingAs($user)->post('money-flows', $data);
        $response->assertStatus(302)->assertSessionHasNoErrors();

        $data['date'] = $date->format('Y-m-d');
        $this->assertDatabaseHas('money_flows', $data);
    }

    /**
     * @param $user
     */
    public function unSuccessForm($user)
    {
        $accounts = $this->createAccounts();
        /**
         * @var $accountFrom Account
         * @var $accountTo Account
         */
        extract($accounts);

        $date = Carbon::now();
        $data = [
            'account_from_id' => $accountFrom->id,
            'sum_from' => $accountFrom->balance + 1,
            'account_to_id' => $accountTo->id,
            'sum_to' => $accountFrom->balance + 1,
            'date' => $date->format('d-m-Y'),
        ];

        $response = $this->actingAs($user)->post('money-flows', $data);
        $response->assertStatus(302)->assertSessionHasErrors([
            'sum_from', 'sum_to'
        ]);

        $data['date'] = $date->format('Y-m-d');
        $this->assertDatabaseMissing('money_flows', $data);
    }


    /**
     * @param $user
     */
    public function unSuccessFormFee($user)
    {
        $accounts = $this->createAccounts();
        /**
         * @var $accountFrom Account
         * @var $accountTo Account
         */
        extract($accounts);

        $date = Carbon::now();
        $data = [
            'account_from_id' => $accountFrom->id,
            'sum_from' => $accountFrom->balance - 1,
            'account_to_id' => $accountTo->id,
            'sum_to' => $accountFrom->balance - 1,
            'date' => $date->format('d-m-Y'),
            'fee' => 2,
        ];

        $response = $this->actingAs($user)->post('money-flows', $data);
        $response->assertStatus(302)->assertSessionHasErrors([
            'fee'
        ]);

        $data['date'] = $date->format('Y-m-d');
        $this->assertDatabaseMissing('money_flows', $data);
    }

    /**
     * @return array
     */
    public function createAccounts()
    {
        $wallets = factory(Wallet::class, 2)
            ->create()
            ->each(function($wallet) {
                $wallet->createAccounts();
            });
        $accountFrom = $wallets[0]->accounts->first();
        $accountTo = $wallets[1]->accounts->first();

        $this->assertDatabaseHas('accounts', [
            'id' => $accountFrom->id,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $accountTo->id,
        ]);

        return compact('accountFrom', 'accountTo');
    }

    /**
     * @param $accountFrom
     * @param $accountTo
     * @return mixed
     */
    public function create($accountFrom, $accountTo)
    {
        $data = [
            'account_from_id' => $accountFrom->id,
            'sum_from' => 10000,
            'fee' => 100,
            'account_to_id' => $accountTo->id,
            'sum_to' => 10000,
        ];

        $moneyFlow = MoneyFlow::create($data);

        $this->assertDatabaseHas('accounts', [
            'id' => $accountFrom->id,
            'balance' => -($data['sum_from']+$data['fee']),
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $accountTo->id,
            'balance' => $data['sum_to'],
        ]);

        return $moneyFlow;
    }

    /**
     * @param $accountFrom
     * @param $accountTo
     * @param $moneyFlow
     * @return array
     */
    public function update($accountFrom, $accountTo, $moneyFlow)
    {
        $accounts = $this->createAccounts();
        /**
         * @var $new_accountFrom Account
         * @var $new_accountTo Account
         */
        extract($accounts, EXTR_PREFIX_SAME, 'new');

        $data = [
            'account_from_id' => $new_accountFrom->id,
            'sum_from' => 10000,
            'fee' => 100,
            'account_to_id' => $new_accountTo->id,
            'sum_to' => 10000,
        ];

        $moneyFlow->fill($data);
        $moneyFlow->save();

        $this->assertDatabaseHas('accounts', [
            'id' => $new_accountFrom->id,
            'balance' => -($data['sum_from']+$data['fee']),
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $new_accountTo->id,
            'balance' => $data['sum_to'],
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $accountFrom->id,
            'balance' => 0,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $accountTo->id,
            'balance' => 0,
        ]);

        return [
            'newAccountFrom' => $new_accountFrom,
            'newAccountTo' => $new_accountTo,
        ];
    }

    /**
     * @param string $accountFrom
     * @param array $accountTo
     * @param array $moneyFlow
     */
    public function delete($accountFrom, $accountTo, $moneyFlow): void
    {
        $moneyFlow->delete();

        $this->assertDatabaseHas('accounts', [
            'id' => $accountFrom->id,
            'balance' => 0,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $accountTo->id,
            'balance' => 0,
        ]);
    }

}
