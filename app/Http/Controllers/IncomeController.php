<?php

namespace App\Http\Controllers;

use App\DataTables\IncomeListDataTable;
use App\DataTables\IncomesDataTable;
use App\Http\Requests\IncomeRequest;
use App\Models\AccountType;
use App\Models\Client;
use App\Models\Income;
use App\Models\Wallet;
use App\Services\FilterService;

class IncomeController extends Controller
{
    public function list(IncomeListDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['name' => __("Actual Income")]
        ];
        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $clients = Client::with('contracts')->orderBy('name')->get();
        $wallets = Wallet::with('accounts.accountType')->orderBy('name')->get();

        $filterService = $dataTable->filterService;
        $accountTypes = AccountType::with([
            'invoicedSum' => function($query) use ($filterService) {
                $filterService->filterInvoicedSum($query);
            },
            'receivedSum' => function($query) use ($filterService) {
                $filterService->filterReceivedSum($query);
            }
        ])->get();
        $startDate = $filterService->getStartDate()->format('d-m-Y');
        $endDate = $filterService->getEndDate()->format('d-m-Y');

        return $dataTable->render('pages.income.list', compact('pageConfigs', 'breadcrumbs',
            'clients', 'wallets', 'startDate', 'endDate', 'accountTypes'
        ));
    }
    /**
     * Display a listing of the resource.
     *
     * @param IncomesDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IncomesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __("Home")],
            ['name' => __("Sales planning")]
        ];
        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $clients = Client::with('contracts')->get();
        $wallets = Wallet::with('accounts.accountType')->get();

        $filterService = $dataTable->filterService;
        $accountTypes = AccountType::with([
            'planningSum' => function($query) use ($filterService) {
                $filterService->filterPlanningSum($query);
            },
        ])->get();
        $startDate = $filterService->getStartDate()->format('d-m-Y');
        $endDate = $filterService->getEndDate()->format('d-m-Y');

        return $dataTable->render('pages.income.index', compact('pageConfigs', 'breadcrumbs',
            'clients', 'wallets',  'startDate', 'endDate', 'accountTypes'
        ));
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
     * @param  IncomeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncomeRequest $request)
    {
        $income = Income::create($request->all());

        alert()->success("Income #{$income->id} added successfully");

        return redirect()->route('incomes.index');
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
     * @param  Income $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('money-flows.index'), 'name' => "Money Flow"],
            ['name' => "Edit Money Flow"]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $clients = Client::with('contracts')->get();
        $wallets = Wallet::with('accounts.accountType')->get();

        return view('pages.income.edit', compact('pageConfigs', 'breadcrumbs',
            'clients', 'wallets', 'income'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IncomeRequest  $request
     * @param  Income $income
     * @return \Illuminate\Http\Response
     */
    public function update(IncomeRequest $request, Income $income)
    {
        $income->fill($request->all());
        $income->save();

        alert()->success("Income #{$income->id} updated successfully");

        return redirect()->route('incomes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Income $income
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Income $income)
    {
        if ($income->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Income has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }

    public function totals(FilterService $filterService)
    {
        return AccountType::with([
            'invoicedSum' => function($query) use ($filterService) {
                $filterService->filterInvoicedSum($query);
            },
            'receivedSum' => function($query) use ($filterService) {
                $filterService->filterReceivedSum($query);
            },
            'planningSum' => function($query) use ($filterService) {
                $filterService->filterPlanningSum($query);
            },
            'expensesSum' => function($query) use ($filterService) {
                $filterService->filterExpensesSum($query);
            },
            'accountsSum' => function($query) use ($filterService) {
                $filterService->filterAccountsSum($query);
            },
        ])->get()->makeVisible(['invoicedSum', 'receivedSum', 'accountsSum', 'planningSum']);
    }
}
