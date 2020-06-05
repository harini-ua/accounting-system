<?php

namespace App\Http\Controllers;

use App\DataTables\WalletDataTable;
use App\Http\Requests\WalletRequest;
use App\Wallet;
use App\WalletType;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param WalletDataTable $dataTable
     * @return mixed
     */
    public function index(WalletDataTable $dataTable)
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];

        $walletTypes = WalletType::all();

        return $dataTable->render('pages.wallet.index', [
            'pageConfigs' => $pageConfigs,
            'walletTypes' => $walletTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WalletRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(WalletRequest $request)
    {
        $wallet = Wallet::create($request->all());
        $wallet->createAccounts();

        return redirect()->route('wallets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Wallet $wallet
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Wallet $wallet)
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];

        $wallet->load(['walletType', 'accounts.accountType']);

        return view('pages.wallet.show', [
            'pageConfigs' => $pageConfigs,
            'wallet' => $wallet,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Wallet $wallet
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Wallet $wallet)
    {
        if ($wallet->delete()) {
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }

}
