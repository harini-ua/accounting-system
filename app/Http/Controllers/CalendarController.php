<?php

namespace App\Http\Controllers;

use App\Enums\Month;
use App\Http\Requests\CalendarMonthUpdateRequest;
use App\Models\CalendarMonth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $months = CalendarMonth::select('calendar_months.*')
            ->join('calendar_years', 'calendar_years.id', '=', 'calendar_months.calendar_year_id')
            ->where('calendar_years.name', Carbon::now())
            ->get();

        return view('pages.calendar.index', compact('months'));
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
}
