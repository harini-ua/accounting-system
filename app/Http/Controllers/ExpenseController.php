<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseDataTable;
use App\Models\AccountType;
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
            ['link' => route('home'), 'name' => "Home"],
            ['name' => "Expense categories"]
        ];
        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $filterService = $dataTable->filterService;
        $accountTypes = AccountType::with([
            'expensesSum' => function($query) use ($filterService) {
                $filterService->filterExpensesSum($query);
            },
        ])->get();
        $startDate = $filterService->getStartDate()->format('d-m-Y');
        $endDate = $filterService->getEndDate()->format('d-m-Y');

        return $dataTable->render('pages.expenses.index', compact('pageConfigs', 'breadcrumbs',
            'accountTypes', 'startDate', 'endDate'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
