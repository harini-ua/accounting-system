<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayCreateRequest;
use App\Http\Requests\HolidayUpdateRequest;
use App\Models\Holiday;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(HolidayCreateRequest $request)
    {
        $holiday = new Holiday;
        $holiday->fill($request->all());
        $holiday->saveOrFail();

        return response()->json([
            'success' => true,
            'holiday' => $holiday,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HolidayUpdateRequest $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayUpdateRequest $request, Holiday $holiday)
    {
        $holiday->fill($request->all());
        $holiday->save();

        return response()->json([
            'success' => true,
            'holiday' => $holiday,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Holiday $holiday)
    {
        if ($holiday->delete()) {
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }
}
