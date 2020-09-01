<?php

namespace App\Http\Controllers;

use App\DataTables\VacationMonthDataTable;
use App\DataTables\VacationsDataTable;
use App\Models\CalendarYear;
use Illuminate\Support\Carbon;

class VacationController extends Controller
{
    public function index(VacationsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['name' => "Vacations"]
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')->get()->map(function($calendarYear) {
            $calendarYear->id = $calendarYear->name;
            return $calendarYear;
        });

        return $dataTable->render('pages.vacation.index', compact('breadcrumbs', 'pageConfigs', 'calendarYears'));
    }

    public function month($year, $month)
    {
        if (!CalendarYear::where('name', $year)->exists() || !($month >= 1 && $month <= 12)) {
            abort(404);
        }

        $datatable = new VacationMonthDataTable($year, $month);
        if ($datatable->request()->ajax()) {
            return $datatable->ajax();
        }

        $monthName = Carbon::createFromDate($year, $month)->monthName;

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['link' => route('vacations.index'), 'name' => "Vacations"],
            ['name' => "$monthName $year"]
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $days = $datatable->days();

        return view('pages.vacation.month', compact('breadcrumbs', 'pageConfigs', 'year', 'month', 'monthName', 'days'));
    }
}
