<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseCategoryDataTable;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ExpenseCategoryDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExpenseCategoryDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['name' => "Expense categories"]
        ];
        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.expense-category.index', compact('pageConfigs', 'breadcrumbs'));
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
     * @param  ExpenseCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseCategoryRequest $request)
    {
        $wallet = ExpenseCategory::create($request->all());

        return redirect()->route('expense-categories.index');
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
     * @param  ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('wallets.index'), 'name' => "Wallets"],
            ['name' => "Edit Wallet"]
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
     * @param  ExpenseCategoryRequest  $request
     * @param  ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
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
     * @param  ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->delete()) {
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }
}
