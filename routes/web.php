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
    Route::resource('users', 'UserController');
    Route::get('/user-profile', 'UserController@userProfile')->name('user.profile');
    Route::put('/user-profile', 'UserController@profileUpdate')->name('user.profile.update');

    // Wallets
    Route::resource('wallets', 'WalletController');

    // Accounts
    Route::resource('accounts', 'AccountController');

    // Money Flows
    Route::resource('money-flows', 'MoneyFlowController');
    Route::get('walletAccounts/{walletId}', 'MoneyFlowController@walletAccounts');

    // Invoices example
    //Route::resource('invoices', 'InvoiceController');
    Route::get('/app-invoice-list', 'InvoiceController@invoiceList');
    Route::get('/app-invoice-view', 'InvoiceController@invoiceView');
    Route::get('/app-invoice-edit', 'InvoiceController@invoiceEdit');
    Route::get('/app-invoice-add', 'InvoiceController@invoiceAdd');

});

