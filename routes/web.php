<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function() {

    Route::get('/', 'DashboardController@index')->name('home');

    // Users
    Route::resource('users', 'UserController')->except(['show']);
    Route::get('/user-profile', 'UserController@userProfile')->name('user.profile');
    Route::put('/user-profile', 'UserController@profileUpdate')->name('user.profile.update');

    // Wallets
    Route::resource('wallets', 'WalletController')->except(['create', 'edit', 'update']);

    // Accounts
    Route::resource('accounts', 'AccountController')->only(['index', 'edit', 'update']);

    // Money Flows
    Route::resource('money-flows', 'MoneyFlowController')->except(['show']);
    Route::get('walletAccounts/{walletId}', 'MoneyFlowController@walletAccounts');

    // Invoices example
    //Route::resource('invoices', 'InvoiceController');
    Route::get('/app-invoice-list', 'InvoiceController@invoiceList');
    Route::get('/app-invoice-view', 'InvoiceController@invoiceView');
    Route::get('/app-invoice-edit', 'InvoiceController@invoiceEdit');
    Route::get('/app-invoice-add', 'InvoiceController@invoiceAdd');

    // CLIENTS
    Route::group(['prefix' => 'clients'], static function() {
        Route::get('/', 'ClientController@index')->name('clients.index');
        Route::get('/create', 'ClientController@create')->name('clients.create');
        Route::post('/', 'ClientController@store')->name('clients.store');
        Route::get('/{client}', 'ClientController@show')->name('clients.show');
        Route::get('/{client}/edit', 'ClientController@edit')->name('clients.edit');
        Route::put('/{client}', 'ClientController@update')->name('clients.update');
        Route::delete('/{client}/delete', 'ClientController@destroy')->name('clients.destroy');
    });

    // CONTRACTS
    Route::group(['prefix' => 'contracts'], static function() {
        Route::get('/', 'ContractController@index')->name('contracts.index');
        Route::get('/create', 'ContractController@create')->name('contracts.create');
        Route::post('/', 'ContractController@store')->name('contracts.store');
        Route::get('/{contract}', 'ContractController@show')->name('contracts.show');
        Route::get('/{contract}/edit', 'ContractController@edit')->name('contracts.edit');
        Route::put('/{contract}', 'ContractController@update')->name('contracts.update');
        Route::delete('/{contract}/delete', 'ContractController@destroy')->name('contracts.destroy');
    });
});

