<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayCreateRequest;
use App\Http\Requests\HolidayUpdateRequest;
use App\Models\Holiday;

class HolidayController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
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
     * Update the specified resource in storage.
     *
     * @param HolidayUpdateRequest $request
     * @param \App\Models\Holiday  $holiday
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
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
     *
     * @return \Illuminate\Http\JsonResponse
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
