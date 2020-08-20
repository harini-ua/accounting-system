<?php

namespace App\Http\Controllers;

use App\DataTables\VacationsDataTable;
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

        return $dataTable->render('pages.vacation.index', compact('breadcrumbs', 'pageConfigs'));
    }
}
