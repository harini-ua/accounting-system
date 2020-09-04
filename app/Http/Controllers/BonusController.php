<?php

namespace App\Http\Controllers;

use App\DataTables\BonusesRecruitersDataTable;
use App\DataTables\BonusesSalesManagersDataTable;
use App\Enums\BonusType;
use App\Http\Requests\BonusCreateRequest;
use App\Http\Requests\BonusUpdateRequest;
use App\Models\Bonus;
use App\Models\CalendarYear;
use App\Models\Person;
use App\Models\Position;
use Illuminate\Http\Request;
use function Symfony\Component\VarDumper\Dumper\esc;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Position|null $position
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Position $position = null)
    {
        $supportPosition = [
            \App\Enums\Position::SalesManager,
            \App\Enums\Position::Recruiter
        ];

        // Set default position
        $position = $position ?? Position::find(\App\Enums\Position::SalesManager);

        if (!in_array($position->id, $supportPosition, true)) {
            return view('errors.404');
        }

        switch ($position->id) {
            case \App\Enums\Position::Recruiter:
                $dataTable = new BonusesRecruitersDataTable();
                break;
            case \App\Enums\Position::SalesManager:
            default:
                $dataTable = new BonusesSalesManagersDataTable();
        }

        $year = $dataTable->year;

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __("Bonuses")],
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')->get()->map(static function($calendarYear) {
            $calendarYear->id = $calendarYear->name;
            return $calendarYear;
        });

        $positions = Position::whereIn('id', $supportPosition)->get();

        return $dataTable->render('pages.bonuses.index', compact(
            'breadcrumbs', 'pageConfigs', 'calendarYears', 'year', 'positions', 'position'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BonusCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function store(BonusCreateRequest $request)
    {
        $person = Person::findOrFail($request->get('person_id'));
        $positions = [\App\Enums\Position::SalesManager, \App\Enums\Position::Recruiter];

        if (in_array($person->position_id, $positions, true)) {
            $bonus = new Bonus();
            $bonus->fill($request->all());
            $bonus->save();

            $value = ($bonus->type === BonusType::PERCENT) ? $bonus->value.' %' : $bonus->value;

            alert()->success($person->name.' - '.$value, __('Create bonus has been successful'));
        } else {
            alert()->warning(
                \App\Enums\Position::getDescription($person->position_id),
                __('Bonus for this position is not available')
            );
        }

        return redirect()->route('bonuses.index');
    }

    /**
     * Display the specified client.
     *
     * @param Person $person
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Person $person)
    {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('bonuses.index'), 'name' => __('Bonus')],
            ['name' => $person->name]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $person->load(['bonus']);

        $strPosition = strtolower(\App\Enums\Position::getDescription($person->position_id));

        return view("pages.bonuses.view._$strPosition", compact(
            'breadcrumbs', 'pageConfigs', 'person'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Bonus $bonus
     *
     * @return \Illuminate\View\View
     */
    public function edit(Bonus $bonus)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('bonuses.index'), 'name' => __('Bonuses')],
            ['name' => $bonus->name]
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $people = Person::whereIn('position_id', [\App\Enums\Position::SalesManager, \App\Enums\Position::Recruiter])
            ->orderBy('name')->get();

        return view('pages.bonuses.update', compact(
            'breadcrumbs', 'pageConfigs', 'bonus', 'people'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BonusUpdateRequest $request
     * @param Bonus              $bonus
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function update(BonusUpdateRequest $request, Bonus $bonus)
    {
        $person = Person::findOrFail($request->get('person_id'));
        $positions = [\App\Enums\Position::SalesManager, \App\Enums\Position::Recruiter];

        if (in_array($person->position_id, $positions, true)) {
            $bonus->fill($request->all());
            $bonus->save();

            $value = ($bonus->type === BonusType::PERCENT) ? $bonus->value.' %' : $bonus->value;

            alert()->success($person->name.' - '.$value, __('Bonus data has been update successful'));
        } else {
            alert()->warning(
                \App\Enums\Position::getDescription($person->position_id),
                __('Bonus for this position is not available')
            );
        }

        return redirect()->route('bonuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bonus $bonus
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Bonus $bonus)
    {
        if ($bonus->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Bonus has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
       ]);
    }
}
