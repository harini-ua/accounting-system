<?php

namespace App\Http\Controllers;

use App\DataTables\ContractsDataTable;
use App\DataTables\InvoicesByContractDataTable;
use App\Enums\ContractStatus;
use App\Enums\Position;
use App\Http\Requests\ContractCreateRequest;
use App\Http\Requests\ContractUpdateRequest;
use App\Models\Client;
use App\Models\Contract;
use App\User;

class ContractController extends Controller
{
    /**
     * Display a listing of the clients.
     *
     * @param ContractsDataTable $dataTable
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContractsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Contracts')]
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $clients = Client::all()->sortBy('name')
            ->pluck('name', 'id')->toArray();
        $clientsToCollection = Client::all()->sortBy('name');

        $salesManagersToCollection = User::byPosition(Position::SalesManager)->get();

        $salesManagers = User::byPosition(Position::SalesManager)->get()
            ->pluck('name', 'id')->toArray();

        $statusToCollection = ContractStatus::toCollection();
        $status = ContractStatus::toSelectArray();

        return $dataTable->render('pages.contract.index', compact(
            'pageConfigs', 'breadcrumbs', 'clients', 'salesManagers', 'salesManagersToCollection', 'status', 'clientsToCollection' ,'statusToCollection'
        ));
    }

    /**
     * Show the form for creating a new contract.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => 'javascript:void(0)', 'name' => __('Contract')],
            ['name' => __('Create')]
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $clients = Client::all()
            ->sortBy('name')
            ->pluck('name', 'id')->toArray();

        $salesManagers = User::byPosition(Position::SalesManager)->get()
            ->pluck('name', 'id')->toArray();

        $status = ContractStatus::toSelectArray();

        return view('pages.contract.create', compact(
            'pageConfigs', 'breadcrumbs', 'clients', 'salesManagers', 'status'
        ));
    }

    /**
     * Store a newly created resource in client.
     *
     * @param ContractCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContractCreateRequest $request)
    {
        $contract = new Contract();
        $contract->fill($request->all());
        $contract->save();

        alert()->success($contract->name, __('Create Contract has been successful'));

        return redirect()->route('contracts.show', $contract);
    }

    /**
     * Display the specified contract.
     *
     * @param  Contract $contract
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Contract $contract)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('contracts.index'), 'name' => __('Contract')],
            ['name' => $contract->name]
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $contract->load(['client', 'manager', 'invoices']);

        $dataTable = new InvoicesByContractDataTable($contract);

        return $dataTable->render('pages.contract.view', compact(
            'pageConfigs', 'breadcrumbs', 'contract'
        ));
    }

    /**
     * Show the form for editing the specified contract.
     *
     * @param  Contract $contract
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Contract $contract)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => 'javascript:void(0)', 'name' => __('Contract')],
            ['name' => __('Edit Contract')]
        ];

        $pageConfigs = ['bodyCustomClass' => 'app-page', 'pageHeader' => true, 'isFabButton' => true];

        $contract->load('client');

        $clients = Client::all()->sortBy('name')
            ->pluck('name', 'id')->toArray();

        $salesManagers = User::byPosition(Position::SalesManager)->get()
            ->sortBy('name')->pluck('name', 'id')->toArray();

        $status = ContractStatus::toSelectArray();

        return view('pages.contract.update', compact(
            'pageConfigs', 'breadcrumbs', 'contract', 'clients', 'salesManagers', 'status'
        ));
    }

    /**
     * Update the specified resource in contract.
     *
     * @param ContractUpdateRequest $request
     * @param Contract              $contract
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ContractUpdateRequest $request, Contract $contract)
    {
        $contract->fill($request->all());
        $contract->save();

        alert()->success($contract->name, __('Contract data has been update successful'));

        return redirect()->route('contracts.index');
    }

    /**
     * Remove the specified resource from contract.
     *
     * @param Contract $contract
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Contract $contract)
    {
        if ($contract->delete()) {
            return response()->json([
                'success' => true,
                'message' => __('Contract has been deleted successfully.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong. Try again.')
        ]);
    }
}
