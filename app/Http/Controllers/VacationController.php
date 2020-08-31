<?php

namespace App\Http\Controllers;

use App\DataTables\VacationsDataTable;
use App\Models\CalendarYear;
use Illuminate\Http\Request;

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
        dump($year, $month);
    }
}
