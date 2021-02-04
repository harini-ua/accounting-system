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
     * @param array $personIds
     * @param string|int $year
     * @param string|int $month
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

        $salaryPayments = $query->get()->chunk(config('general.payslip.per_page.default'));

        if ($salaryPayments->count() === 0) {
            alert()->success('Oops!', __('There are no payslip'));

            return back();
        }

        $calendarMonth = CalendarMonth::with('calendarYear')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->first()
        ;

        foreach ($salaryPayments as $key => $salaryPayment) {
            $column = config('general.payslip.per_page.available')[config('general.payslip.per_page.default')][1];
            $salaryPayments[$key] = collect(
                array_chunk($salaryPayment->toArray(), $column, false)
            );
        }

        ini_set('max_execution_time', 0);

        $this->pdf->loadView('pdf.payslip.grid', compact(
            'calendarMonth', 'salaryPayments', 'year', 'month'
        ));

        return $this->pdf->download($filename.'.pdf');
//        return view('pdf.payslip.grid', compact(
//            'calendarMonth', 'salaryPayments', 'year', 'month'
//        ));
    }
}
