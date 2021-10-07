<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseCategoryDataTable;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Models\ExpenseCategory;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ExpenseCategoryDataTable $dataTable
     *
     * @return Response
     */
    public function index(ExpenseCategoryDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Expense Categories')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.expense-category.index', compact('pageConfigs', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExpenseCategoryRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ExpenseCategoryRequest $request)
    {
        $wallet = ExpenseCategory::create($request->all());

        return redirect()->route('expense-categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ExpenseCategory $expenseCategory
     *
     * @return Application|Factory|Response|View
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('wallets.index'), 'name' => __('Wallets')],
            ['name' => __('Edit Wallet')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.expense-category.edit', [
            'breadcrumbs' => $breadcrumbs,
            'pageConfigs' => $pageConfigs,
            'model' => $expenseCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExpenseCategoryRequest $request
     * @param ExpenseCategory $expenseCategory
     *
     * @return RedirectResponse
     * @throws MassAssignmentException
     */
    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->fill($request->all());
        $expenseCategory->save();

        return redirect()->route('expense-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ExpenseCategory $expenseCategory
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
