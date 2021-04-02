<?php

namespace App\Http\Controllers;

use App\DataTables\FormerPersonDataTable;
use App\DataTables\PersonDataTable;
use App\Enums\Currency;
use App\Enums\PersonContractType;
use App\Enums\Position;
use App\Enums\SalaryType;
use App\Enums\VacationPaymentType;
use App\Enums\VacationType;
use App\Http\Requests\PayDataRequest;
use App\Http\Requests\Person\BackActiveRequest;
use App\Http\Requests\Person\ChangeContractTypeRequest;
use App\Http\Requests\Person\ChangeSalaryTypeRequest;
use App\Http\Requests\Person\CompensateRequest;
use App\Http\Requests\Person\LongVacationRequest;
use App\Http\Requests\Person\MakeFormerRequest;
use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Http\Requests\Person\UpdateAvailableVacationsRequest;
use App\Models\CalendarMonth;
use App\Models\Person;
use App\Models\Vacation;
use App\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PersonDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PersonDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('People')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.person.index', compact('pageConfigs', 'breadcrumbs'));
    }

    /**
     * @param FormerPersonDataTable $dataTable
     * @return mixed
     */
    public function formerList(FormerPersonDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('people.index'), 'name' => __('People')],
            ['name' => __('Former Employees')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.person.former-list', compact('pageConfigs', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('people.index'), 'name' => __('People')],
            ['name' => __('Add Person')]
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $positions = Position::toCollection();
        $currencies = Currency::toCollection();
        $salaryTypes = SalaryType::toCollection();
        $contractTypes = PersonContractType::toCollection();
        $recruiters = Person::where('position_id', Position::Recruiter)->get();

        return view('pages.person.create', compact(
            'breadcrumbs', 'pageConfigs', 'positions',
            'currencies', 'salaryTypes', 'contractTypes', 'recruiters'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PersonCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PersonCreateRequest $request)
    {
        $person = Person::create($request->all());

        return redirect()->route('people.show', $person);
    }

    /**
     * Display the specified resource.
     *
     * @param  Person $person
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Person $person)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('people.index'), 'name' => __('People')],
            ['name' => $person->name]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $symbol = Currency::symbol($person->currency);
        $salaryTypes = SalaryType::toCollection();
        $contractTypes = PersonContractType::toCollection();

        return view('pages.person.show', compact(
            'breadcrumbs', 'pageConfigs', 'person', 'salaryTypes', 'contractTypes', 'symbol'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Person $person
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Person $person)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('people.index'), 'name' => __('People')],
            ['name' => __('Edit Person')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $model = $person;
        $positions = Position::toCollection();
        $currencies = Currency::toCollection();
        $salaryTypes = SalaryType::toCollection();
        $contractTypes = PersonContractType::toCollection();
        $recruiters = Person::where('position_id', Position::Recruiter)->get();

        $hasPayData = false;
        if($person->account_number !== null
            || $person->code !== null
            || $person->agreement !== null
            || $person->note_salary_pay !== null) {
            $hasPayData = true;
        }

        return view('pages.person.edit', compact(
            'breadcrumbs', 'pageConfigs', 'model', 'positions',
            'currencies', 'salaryTypes', 'contractTypes', 'recruiters', 'hasPayData'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PersonUpdateRequest $request
     * @param  Person $person
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PersonUpdateRequest $request, Person $person)
    {
        $person->fill($request->all());
        if (!$request->filled('growth_plan')) {
            $person->growth_plan = false;
        }
        if (!$request->filled('team_lead')) {
            $person->team_lead = false;
            $person->team_lead_reward = null;
        }
        if (!$request->filled('tech_lead')) {
            $person->tech_lead = false;
            $person->tech_lead_reward = null;
        }
        if (!$request->filled('bonuses')) {
            $person->bonuses = false;
            $person->bonuses_reward = null;
        }
        $person->save();

        return redirect()->route('people.show', $person);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Person $person
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Person $person)
    {
        if ($person->delete()) {
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }

    /**
     * @param ChangeSalaryTypeRequest $request
     * @param Person                  $person
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function changeSalaryType(ChangeSalaryTypeRequest $request, Person $person)
    {
        $person->fill($request->all());
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param ChangeContractTypeRequest $request
     * @param Person                    $person
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function changeContractType(ChangeContractTypeRequest $request, Person $person)
    {
        $person->fill($request->all());
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param MakeFormerRequest $request
     * @param Person            $person
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function makeFormer(MakeFormerRequest $request, Person $person)
    {
        $person->fill($request->all());
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param LongVacationRequest $request
     * @param Person              $person
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function longVacation(LongVacationRequest $request, Person $person)
    {
        $longVacation = $person->lastLongVacationOrNew([
            'person_id' => $person->id,
        ]);
        $longVacation->fill($request->all());

        if (!$request->filled('long_vacation_compensation')) {
            $longVacation->long_vacation_compensation = false;
            $longVacation->long_vacation_compensation_sum = null;
        }

        $longVacation->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param BackActiveRequest $request
     * @param Person            $person
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function backToActive(BackActiveRequest $request, Person $person)
    {
        $longVacation = $person->lastLongVacation();

        if ($longVacation) {
            $longVacation->fill($request->all());
            $longVacation->save();
        }

        $person->quited_at = null;
        $person->quit_reason = null;
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param PayDataRequest $request
     * @param Person         $person
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function payData(PayDataRequest $request, Person $person)
    {
        $person->fill($request->all());
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param UpdateAvailableVacationsRequest $request
     * @param Person $person
     * @return bool
     * @throws \Throwable
     */
    public function updateAvailableVacations(UpdateAvailableVacationsRequest $request, Person $person)
    {
        $person->available_vacations += $request->available_vacations;

        return $person->saveOrFail();
    }

    /**
     * @param CompensateRequest $request
     * @param Person $person
     * @return bool
     * @throws \Throwable
     */
    public function compensate(CompensateRequest $request, Person $person)
    {
        if ($person->available_vacations > Vacation::VACATION_PAY_DAYS) {

            $date = $person->getCompensationDate($request->month);

            $person->compensated_days = $person->available_vacations - Vacation::VACATION_PAY_DAYS;
            $person->available_vacations -= $person->compensated_days;
            $person->compensate = false;
            $person->compensated_at = $date;

            $person->vacations()->create([
                'date' => $date,
                'calendar_month_id' => CalendarMonth::ofYear($date->year)
                    ->where('calendar_months.name', $date->monthName)
                    ->first()
                    ->id,
                'type' => VacationType::Actual,
                'payment_type' => VacationPaymentType::Paid,
                'days' => $person->compensated_days,
            ]);

            return $person->saveOrFail();
        }

        throw new BadRequestHttpException();
    }

    /**
     * @param Person $person
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Person $person)
    {
        return response()->json($person->toArray());
    }
}
