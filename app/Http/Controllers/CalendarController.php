<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarMonthUpdateRequest;
use App\Models\CalendarMonth;
use App\Models\CalendarYear;
use App\Models\Holiday;
use App\Services\CalendarPaginator;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * @param CalendarPaginator $paginator
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(CalendarPaginator $paginator)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Home"],
            ['name' => "Calendar"]
        ];
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $months = CalendarMonth::ofYear($paginator->year())->get();
        $holidays = Holiday::ofYear($paginator->year())->orderBy('date')->get();

        return view('pages.calendar.index', compact(
            'breadcrumbs', 'pageConfigs', 'months', 'holidays', 'paginator'
        ));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $last = CalendarYear::orderBy('name', 'DESC')->first()->name;

        $year = new CalendarYear;
        $year->name = ++ $last ?? Carbon::now()->year;
        $year->save();

        return redirect()->route('calendar.index', ['year' => $year->name]);
    }

    /**
     * @param $year
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($year)
    {
        $calendarYear = CalendarYear::where('name', $year)->firstOrFail();
        if ($calendarYear->delete()) {
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }

    /**
     * @param CalendarMonthUpdateRequest $request
     * @param CalendarMonth $calendarMonth
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMonth(CalendarMonthUpdateRequest $request, CalendarMonth $calendarMonth)
    {
        $calendarMonth->{$request->field} = $request->value;
        $calendarMonth->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param $year
     * @return mixed
     */
    public function months($year)
    {
        return CalendarMonth::ofYear($year)
            ->get()
            ->toJson(JSON_NUMERIC_CHECK);
    }

    /**
     * @param $calendarYearId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function yearMonths($calendarYearId)
    {
        $calendarMonths = CalendarMonth::where('calendar_year_id', $calendarYearId)->get();

        return $calendarMonths->prepend(['id' => '', 'name' => __('- Select Month -')]);
    }
}
