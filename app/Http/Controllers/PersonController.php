<?php

namespace App\Http\Controllers;

use App\DataTables\FormerPersonDataTable;
use App\Enums\PersonContractType;
use App\Enums\Position;
use App\Enums\Currency;
use App\Enums\SalaryType;
use App\Http\Requests\Person\BackActiveRequest;
use App\Http\Requests\Person\ChangeContractTypeRequest;
use App\Http\Requests\Person\ChangeSalaryTypeRequest;
use App\Http\Requests\Person\LongVacationRequest;
use App\Http\Requests\Person\MakeFormerRequest;
use App\Http\Requests\Person\PersonRequest;
use App\Models\Person;
use App\User;
use App\DataTables\PersonDataTable;
use Illuminate\Http\Request;

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
            ['link' => route('home'), 'name' => "Home"],
            ['name' => "People"]
        ];
        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.person.index', compact('pageConfigs', 'breadcrumbs'));
    }

    /**
     * @param FormerPersonDataTable $dataTable
     * @return mixed
     */
    public function formerList(FormerPersonDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('people.index'), 'name' => "People"],
            ['name' => "Former Employees"]
        ];
        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.person.former-list', compact('pageConfigs', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('people.index'), 'name' => "People"],
            ['name' => "Add Person"]
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $positions = Position::toCollection();
        $currencies = Currency::toCollection();
        $salaryTypes = SalaryType::toCollection();
        $contractTypes = PersonContractType::toCollection();
        $recruiters = User::where('position_id', Position::Recruiter())->get();

        return view('pages.person.create', compact('breadcrumbs', 'pageConfigs', 'positions',
            'currencies', 'salaryTypes', 'contractTypes', 'recruiters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PersonRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonRequest $request)
    {
        $person = Person::create($request->all());

        return redirect()->route('people.show', $person);
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
     * @param  Person $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('people.index'), 'name' => "People"],
            ['name' => "Edit Person"]
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $model = $person;
        $positions = Position::toCollection();
        $currencies = Currency::toCollection();
        $salaryTypes = SalaryType::toCollection();
        $contractTypes = PersonContractType::toCollection();
        $recruiters = User::where('position_id', Position::Recruiter())->get();

        return view('pages.person.edit', compact('breadcrumbs', 'pageConfigs', 'model', 'positions',
            'currencies', 'salaryTypes', 'contractTypes', 'recruiters'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PersonRequest $request
     * @param  Person $person
     * @return \Illuminate\Http\Response
     */
    public function update(PersonRequest $request, Person $person)
    {
        $person->fill($request->all());
        if (!$request->filled('growth_plan')) {
            $person->growth_plan = 0;
        }
        if (!$request->filled('team_lead')) {
            $person->team_lead = 0;
            $person->team_lead_reward = 0;
        }
        if (!$request->filled('tech_lead')) {
            $person->tech_lead = 0;
            $person->tech_lead_reward = 0;
        }
        if (!$request->filled('bonuses')) {
            $person->bonuses = 0;
            $person->bonuses_reward = 0;
        }
        $person->save();

        return redirect()->route('people.show', $person);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Person $person
     * @return \Illuminate\Http\Response
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
     * @param Person $person
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeSalaryType(ChangeSalaryTypeRequest $request, Person $person)
    {
        $person->fill($request->all());
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param ChangeContractTypeRequest $request
     * @param Person $person
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeContractType(ChangeContractTypeRequest $request, Person $person)
    {
        $person->fill($request->all());
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param MakeFormerRequest $request
     * @param Person $person
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeFormer(MakeFormerRequest $request, Person $person)
    {
        $person->fill($request->all());
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param LongVacationRequest $request
     * @param Person $person
     * @return \Illuminate\Http\JsonResponse
     */
    public function longVacation(LongVacationRequest $request, Person $person)
    {
        $person->fill($request->all());
        if (!$request->filled('long_vacation_compensation')) {
            $person->long_vacation_compensation = 0;
            $person->long_vacation_compensation_sum = 0;
        }
        $person->long_vacation_finished_at = null;
        $person->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param BackActiveRequest $request
     * @param Person $person
     * @return \Illuminate\Http\JsonResponse
     */
    public function backToActive(BackActiveRequest $request, Person $person)
    {
        $person->fill($request->all());
        $person->long_vacation_started_at = null;
        $person->long_vacation_reason = null;
        $person->long_vacation_compensation = false;
        $person->long_vacation_compensation_sum = null;
        $person->long_vacation_comment = null;
        $person->long_vacation_plan_finished_at = null;
        $person->save();

        return response()->json(['success' => true]);
    }
}
