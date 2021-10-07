<?php

namespace App\Http\Controllers;

use App\DataTables\AccountsDataTable;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Wallet;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AccountsDataTable $dataTable
     * @return mixed
     */
    public function index(AccountsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Accounts')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallets = Wallet::all();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now();
        $accountTypes = AccountType::with('accountsSum')->get();

        return $dataTable->render('pages.account.index', compact(
            'breadcrumbs', 'pageConfigs', 'wallets', 'startDate', 'endDate', 'accountTypes'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Account $account
     * @return Application|Factory|View
     */
    public function edit(Account $account)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('accounts.index'), 'name' => __('Accounts')],
            ['name' => __('Edit Account')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallet = Wallet::find($account->wallet_id);
        $accountType = AccountType::find($account->account_type_id);

        return view('pages.account.edit', [
            'breadcrumbs' => $breadcrumbs,
            'pageConfigs' => $pageConfigs,
            'model' => $account,
            'wallet' => $wallet,
            'accountType' => $accountType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountRequest $request
     * @param Account $account
     *
     * @return RedirectResponse
     * @throws MassAssignmentException
     */
    public function update(AccountRequest $request, Account $account)
    {
        $account->fill($request->all());

        if (!$request->status) {
            $account->status = 0;
        }

        $account->save();

        return redirect()->route('accounts.index');
    }
}
