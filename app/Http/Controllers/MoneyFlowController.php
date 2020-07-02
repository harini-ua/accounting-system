<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyFlowRequest;
use App\Models\Wallet;
use App\Models\Account;
use App\Models\MoneyFlow;
use App\DataTables\MoneyFlowsDataTable;

class MoneyFlowController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param MoneyFlowsDataTable $dataTable
     * @return mixed
     */
    public function index(MoneyFlowsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['name' => "Money Flows"]
        ];
        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.money-flow.index', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('money-flows.index'), 'name' => "Money Flow"],
            ['name' => "Add Money Flow"]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallets = Wallet::with('accounts')->get();

        return view('pages.money-flow.create', [
            'breadcrumbs' => $breadcrumbs,
            'pageConfigs' => $pageConfigs,
            'wallets' => $wallets,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MoneyFlowRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MoneyFlowRequest $request)
    {
        MoneyFlow::create($request->all());

        return redirect()->route('money-flows.index');
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
     * @param MoneyFlow $moneyFlow
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(MoneyFlow $moneyFlow)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('money-flows.index'), 'name' => "Money Flow"],
            ['name' => "Edit Money Flow"]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallets = Wallet::with('accounts')->get();
        $accounts = Account::with('accountType')->get();
        $moneyFlow->load('accountFrom.wallet');

        return view('pages.money-flow.edit', [
            'breadcrumbs' => $breadcrumbs,
            'pageConfigs' => $pageConfigs,
            'model' => $moneyFlow,
            'wallets' => $wallets,
            'accounts' => $accounts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MoneyFlowRequest $request
     * @param MoneyFlow $moneyFlow
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MoneyFlowRequest $request, MoneyFlow $moneyFlow)
    {
        $moneyFlow->fill($request->all());
        $moneyFlow->save();

        return redirect()->route('money-flows.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MoneyFlow $moneyFlow
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(MoneyFlow $moneyFlow)
    {
        if ($moneyFlow->delete()) {
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }

    /**
     * @param $walletId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function walletAccounts($walletId)
    {
        return Account::with('accountType')
            ->where('wallet_id', '=', $walletId)
            ->get()
            ->map(function($account) {
                return [
                    'id' => $account->id,
                    'name' => $account->accountType->name,
                ];
            });
    }
}
