<?php

namespace App\Http\Controllers;

use App\Models\CalendarYear;
use App\Services\PayslipService;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    /** @var PayslipService $payslipService */
    public $payslipService;

    /**
     * InvoiceController constructor.
     *
     * @param PayslipService $payslipService
     */
    public function __construct(PayslipService $payslipService)
    {
        $this->payslipService = $payslipService;
    }

    public function index(Request $request)
    {
        if (!$request->has(['year', 'month'])) {
            abort(404);
        }

        $year = $request->get('year');
        $month = $request->get('month');

        if (!CalendarYear::where('name', $year)->exists() || !($month >= 1 && $month <= 12)) {
            abort(404);
        }

        $personIds = [];

        if ($request->has('person_id')) {
            $personIds = (array) $request->get('person_id');
        }

        return $this->payslipService->print($personIds, $year, $month);
    }
}
