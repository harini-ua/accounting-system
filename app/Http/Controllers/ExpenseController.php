<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseDataTable;
use App\Http\Requests\ExpensesRequest;
use App\Models\AccountType;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Wallet;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ExpenseDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Expense Categories')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $filterService = $dataTable->filterService;
        $accountTypes = AccountType::with([
            'expensesSum' => function($query) use ($filterService) {
                $filterService->filterExpensesSum($query);
            },
        ])->get();
        $startDate = $filterService->getStartDate()->format('d-m-Y');
        $endDate = $filterService->getEndDate()->format('d-m-Y');

        return $dataTable->render('pages.expenses.index', compact(
            'pageConfigs', 'breadcrumbs', 'accountTypes', 'startDate', 'endDate'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('expenses.index'), 'name' => __('Expenses')],
            ['name' => __('Add Expense')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $model = Expense::find($request->input('model'));
        $wallets = Wallet::with('accounts.accountType')->get();
        $expenseCategories = ExpenseCategory::all();

        return view('pages.expenses.create', [
            'breadcrumbs' => $breadcrumbs,
            'pageConfigs' => $pageConfigs,
            'wallets' => $wallets,
            'expenseCategories' => $expenseCategories,
            'model' => $model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ExpensesRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExpensesRequest $request)
    {
        Expense::create($request->except('wallet_id'));

        return redirect()->route('expenses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Expense $expense
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Expense $expense)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('expenses.index'), 'name' => __('Expenses')],
            ['name' => __('Edit Expense')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallets = Wallet::with('accounts.accountType')->get();
        $expenseCategories = ExpenseCategory::all();

        return view('pages.expenses.edit', [
            'breadcrumbs' => $breadcrumbs,
            'pageConfigs' => $pageConfigs,
            'wallets' => $wallets,
            'model' => $expense,
            'expenseCategories' => $expenseCategories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExpensesRequest $request
     * @param Expense         $expense
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function update(ExpensesRequest $request, Expense $expense)
    {
        $expense->fill($request->except('wallet_id'));
        $expense->save();

        return redirect()->route('expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Expense $expense
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Expense $expense)
    {
        if ($expense->delete()) {
            return response()->json(['success'=>true]);
        }

        return response()->json(['success'=>false]);
    }
}
