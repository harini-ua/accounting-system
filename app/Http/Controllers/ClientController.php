<?php

namespace App\Http\Controllers;

use App\DataTables\ClientsDataTable;
use App\DataTables\ContractsDataTable;
use App\Enums\ContractStatus;
use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //..
    }

    /**
     * Display a listing of the clients.
     *
     * @param ClientsDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientsDataTable $dataTable)
    {
        $pageConfigs = ['pageHeader' => true];

        return $dataTable->render('pages.client.index', compact('pageConfigs'));
    }

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => 'Home'],
            ['link' => 'javascript:void(0)', 'name' => 'Client'],
            ['name' => 'Create']
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.client.create', compact('pageConfigs', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in client.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientCreateRequest $request)
    {
        $client = new Client();
        $client->fill($request->all());
        $client->save();

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
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $client->load(['addresses', 'contracts']);

        $dataTable = new ContractsDataTable($client->id);

        $closedContract = $client->contracts()->status(ContractStatus::CLOSED)->count();

        return $dataTable->render('pages.client.view', compact(
            'pageConfigs', 'client', 'closedContract'
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
            ['link' => route('home'), 'name' => 'Home'],
            ['link' => 'javascript:void(0)', 'name' => 'Client'],
            ['name' => 'Update']
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $client->load('addresses');

        return view('pages.client.update', compact('pageConfigs', 'breadcrumbs', 'client'));
    }

    /**
     * Update the specified resource in client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Client $client
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientUpdateRequest $request, Client $client)
    {
        $client->fill($request->all());
        $client->save();

        alert()->success($client->name, __('Client data has been update successful'));

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from client.
     *
     * @param  Client $client
     *
     * @return \Illuminate\Http\JsonResponse
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
}
