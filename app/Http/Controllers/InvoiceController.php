<?php

namespace App\Http\Controllers;

use App\DataTables\InvoicesDataTable;
use App\Models\Invoice;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param InvoicesDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InvoicesDataTable $dataTable)
    {
        $pageConfigs = ['pageHeader' => true];

        return $dataTable->render('pages.invoice.index', compact('pageConfigs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $pageConfigs = ['pageHeader' => true];

        return view('pages.invoice.create', compact('pageConfigs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $invoice = new Invoice();
        $invoice->fill($request->all());
        $invoice->save();

        alert()->success($invoice->number, __('Create invoice has been successful'));

        return redirect()->route('invoices.show', $invoice);
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Invoice $invoice)
    {
        $pageConfigs = ['pageHeader' => true];

        return view('pages.invoice.view', compact('pageConfigs', 'invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        $pageConfigs = ['pageHeader' => true];

        $invoice->load('contract');

        return view('pages.invoice.update', compact('pageConfigs', 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Invoice                  $invoice
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Invoice $invoice)
    {
        $invoice->fill($request->all());
        $invoice->save();

        alert()->success($invoice->numder, __('Invoice data has been update successful'));

        return redirect()->route('invoices.index');
    }

    /**
     * Download the specified resource to pdf file.
     *
     * @param Invoice $invoice
     *
     * @return \Illuminate\Http\Response
     */
    public function download(Invoice $invoice)
    {
        $pdf = PDF::loadView('pdf.invoice.default', $invoice);
        $pdf->setPaper(
            config('invoices.paper.size'),
            config('invoices.paper.orientation')
        );

        return $pdf->download(sprintf('%s.pdf', $invoice->number));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Payment has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }
}
