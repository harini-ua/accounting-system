<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayCreateRequest;
use App\Http\Requests\HolidayUpdateRequest;
use App\Models\Holiday;
use Exception;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class HolidayController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Throwable
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
     * @param Holiday $holiday
     *
     * @return JsonResponse
     * @throws MassAssignmentException
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
     * @param Holiday $holiday
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Holiday $holiday)
    {
        if ($holiday->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
