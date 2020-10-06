<?php

namespace App\Http\Controllers;


use App\DataTables\SalaryDataTable;
use App\DataTables\SalaryMonthDataTable;
use App\Enums\Currency;
use App\Http\Requests\SalaryPaymentRequest;
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
    public function index(SalaryDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Salaries')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $year = $dataTable->year;
        $calendarYears = CalendarYear::orderBy('name')->get()->map(function($calendarYear) {
            $calendarYear->id = $calendarYear->name;
            return $calendarYear;
        });
        $currencies = Currency::toCollection()->filter(function($currency) {
            return in_array($currency->id, [Currency::UAH, Currency::USD]);
        });

        return $dataTable->render('pages.salary.index', compact('breadcrumbs', 'pageConfigs',
            'calendarYears', 'currencies', 'year'));
    }

    /**
     * @param $year
     * @param $month
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function month($year, $month)
    {
        if (!CalendarYear::where('name', $year)->exists() || !($month >= 1 && $month <= 12)) {
            abort(404);
        }

        $dataTable = new SalaryMonthDataTable($year, $month);
        if ($dataTable->request()->ajax()) {
            return $dataTable->ajax();
        }

        $monthName = Carbon::createFromDate($year, $month)->monthName;

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('salaries.index'), 'name' => __('Salaries')],
            ['name' => "$monthName $year"]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.salary.month', compact('breadcrumbs', 'pageConfigs', 'year', 'month', 'monthName'));
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
            'month' => 'sometimes|exists:calendar_months,id',
        ]);
        if ($validator->fails()) {
            abort(404);
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('salaries.index'), 'name' => __('Salary')],
            ['name' => __('Create')],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')->with('calendarMonths')->get();
        if ($request->has(['year', 'month'])) {
            $year = $calendarYears->where('id', $request->year)->first()->name;
            $date = Carbon::createFromDate($year, $request->month);
            $calendarMonth = CalendarMonth::find($request->month);
        } else {
            $date = Carbon::now();
            $year = $date->year;
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
     * @param SalaryPaymentRequest $request
     * @return Response
     */
    public function store(SalaryPaymentRequest $request)
    {
        $salaryPayment = SalaryPayment::firstOrNew([
            'calendar_month_id' => $request->calendar_month_id,
            'person_id' => $request->person_id,
        ]);
        $salaryPayment->fill($request->all());
        $salaryPayment->bonuses = json_decode($request->bonuses);
        $salaryPayment->save();

        return redirect('/'); // todo: redirect to salary month list
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
