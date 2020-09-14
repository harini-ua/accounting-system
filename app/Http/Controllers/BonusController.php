<?php

namespace App\Http\Controllers;

use App\DataTables\BonusesRecruitersDataTable;
use App\DataTables\BonusesSalesManagersDataTable;
use App\DataTables\BonusesByRecruitDataTable;
use App\DataTables\InvoicesBonusesDataTable;
use App\Http\Requests\BonusesShowRequest;
use App\Models\CalendarYear;
use App\Models\Person;
use App\Models\Position;

class BonusController extends Controller
{
    protected $supportPosition = [
        \App\Enums\Position::SalesManager,
        \App\Enums\Position::Recruiter
    ];

    /**
     * Display a listing of the resource.
     *
     * @param Position|null $position
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Position $position = null)
    {
        // set default position
        $position = $position ?? Position::find(\App\Enums\Position::SalesManager);

        if (!in_array($position->id, $this->supportPosition, true)) {
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

        $year = CalendarYear::whereName($dataTable->year)->first();

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __("Bonuses")],
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')->get()->map(static function($calendarYear) {
            $calendarYear->id = $calendarYear->name;
            return $calendarYear;
        });

        $positions = Position::whereIn('id', $this->supportPosition)->get();

        return $dataTable->render('pages.bonuses.index', compact(
            'breadcrumbs', 'pageConfigs', 'calendarYears', 'year', 'positions', 'position'
        ));
    }

    /**
     * Display the specified client.
     *
     * @param BonusesShowRequest $request
     * @param Person             $person
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(BonusesShowRequest $request, Person $person)
    {
        if (!in_array($person->position_id, $this->supportPosition, true)) {
            return view('errors.404');
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('bonuses.index', $person->position_id), 'name' => __('Bonuses')],
            ['name' => $person->name]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        switch ($person->position_id) {
            case \App\Enums\Position::Recruiter:
                $dataTable = new BonusesByRecruitDataTable($person, $request->query());
                break;
            case \App\Enums\Position::SalesManager:
            default:
                $dataTable = new InvoicesBonusesDataTable($person, $request->query());
        }

        return $dataTable->render("pages.bonuses.view", compact(
            'breadcrumbs', 'pageConfigs', 'person'
        ));
    }
}
