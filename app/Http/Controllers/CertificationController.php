<?php

namespace App\Http\Controllers;

use App\DataTables\CertificationsDataTable;
use App\Http\Requests\CertificationCreateRequest;
use App\Http\Requests\CertificationUpdateRequest;
use App\Models\Certification;
use App\Models\Person;
use Exception;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CertificationsDataTable $dataTable
     *
     * @return Response
     */
    public function index(CertificationsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __("Certifications")]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $people = Person::orderBy('name')->get();

        return $dataTable->render('pages.certifications.index', compact(
            'breadcrumbs', 'pageConfigs', 'people'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CertificationCreateRequest $request
     *
     * @return RedirectResponse
     * @throws MassAssignmentException
     */
    public function store(CertificationCreateRequest $request)
    {
        $certification = new Certification();
        $certification->fill($request->all());
        $certification->save();

        alert()->success($certification->name, __('Create certification has been successful'));

        return redirect()->route('certifications.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Certification $certification
     *
     * @return View
     */
    public function edit(Certification $certification)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('certifications.index'), 'name' => __('Certifications')],
            ['name' => $certification->name]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $people = Person::all();

        return view('pages.certifications.update', compact(
            'breadcrumbs', 'pageConfigs', 'certification', 'people'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CertificationUpdateRequest $request
     * @param Certification $certification
     *
     * @return RedirectResponse
     * @throws MassAssignmentException
     */
    public function update(CertificationUpdateRequest $request, Certification $certification)
    {
        $certification->fill($request->all());
        $certification->save();

        alert()->success($certification->name, __('Certification data has been update successful'));

        return redirect()->route('certifications.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Certification $certification
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Certification $certification)
    {
        if ($certification->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Certification has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }
}
