<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Wallet;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *
     * @return void
     */
    public function testExpense()
    {
        $expenseCategory = factory(ExpenseCategory::class)->create();
        $wallet = factory(Wallet::class)->create();
        $wallet->createAccounts();
        $account = $wallet->accounts->first();

        $data = [
            'plan_date' => Carbon::now(),
            'purpose' => 'sdjfk dfjk dkj',
            'real_sum' => 1000,
            'account_id' => $account->id,
            'expense_category_id' => $expenseCategory->id,
        ];

        // create

        $expense = Expense::create($data);

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => -$data['real_sum'],
        ]);

        // update

        $data = [
            'real_sum' => 2000,
            'account_id' => $wallet->accounts[1]->id,
        ];

        $expense = Expense::find($expense->id);
        $expense->fill($data);
        $expense->save();

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => 0,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $wallet->accounts[1]->id,
            'balance' => -2000,
        ]);

        // delete

        $expense->delete();

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => 0,
        ]);
    }

    public function testExpenseForm()
    {
        $user = factory(User::class)->create();
        $expenseCategory = factory(ExpenseCategory::class)->create();
        $wallet = factory(Wallet::class)->create();
        $wallet->createAccounts();
        $account = $wallet->accounts->first();

        $data = [
            'plan_date' => Carbon::now()->format('d-m-Y'),
            'purpose' => 'sdjfk dfjk dkj',
            'real_sum' => 1000,
            'account_id' => $account->id,
            'expense_category_id' => $expenseCategory->id,
        ];

        // create

        $response = $this->actingAs($user)->post('expenses', $data);

        $response->assertStatus(302)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('expenses', [
            'plan_date' => Carbon::parse($data['plan_date'])->format('Y-m-d'),
            'purpose' => 'sdjfk dfjk dkj',
            'real_sum' => 1000,
            'account_id' => $account->id,
            'expense_category_id' => $expenseCategory->id,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => -$data['real_sum'],
        ]);

        $expense = Expense::orderBy('id', 'desc')->first();

        // update

        $data = [
            'plan_date' => Carbon::now()->format('d-m-Y'),
            'purpose' => 'sdjfk dfjk dkj',
            'real_sum' => 2000,
            'account_id' => $wallet->accounts[1]->id,
            'expense_category_id' => $expenseCategory->id,
        ];

        $response = $this
            ->actingAs($user)
            ->put("expenses/{$expense->id}", $data);

        $response->assertStatus(302)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'plan_date' => Carbon::parse($data['plan_date'])->format('Y-m-d'),
            'purpose' => 'sdjfk dfjk dkj',
            'real_sum' => 2000,
            'account_id' => $data['account_id'],
            'expense_category_id' => $expenseCategory->id,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => 0,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $wallet->accounts[1]->id,
            'balance' => -2000,
        ]);

        // delete

        $response = $this
            ->actingAs($user)
            ->delete("expenses/{$expense->id}");

        $response->assertOk();
        $this->assertSoftDeleted('expenses', [
            'id' => $expense->id,
            'plan_date' => Carbon::parse($data['plan_date'])->format('Y-m-d'),
            'purpose' => 'sdjfk dfjk dkj',
            'real_sum' => 2000,
            'account_id' => $data['account_id'],
            'expense_category_id' => $expenseCategory->id,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $wallet->accounts[1]->id,
            'balance' => 0,
        ]);

    }
}
