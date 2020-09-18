<?php

namespace App\Http\Controllers;

use App\DataTables\OffersDataTables;
use App\Http\Requests\OfferCreateRequest;
use App\Http\Requests\OfferUpdateRequest;
use App\Models\Offer;
use App\Models\Person;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OffersDataTables $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OffersDataTables $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __("Offers")]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $people = Person::orderBy('name')->whereNotNull('quited_at')->get();

        return $dataTable->render('pages.offers.index', compact(
            'breadcrumbs', 'pageConfigs', 'people'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('invoices.index'), 'name' => __('Invoices')],
            ['name' => __('Create')],
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $people = Person::whereDoesntHave('offer')
            ->whereNotNull('quited_at')
            ->orderBy('name')->get();

        return view('pages.offers.create', compact(
            'breadcrumbs', 'pageConfigs', 'people'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OfferCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function store(OfferCreateRequest $request)
    {
        $hasOffer = Person::whereId($request->get('employee_id'))->has('offer')->first();

        if ($hasOffer) {
            alert()->warning(__('Attention!'), __('The employee already has offer'));
        }

        $offer = new Offer();
        $offer->fill($request->all());
        $offer->save();

        $offer->load('employee');

        alert()->success($offer->employee->name, __('Create offer has been successful'));

        return redirect()->route('offers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Offer $offer
     *
     * @return \Illuminate\View\View
     */
    public function edit(Offer $offer)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('offers.index'), 'name' => __('Offers')],
            ['name' => __('Edit Offer')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $people = Person::whereId($offer->employee_id)
            ->orWhereDoesntHave('offer')
            ->whereNotNull('quited_at')
            ->orderBy('name')->get();

        return view('pages.offers.update', compact(
            'breadcrumbs', 'pageConfigs', 'offer', 'people'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OfferUpdateRequest $request
     * @param Offer              $offer
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function update(OfferUpdateRequest $request, Offer $offer)
    {
        $offer->fill($request->all());

        if ($request->filled('salary_review')) {
            $offer->sum = null;
            $offer->salary_after_review = null;
        }

        $offer->save();

        $offer->load('employee');

        alert()->success($offer->employee->name, __('Offer data has been update successful'));

        return redirect()->route('offers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Offer $offer
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Offer $offer)
    {
        if ($offer->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Offer has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }
}
