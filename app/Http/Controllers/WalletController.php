<?php

namespace App\Http\Controllers;

use App\DataTables\WalletDataTable;
use App\Http\Requests\WalletStoreRequest;
use App\Http\Requests\WalletUpdateRequest;
use App\Models\Account;
use App\Models\Wallet;
use App\Models\WalletType;

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
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Wallets')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $walletTypes = WalletType::all();

        return $dataTable->render('pages.wallet.index', compact(
            'pageConfigs', 'breadcrumbs', 'walletTypes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WalletStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(WalletStoreRequest $request)
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
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('wallets.index'), 'name' => __('Wallets')],
            ['name' => __('Wallet')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        $wallet->load(['walletType', 'accounts.accountType']);

        return view('pages.wallet.show', compact(
            'pageConfigs', 'breadcrumbs','wallet'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Wallet $wallet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Wallet $wallet)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('wallets.index'), 'name' => __('Wallets')],
            ['name' => __('Edit Wallet')]
        ];

        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.wallet.edit', compact(
            'pageConfigs', 'breadcrumbs', 'wallet'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WalletUpdateRequest $request
     * @param Wallet $wallet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(WalletUpdateRequest $request, Wallet $wallet)
    {
        $wallet->fill($request->all());
        $wallet->save();

        return redirect()->route('wallets.index');
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

    /**
     * @param $walletId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function walletAccounts($walletId)
    {
        $accounts = Account::with(['accountType' => static function($query) {
            $query->orderBy('name');
        }])
            ->where('wallet_id', $walletId)
            ->where('status', 1)
            ->get()
            ->map(static function($account) {
                return [
                    'id' => $account->id,
                    'name' => $account->accountType->name,
                ];
            });

        return $accounts->prepend(['id' => '', 'name' => __('- Select Account -')]);
    }
}
