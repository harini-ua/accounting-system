<?php

namespace App\Http\Controllers;

use App\DataTables\WalletDataTable;
use App\Http\Requests\WalletStoreRequest;
use App\Http\Requests\WalletUpdateRequest;
use App\Models\Account;
use App\Models\Wallet;
use App\Models\WalletType;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

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
     * @return RedirectResponse
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
     * @return Application|Factory|View
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
            'pageConfigs', 'breadcrumbs', 'wallet'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Wallet $wallet
     * @return Factory|View
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
     * @return RedirectResponse
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
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Wallet $wallet)
    {
        if ($wallet->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * @param $walletId
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function walletAccounts($walletId)
    {
        $accounts = Account::with(['accountType' => static function ($query) {
            $query->orderBy('name');
        }])
            ->where('wallet_id', $walletId)
            ->where('status', 1)
            ->get()
            ->map(static function ($account) {
                return [
                    'id' => $account->id,
                    'name' => $account->accountType->name,
                ];
            });

        return $accounts->prepend(['id' => '', 'name' => __('- Select Account -')]);
    }
}
