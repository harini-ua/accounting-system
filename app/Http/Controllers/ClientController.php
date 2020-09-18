<?php

namespace App\Http\Controllers;

use App\DataTables\ClientsDataTable;
use App\DataTables\ContractsDataTable;
use App\Enums\ContractStatus;
use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Address;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Contract;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the clients.
     *
     * @param ClientsDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Clients')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return $dataTable->render('pages.client.index', compact('breadcrumbs', 'pageConfigs'));
    }

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('clients.index'), 'name' => __('Clients')],
            ['name' => __('Create')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.client.create', compact('pageConfigs', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in client.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientCreateRequest $request)
    {
        $client = new Client();
        $client->fill($request->all());
        $client->save();

        $this->attachBillingAddress($request, $client);
        $this->attachBank($request, $client);

        alert()->success($client->name, __('Create client has been successful'));

        return redirect()->route('clients.show', $client);
    }

    /**
     * Display the specified client.
     *
     * @param  Client $client
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Client $client)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('clients.index'), 'name' => __('Clients')],
            ['name' => $client->name]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $client->load(['addresses', 'contracts']);

        $dataTable = new ContractsDataTable($client->id);

        $closedContract = $client->contracts()->status(ContractStatus::CLOSED)->count();

        return $dataTable->render('pages.client.view', compact(
            'pageConfigs', 'client', 'closedContract', 'breadcrumbs'
        ));
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param  Client $client
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Client $client)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('clients.index'), 'name' => __('Clients')],
            ['name' => __('Edit Client')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $client->load('billingAddress');

        return view('pages.client.update', compact('pageConfigs', 'breadcrumbs', 'client'));
    }

    /**
     * Update the specified resource in client.
     *
     * @param ClientUpdateRequest $request
     * @param Client              $client
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientUpdateRequest $request, Client $client)
    {
        $client->fill($request->all());
        $client->save();

        $this->attachBillingAddress($request, $client);
        $this->attachBank($request, $client);

        alert()->success($client->name, __('Client data has been update successful'));

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from client.
     *
     * @param Client $client
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Client $client)
    {
        if ($client->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Client has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }

    /**
     * @param $clientId
     * @return mixed
     */
    public function clientContracts($clientId)
    {
        $contracts = Contract::where('client_id', $clientId)
            ->orderBy('name')->get()
            ->map(static function($contract) {
                return [
                    'id' => $contract->id,
                    'name' => $contract->name,
                ];
            });

        return $contracts->prepend(['id' => '', 'name' => __('- Select Contract -')]);
    }

    /**
     * @param Request $request
     * @param Client $client
     */
    private function attachBank(Request $request, Client $client)
    {
        if ($request->anyFilled(['bank_name', 'bank_address', 'account', 'iban', 'swift'])) {
            $bank = $client->bank ?: new Bank;
            $bank->fill($request->only(['account', 'iban', 'swift']));
            $bank->name = $request->bank_name;
            $bank->address = $request->bank_address;
            $client->bank()->save($bank);
        }
    }

    /**
     * @param Request $request
     * @param Client $client
     */
    private function attachBillingAddress(Request $request, Client $client)
    {
        if ($request->anyFilled(['country', 'city', 'state', 'address', 'postal_code'])) {
            $address = $client->billingAddress ?: new Address;
            $address->fill($request->only(['country', 'city', 'state', 'address', 'postal_code']));
            $client->billingAddress()->save($address);
        }
    }
}
