<?php

namespace App\Http\Controllers;

use App\DataTables\BonusesByRecruitDataTable;
use App\DataTables\BonusesRecruitersDataTable;
use App\DataTables\BonusesSalesManagersDataTable;
use App\DataTables\InvoicesBonusesDataTable;
use App\Enums\Currency;
use App\Http\Requests\BonusesShowRequest;
use App\Models\CalendarMonth;
use App\Models\CalendarYear;
use App\Models\Person;
use App\Models\Position;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class BonusController extends Controller
{
    protected $supportPosition = [
        \App\Enums\Position::SalesManager,
        \App\Enums\Position::Recruiter
    ];

    /**
     * Display a listing of the bonuses.
     */
    public function index()
    {
        return $this->listBoneses();
    }

    /**
     * Display a listing of the bonuses by position.
     *
     * @param Position|null $position
     *
     * @return Application|Factory|View|mixed
     */
    public function byPosition(Position $position)
    {
        return $this->listBoneses($position);
    }

    /**
     * @param Position|null $position
     *
     * @return Application|Factory|View|mixed
     */
    private function listBoneses(Position $position = null)
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
                $dataTable = new BonusesSalesManagersDataTable();
                break;
        }

        $year = $dataTable->year;

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __("Bonuses")],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')->get()->map(
            static function ($calendarYear) {
                $calendarYear->id = $calendarYear->name;
                return $calendarYear;
            }
        );

        $positions = Position::whereIn('id', $this->supportPosition)->get();

        return $dataTable->render('pages.bonuses.index', compact(
            'breadcrumbs', 'pageConfigs', 'calendarYears', 'year', 'positions', 'position'
        ));
    }

    /**
     * Display the specified client.
     *
     * @param BonusesShowRequest $request
     * @param Person $person
     *
     * @return Application|Factory|View
     */
    public function show(BonusesShowRequest $request, Person $person)
    {
        if (!in_array($person->position_id, $this->supportPosition, true)) {
            return view('errors.404');
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('bonuses.index'), 'name' => __('Bonuses')],
            ['name' => $person->name]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $filters = $request->query();

        switch ($person->position_id) {
            case \App\Enums\Position::Recruiter:
                $dataTable = new BonusesByRecruitDataTable($person, $filters);
                break;
            case \App\Enums\Position::SalesManager:
            default:
                $dataTable = new InvoicesBonusesDataTable($person, $filters);
        }

        $calendarYears = CalendarYear::orderBy('name')->get()
            ->map(static function ($calendarYear) {
                $calendarYear->id = $calendarYear->name;
                return $calendarYear;
            }
            );

        $calendarMonths = CalendarMonth::orderBy('id')->get();

        $currency = Currency::toCollection();

        return $dataTable->render("pages.bonuses.view", compact(
            'breadcrumbs', 'pageConfigs', 'person', 'filters', 'calendarYears', 'calendarMonths', 'currency'
        ));
    }
}
