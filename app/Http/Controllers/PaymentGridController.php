<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentsGridDataTable;
use App\Models\CalendarYear;
use Illuminate\Http\Response;

class PaymentGridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PaymentsGridDataTable $dataTable
     *
     * @return Response
     */
    public function index(PaymentsGridDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Payment Grid')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $year = $dataTable->year;

        $calendarYears = CalendarYear::orderBy('name')->get()->map(function ($calendarYear) {
            $calendarYear->id = $calendarYear->name;
            return $calendarYear;
        });

        return $dataTable->render('pages.payments.grid.index', compact(
            'breadcrumbs', 'pageConfigs', 'calendarYears', 'year'
        ));
    }
}
