<?php

namespace App\Http\Controllers;

use App\DataTables\SalaryReviewByQuarterDataTable;
use App\DataTables\SalaryReviewDataTable;
use App\Enums\SalaryReviewProfGrowthType;
use App\Enums\SalaryReviewReason;
use App\Enums\SalaryReviewType;
use App\Http\Requests\SalaryReviewCreateRequest;
use App\Http\Requests\SalaryReviewUpdateRequest;
use App\Models\CalendarYear;
use App\Models\Person;
use App\Models\SalaryReview;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SalaryReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SalaryReviewDataTable $dataTable
     *
     * @return Response
     */
    public function index(SalaryReviewDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Salary Reviews')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')->get()->map(
            static function ($calendarYear) {
                $calendarYear->id = $calendarYear->name;
                return $calendarYear;
            }
        );

        $year = $dataTable->year;

        return $dataTable->render('pages.salary-review.index', compact(
            'pageConfigs', 'breadcrumbs', 'calendarYears', 'year'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function quarter($year, $quarter)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('salary-reviews.index'), 'name' => __('Salary Reviews')],
            ['name' => __(integerToRoman($quarter) . " quarter $year year")]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $calendarYears = CalendarYear::orderBy('name')
            ->get()->map(static function ($calendarYear) {
                $calendarYear->id = $calendarYear->name;
                return $calendarYear;
            });

        $dataTable = new SalaryReviewByQuarterDataTable($year, $quarter);

        return $dataTable->render('pages.salary-review.quarter', compact(
            'pageConfigs', 'breadcrumbs', 'calendarYears', 'year', 'quarter'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('salary-reviews.index'), 'name' => __('Salary Reviews')],
            ['name' => __('Add Salary Review')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $people = Person::all();
        $types = SalaryReviewType::toCollection();
        $reasons = SalaryReviewReason::toCollection();
        $profGrowthTypes = SalaryReviewProfGrowthType::toCollection();

        return view('pages.salary-review.create', compact(
            'breadcrumbs', 'pageConfigs', 'people', 'types', 'reasons', 'profGrowthTypes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SalaryReviewCreateRequest $request
     *
     * @return RedirectResponse
     */
    public function store(SalaryReviewCreateRequest $request)
    {
        SalaryReview::create($request->all());

        alert()->success(__('Success'), __('Salary review has been successful'));

        return redirect()->route('salary-reviews.index');
    }

    /**
     * Display the specified resource.
     *
     * @param SalaryReview $salaryReview
     *
     * @return Application|Factory|View
     */
    public function show(SalaryReview $salaryReview)
    {
        $salaryReview->load(['person']);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('salary-reviews.index'), 'name' => __('Salary Reviews')],
            ['name' => $salaryReview->person->name]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.salary-review.show', compact(
            'breadcrumbs', 'pageConfigs', 'salaryReview'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SalaryReview $salaryReview
     *
     * @return Application|Factory|View
     */
    public function edit(SalaryReview $salaryReview)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('salary-reviews.index'), 'name' => __('Salary Reviews')],
            ['name' => __('Edit Salary Review')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $people = Person::all();
        $types = SalaryReviewType::toCollection();
        $reasons = SalaryReviewReason::toCollection();
        $profGrowthTypes = SalaryReviewProfGrowthType::toCollection();

        return view('pages.salary-review.update', compact(
            'breadcrumbs', 'pageConfigs', 'people', 'types', 'reasons', 'profGrowthTypes'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SalaryReviewUpdateRequest $request
     * @param SalaryReview $salaryReview
     *
     * @return RedirectResponse
     * @throws MassAssignmentException
     */
    public function update(SalaryReviewUpdateRequest $request, SalaryReview $salaryReview)
    {
        $salaryReview->fill($request->all());
        $salaryReview->save();

        alert()->success(__('Success!'), __('Salary review data has been update successful'));

        return redirect()->route('salary-reviews.show', $salaryReview);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SalaryReview $salaryReview
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(SalaryReview $salaryReview)
    {
        if ($salaryReview->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
