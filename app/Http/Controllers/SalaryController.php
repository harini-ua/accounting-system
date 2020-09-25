<?php

namespace App\Http\Controllers;


use App\Models\CalendarMonth;
use App\Models\CalendarYear;
use App\Models\Person;
use App\Models\SalaryPayment;
use App\Models\Wallet;
use App\Services\SalaryPaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->only(['year', 'month']), [
            'year' => 'sometimes|exists:calendar_years,id',
            'month' => 'sometimes|integer|min:1|max:12',
        ]);
        if ($validator->fails()) {
            abort(404);
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('salary.index'), 'name' => __('Salary')],
            ['name' => __('Create')],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')->with('calendarMonths')->get();
        $calendarMonth = null;
        $date = Carbon::now();
        if ($request->has(['year', 'month'])) {
            $year = $calendarYears->where('id', $request->year)->first()->name;
            $date = Carbon::createFromDate($year, $request->month);
            $calendarMonth = CalendarMonth::ofYear($year)
                ->where('calendar_months.name', $date->monthName)
                ->first();
        }

        $wallets = Wallet::with('accounts.accountType')->get();
        $people = Person::whereNull('quited_at')->orderBy('name')->get(); // todo: pick only if final payslip isn't paid

        $salaryPaymentService = new SalaryPaymentService($calendarMonth, $people, $request, $date);
        extract($salaryPaymentService->data());


        return view('pages.salary.create', compact(
            'breadcrumbs', 'pageConfigs', 'calendarYears', 'calendarMonth', 'salaryPayment', 'people', 'person',
            'symbol', 'wallets', 'currencies', 'fields'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  SalaryPayment  $salaryPayment
     * @return Response
     */
    public function show(SalaryPayment $salaryPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SalaryPayment  $salaryPayment
     * @return Response
     */
    public function edit(SalaryPayment $salaryPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  SalaryPayment  $salaryPayment
     * @return Response
     */
    public function update(Request $request, SalaryPayment $salaryPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SalaryPayment $salaryPayment
     * @return Response
     */
    public function destroy(SalaryPayment $salaryPayment)
    {
        //
    }
}
