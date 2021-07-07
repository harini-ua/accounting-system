<?php

namespace App\Http\Controllers;

use App\DataTables\InvoicesDataTable;
use App\DataTables\PaymentsByInvoiceDataTable;
use App\Enums\InvoiceStatus;
use App\Enums\Position;
use App\Http\Requests\InvoiceCreateRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Http\Requests\PaymentCreateRequest;
use App\Models\Account;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Person;
use App\Models\Wallet;
use App\Services\Formatter;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceController extends Controller
{
    /** @var InvoiceService $invoiceService */
    public $invoiceService;

    /**
     * InvoiceController constructor.
     *
     * @param InvoiceService $invoiceService
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

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

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

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

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $clients = Client::with('contracts')->orderBy('name')->get();
        $wallets = Wallet::with(['accounts' => function($query){
            $query->where('accounts.status', '=', 1);
        }])->orderBy('name')->get();

        $sales = Person::where('position_id', Position::SalesManager)->get();

        $config = config('invoices');
        $image = $config['logo'];

        $accountCurrency = Account::with('accountType')->get()
            ->pluck('accountType.symbol', 'id');

        return view('pages.invoice.create', compact(
            'breadcrumbs', 'pageConfigs', 'clients', 'wallets', 'sales', 'config', 'image', 'accountCurrency'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function store(InvoiceCreateRequest $request)
    {
        $invoiceData = $request->except(['client_id', 'wallet_id']);

        $invoice = $this->invoiceService->save($invoiceData);

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

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $invoice->load(['items' => static function ($query) {
            $query->orderBy('created_at');
        }, 'payments', 'contract.client.billingAddress', 'account.accountType']);

        $client = $invoice->contract->client;

        $billFrom = [];

        $billTo = [
            'company' => $client->company_name,
            'address' => $client->billingAddress ? Formatter::address($client->billingAddress) : null,
            'email' => $client->email,
            'phone' => $client->phone,
        ];

        $sum = $invoice->items()->sum('sum');

        $config = config('invoices');
        $image = $config['logo'];

        $dataTable = new PaymentsByInvoiceDataTable($invoice);

        return $dataTable->render('pages.invoice.view', compact(
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

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $invoice->load(['contract', 'items' => static function ($query) {
            $query->orderBy('created_at');
        }], 'payments');

        $clients = Client::with('contracts')->orderBy('name')->get();
        $wallets = Wallet::with('accounts.accountType')->orderBy('name')->get();

        $sales = Person::where('position_id', Position::SalesManager)->get();

        $config = config('invoices');
        $image = $config['logo'];

        $accountCurrency = Account::with('accountType')->get()
            ->pluck('accountType.symbol', 'id');

        return view('pages.invoice.update', compact(
            'breadcrumbs', 'pageConfigs', 'invoice', 'clients', 'wallets', 'sales', 'config', 'image', 'accountCurrency'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InvoiceUpdateRequest $request
     * @param Invoice              $invoice
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice)
    {
        $invoiceData = $request->except(['client_id', 'wallet_id']);

        $invoice = $this->invoiceService->update($invoice, $invoiceData);

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
        $invoice->load(['items' => static function ($query) {
            $query->orderBy('created_at');
        }, 'contract.client.billingAddress', 'account.accountType']);

        $client = $invoice->contract->client;

        $image = config('invoices.logo');
        $image['src'] = asset($image['src']);

        $pdf = PDF::loadView('pdf.invoice.default', [
            'invoice' => $invoice,
            'billFrom' => [],
            'billTo' => [
                'company' => $client->company_name,
                'address' => Formatter::address($client->billingAddress),
                'email' => $client->email,
                'phone' => $client->phone,
            ],
            'sum' => $invoice->items()->sum('sum'),
            'config' => config('invoices'),
            'image' => $image
        ]);

        $pdf->setPaper(
            config('invoices.paper.size'),
            config('invoices.paper.orientation')
        );

        return $pdf->stream(sprintf('%s.pdf', $invoice->number));
    }

    /**
     * Add invoice payment.
     *
     * @param Invoice              $invoice
     * @param PaymentCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function payment(Invoice $invoice, PaymentCreateRequest $request)
    {
        $payment = new Payment();
        $payment->fill($request->all());

        $invoice->payments()->save($payment);

        if($invoice->payments()->sum('received_sum') >= $invoice->total){

            $invoice->status = InvoiceStatus::PAID;
            $invoice->save();
        }
        elseif($invoice->payments()->sum('received_sum') > 0 &&
            $invoice->payments()->sum('received_sum') < $invoice->total ) {

            $invoice->status = InvoiceStatus::DEBT;
            $invoice->save();
        }
        return response()->json([
            'success' => true,
            'message' => __('Payment has been created successfully.')
        ]);
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
                'message' => __('Invoice has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }
}
