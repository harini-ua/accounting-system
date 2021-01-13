<?php

namespace App\Http\Controllers;

use App\DataTables\AccountsDataTable;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Account $account)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('accounts.index'), 'name' => __('Accounts')],
            ['name' => __('Edit Account')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallets = Wallet::all();
        $accountTypes = AccountType::all();

        return view('pages.account.edit', [
            'breadcrumbs' => $breadcrumbs,
            'pageConfigs' => $pageConfigs,
            'model' => $account,
            'wallets' => $wallets,
            'accountTypes' => $accountTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountRequest $request
     * @param Account        $account
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function update(AccountRequest $request, Account $account)
    {
        $account->fill($request->all());

        if (! $request->status) {
            $account->status = 0;
        }

        $account->save();

        return redirect()->route('accounts.index');
    }
}
