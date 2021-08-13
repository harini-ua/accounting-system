<?php

namespace App\Http\Controllers;

use App\DataTables\FinalPayslipDataTable;
use App\Http\Requests\FinalPayslipCreateRequest;
use App\Http\Requests\FinalPayslipUpdateRequest;
use App\Models\CalendarMonth;
use App\Models\FinalPayslip;
use App\Models\Person;
use App\Models\Wallet;
use App\Services\FinalPayslipService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class FinalPayslipController extends Controller
{
    /**
     * Display a listing of the clients.
     *
     * @param FinalPayslipDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FinalPayslipDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Final Payslip')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.final-payslip.index', compact('breadcrumbs', 'pageConfigs'));
    }

    /**
     * Show the form for creating a new final payslip.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->only(['person_id']), [
            'person_id' => 'sometimes|exists:people,id',
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('final-payslip.index'), 'name' => __('Final Payslip')],
            ['name' => __('Create')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        [$date, $calendarMonth] = $this->setLastDate($request);

        $wallets = Wallet::with('accounts.accountType')->get();
        $people = Person::whereDoesntHave('finalPayslip')->orderBy('name')->get();

        $finalPayslipService = new FinalPayslipService($calendarMonth, $people, $request, $date);
        [$calendarMonth, $finalPayslip, $person, $symbol, $currencies, $fields] = $finalPayslipService->data();

        return view('pages.final-payslip.create', compact(
            'pageConfigs', 'breadcrumbs', 'people', 'wallets',
            'calendarMonth', 'person', 'finalPayslip', 'symbol', 'fields', 'currencies'
        ));
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function setLastDate(Request $request)
    {
        $date = Carbon::now();

        if ($request->has('changed')) {
            switch ($request->get('changed')) {
                case 'person':
                    $person = Person::find($request->get('person_id'));
                    if ($person->quited_at) {
                        $date = Carbon::parse($person->quited_at);
                    }
                    break;
                case 'date':
                    $date = Carbon::parse($request->get('last_working_day'));
                    break;
            }
        }

        $year = $date->year;
        $calendarMonth = CalendarMonth::ofYear($year)
            ->where('calendar_months.name', $date->monthName)
            ->first();

        return [
            $date,
            $calendarMonth
        ];
    }

    /**
     * Store a newly created resource in final payslip.
     *
     * @param FinalPayslipCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FinalPayslipCreateRequest $request)
    {
        $finalPayslip = new FinalPayslip();
        $finalPayslip->fill($request->all());
        $finalPayslip->save();

        alert()->success($finalPayslip->employee->name, __('Create client has been successful'));

        return redirect()->route('final-payslip.show', $finalPayslip);
    }

    /**
     * Display the specified final payslip.
     *
     * @param  FinalPayslip $finalPayslip
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(FinalPayslip $finalPayslip)
    {
        $finalPayslip->load(['employee']);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('final-payslip.index'), 'name' => __('Final Payslip')],
            ['name' => $finalPayslip->employee->name]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.final-payslip.show', compact(
            'breadcrumbs', 'pageConfigs', 'finalPayslip'
        ));
    }

    /**
     * Display the specified final payslip.
     *
     * @param  Person $person
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function person(Person $person)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('people.index'), 'name' => __('People')],
            ['name' => __('Edit Person')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $finalPayslip = FinalPayslip::where('person_id', $person->id)->first();
        $people = Person::orderBy('name')->get();

        return view('pages.final-payslip.person', compact(
            'breadcrumbs', 'pageConfigs', 'people', 'person' ,'finalPayslip'
        ));
    }


    /**
     * Update the specified resource in final payslip.
     *
     * @param FinalPayslipUpdateRequest $request
     * @param  FinalPayslip $finalPayslip
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function update(FinalPayslipUpdateRequest $request, FinalPayslip $finalPayslip)
    {
        $finalPayslip->fill($request->all());
        $finalPayslip->save();

        alert()->success($finalPayslip->name, __('FinalPayslip- data has been update successful'));

        return redirect()->route('final-payslip.index');
    }
}
