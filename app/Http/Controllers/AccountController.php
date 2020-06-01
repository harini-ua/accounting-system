<?php

namespace App\Http\Controllers;

use App\AccountType;
use App\DataTables\AccountsDataTable;
use App\Http\Requests\AccountRequest;
use App\Wallet;
use App\Account;
use Illuminate\Http\Request;

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
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];

        $wallets = Wallet::all();

        return $dataTable->render('pages.account-list', [
            'pageConfigs' => $pageConfigs,
            'wallets' => $wallets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('accounts.index'), 'name' => "Accounts"],
            ['name' => "Account Edit"]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallets = Wallet::all();
        $accountTypes = AccountType::all();
        return view('pages.account-edit', [
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
     * @param Account $account
     * @return \Illuminate\Http\RedirectResponse
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
