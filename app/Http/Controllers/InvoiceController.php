<?php

namespace App\Http\Controllers;

use App\DataTables\InvoicesDataTable;
use App\Enums\InvoiceStatus;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Wallet;
use App\Services\Formatter;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __("Invoices")]
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $clients = Client::with('contracts.invoices')
            ->has('contracts.invoices')->orderBy('name')->get();

        $status = InvoiceStatus::toCollection();

        return $dataTable->render('pages.invoice.index', compact(
            'pageConfigs', 'breadcrumbs', 'clients', 'status'
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

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $clients = Client::with('contracts')->orderBy('name')->get();
        $wallets = Wallet::with('accounts.accountType')->orderBy('name')->get();

        $sales = User::where('position_id', 5)->get();

        $config = config('invoices');
        $image = $config['logo'];

        return view('pages.invoice.create', compact(
            'breadcrumbs', 'pageConfigs', 'clients', 'wallets', 'sales', 'config', 'image'
        ));
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
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('invoices.index'), 'name' => __('Invoices')],
            ['name' => $invoice->number],
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $invoice->load(['items' => static function ($query) {
            $query->orderBy('created_at');
        }, 'contract.client.billingAddress', 'account.accountType']);

        $client = $invoice->contract->client;

        $billFrom = [];

        $billTo = [
            'company' => $client->company_name,
            'address' => Formatter::address($client->billingAddress),
            'email' => $client->email,
            'phone' => $client->phone,
        ];

        $sum = $invoice->items()->sum('sum');

        $config = config('invoices');
        $image = $config['logo'];

        return view('pages.invoice.view', compact(
            'breadcrumbs', 'pageConfigs', 'invoice', 'billFrom', 'billTo', 'sum', 'config', 'image'
        ));
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
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('invoices.index'), 'name' => __('Invoices')],
            ['name' => $invoice->number],
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $invoice->load(['contract', 'items' => static function ($query) {
            $query->orderBy('created_at');
        }], 'payments');

        $clients = Client::with('contracts')->orderBy('name')->get();
        $wallets = Wallet::with('accounts.accountType')->orderBy('name')->get();

        $sales = User::where('position_id', 5)->get();

        $invoice->client_id = $invoice->contract->client_id;
        $invoice->wallet_id = $invoice->account->wallet_id;


        $config = config('invoices');
        $image = $config['logo'];

        return view('pages.invoice.update', compact(
            'breadcrumbs', 'pageConfigs', 'invoice', 'clients', 'wallets', 'sales', 'config', 'image'
        ));
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
