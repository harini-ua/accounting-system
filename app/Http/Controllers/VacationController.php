<?php

namespace App\Http\Controllers;

use App\DataTables\VacationMonthDataTable;
use App\DataTables\VacationsDataTable;
use App\Enums\VacationPaymentType;
use App\Http\Requests\VacationDeleteRequest;
use App\Http\Requests\VacationRequest;
use App\Models\CalendarMonth;
use App\Models\CalendarYear;
use App\Models\Vacation;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VacationController extends Controller
{
    /**
     * @param VacationsDataTable $dataTable
     * @return mixed
     */
    public function index(VacationsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Vacations')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')->get()->map(function($calendarYear) {
            $calendarYear->id = $calendarYear->name;
            return $calendarYear;
        });
        $year = $dataTable->year;

        return $dataTable->render('pages.vacation.index', compact(
            'breadcrumbs', 'pageConfigs', 'calendarYears', 'year'
        ));
    }

    /**
     * @param $year
     * @param $month
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
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
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('vacations.index'), 'name' => __('Vacations')],
            ['name' => "$monthName $year"]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $days = $datatable->days();

        return view('pages.vacation.month', compact(
            'breadcrumbs', 'pageConfigs', 'year', 'month', 'monthName', 'days'
        ));
    }

    /**
     * @param VacationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VacationRequest $request)
    {
        $fields = $request->except(['type', 'date']);
        $date = $fields['date'] = Carbon::parse($request->get('date'));
        $vacation = Vacation::firstOrNew($fields);
        $vacation->type = $request->get('type');
        $vacation->calendar_month_id = CalendarMonth::ofYear($date->year)->where('calendar_months.name', $date->monthName)->first()->id;

        if ($request->payment_type === VacationPaymentType::Paid && $date < Carbon::parse($vacation->person->start_date)->addMonths(2)) {
            throw new BadRequestHttpException('Person have to work more than 2 months for vacation!');
        }

        if ($vacation->date === $vacation->person->compensated_at) {
            throw new BadRequestHttpException('Compensated vacations cannot be changed!');
        }

        if ($vacation->save()) {
            return response()->json($vacation, 201);
        }

        return response()->json([], 500);
    }

    /**
     * @param VacationDeleteRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(VacationDeleteRequest $request)
    {
        $vacation = Vacation::where('date', Carbon::parse($request->get('date')))
            ->where('person_id', $request->get('person_id'))
            ->where('payment_type', $request->get('payment_type'))
            ->firstOrFail();

        if ($vacation->date === $vacation->person->compensated_at) {
            throw new BadRequestHttpException('Compensated vacations cannot be deleted!');
        }

        if ($vacation->delete()) {
            return response('', 204);
        }

        throw new HttpException(500);
    }
}
