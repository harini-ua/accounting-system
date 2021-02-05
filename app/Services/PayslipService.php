<?php

namespace App\Services;

use App\Models\CalendarMonth;
use App\Models\SalaryPayment;
use Barryvdh\DomPDF\PDF;

class PayslipService
{
    /** @var PDF  */
    private $pdf;

    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * @param array      $personIds
     * @param string|int $year
     * @param string|int $month
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function print(array $personIds, $year, $month)
    {
        $filename = "payslip-{$month}-{$year}";

        $query = SalaryPayment::with('person');
        if(!empty($personIds)) {
            if (count($personIds) === 1) {
                $filename .= "-#{$personIds[0]}";
            }
            $query->whereIn('person_id', $personIds);
        }
        $query->byDate($year, $month);
        $query->with('person');

        $salaryPayments = $query->get();

        if ($salaryPayments->count() === 0) {
            alert()->success('Oops!', __('There are no payslip'));

            return back();
        }

        $column = config('general.payslip.per_page.available')[config('general.payslip.per_page.default')][1];
        $fewColumn = $salaryPayments->count() < $column;

        $salaryPayments = $salaryPayments->chunk(config('general.payslip.per_page.default'));

        $calendarMonth = CalendarMonth::with('calendarYear')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->first()
        ;

        foreach ($salaryPayments as $key => $salaryPayment) {
            $salaryPayments[$key] = collect(
                array_chunk($salaryPayment->toArray(), $column, false)
            );
        }

        ini_set('max_execution_time', 0);

        $this->pdf->loadView('pdf.payslip.grid', compact(
            'calendarMonth', 'salaryPayments', 'year', 'month', 'fewColumn'
        ));

        return $this->pdf->download($filename.'.pdf');
//        return view('pdf.payslip.grid', compact(
//            'calendarMonth', 'salaryPayments', 'year', 'month', 'fewColumn'
//        ));
    }
}
