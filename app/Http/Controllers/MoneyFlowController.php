<?php

namespace App\Http\Controllers;

use App\DataTables\MoneyFlowsDataTable;
use App\Http\Requests\MoneyFlowRequest;
use App\Models\Account;
use App\Models\MoneyFlow;
use App\Models\Wallet;

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
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Money Flows')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.money-flow.index', compact(
            'breadcrumbs', 'pageConfigs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('money-flows.index'), 'name' => __('Money Flow')],
            ['name' => __('Create')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallets = Wallet::with('accounts.accountType')->get();

        return view('pages.money-flow.create', compact(
            'breadcrumbs', 'pageConfigs', 'wallets'
        ));
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

        alert()->success(__('Success!'), __('Create money flow has been successful'));

        return redirect()->route('money-flows.index');
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
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('money-flows.index'), 'name' => __('Money Flow')],
            ['name' => __('Edit Money Flow')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallets = Wallet::with('accounts.accountType')->get();
        $accounts = Account::with('accountType')->get();
        $moneyFlow->load('accountFrom.wallet');

        return view('pages.money-flow.edit', compact(
            'breadcrumbs', 'pageConfigs', 'wallets', 'accounts', 'moneyFlow'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MoneyFlowRequest $request
     * @param MoneyFlow        $moneyFlow
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function update(MoneyFlowRequest $request, MoneyFlow $moneyFlow)
    {
        $moneyFlow->fill($request->all());
        $moneyFlow->save();

        alert()->success(__('Success!'), __('Money flow data has been update successful'));

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
}
