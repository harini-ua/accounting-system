<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentsGridDataTable;

class PaymentGridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PaymentsGridDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaymentsGridDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Payment Grid')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.payments.grid.index', compact(
            'breadcrumbs', 'pageConfigs'
        ));
    }
}
