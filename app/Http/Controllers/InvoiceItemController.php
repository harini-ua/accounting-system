<?php

namespace App\Http\Controllers;

use App\DataTables\InvoiceItemsDataTable;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param InvoiceItemsDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InvoiceItemsDataTable $dataTable)
    {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.invoice-items.index', compact('pageConfigs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.invoice-items.create', compact('pageConfigs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function store(Request $request)
    {
        $invoiceItem = new InvoiceItem();
        $invoiceItem->fill($request->all());
        $invoiceItem->save();

        alert()->success($invoiceItem->name, __('Create invoice item item has been successful'));

        return redirect()->route('invoice-items.show', $invoiceItem);
    }

    /**
     * Display the specified resource.
     *
     * @param InvoiceItem $invoiceItem
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(InvoiceItem $invoiceItem)
    {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.invoice-items.view', compact('pageConfigs', 'invoiceItem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InvoiceItem $invoiceItem
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(InvoiceItem $invoiceItem)
    {
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $invoiceItem->load('invoice');

        return view('pages.invoice-items.update', compact('pageConfigs', 'invoiceItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param InvoiceItem              $invoiceItem
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function update(Request $request, InvoiceItem $invoiceItem)
    {
        $invoiceItem->fill($request->all());
        $invoiceItem->save();

        alert()->success($invoiceItem->name, __('Payment data has been update successful'));

        return redirect()->route('invoice-items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InvoiceItem $invoiceItem
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(InvoiceItem $invoiceItem)
    {
        if ($invoiceItem->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Invoice item has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }
}
