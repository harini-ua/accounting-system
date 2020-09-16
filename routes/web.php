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
    Route::resource('wallets', 'WalletController')->except(['create']);
    Route::get('wallets/{wallet}/accounts', 'WalletController@walletAccounts')->name('wallets.accounts');

    // Accounts
    Route::resource('accounts', 'AccountController')->only(['index', 'edit', 'update']);

    // Money Flows
    Route::resource('money-flows', 'MoneyFlowController')->except(['show']);

    // CLIENTS
    Route::group(['prefix' => 'clients'], static function() {
        Route::get('/', 'ClientController@index')->name('clients.index');
        Route::get('/create', 'ClientController@create')->name('clients.create');
        Route::post('/', 'ClientController@store')->name('clients.store');
        Route::get('/{client}', 'ClientController@show')->name('clients.show');
        Route::get('/{client}/edit', 'ClientController@edit')->name('clients.edit');
        Route::put('/{client}', 'ClientController@update')->name('clients.update');
        Route::delete('/{client}/delete', 'ClientController@destroy')->name('clients.destroy');

        Route::get('/{client}/contracts', 'ClientController@clientContracts')->name('client.contracts');
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

    // INVOICES
    Route::group(['prefix' => 'invoices'], static function() {
        Route::get('/', 'InvoiceController@index')->name('invoices.index');
        Route::get('/create', 'InvoiceController@create')->name('invoices.create');
        Route::post('/', 'InvoiceController@store')->name('invoices.store');
        Route::get('/{invoice}', 'InvoiceController@show')->name('invoices.show');
        Route::get('/{invoice}/edit', 'InvoiceController@edit')->name('invoices.edit');
        Route::put('/{invoice}', 'InvoiceController@update')->name('invoices.update');
        Route::delete('/{invoice}/delete', 'InvoiceController@destroy')->name('invoices.destroy');

        Route::get('{invoice}/download', 'InvoiceController@download')->name('invoices.download');
        Route::post('{invoice}/payment', 'InvoiceController@payment')->name('invoices.payment');
    });

    // INVOICE-ITEMS
    Route::group(['prefix' => 'invoice-items'], static function() {
        Route::get('/', 'InvoiceItemController@index')->name('invoice-items.index');
        Route::get('/create', 'InvoiceItemController@create')->name('invoice-items.create');
        Route::post('/', 'InvoiceItemController@store')->name('invoice-items.store');
        Route::get('/{invoice-item}', 'InvoiceItemController@show')->name('invoice-items.show');
        Route::get('/{invoice-item}/edit', 'InvoiceItemController@edit')->name('invoice-items.edit');
        Route::put('/{invoice-item}', 'InvoiceItemController@update')->name('invoice-items.update');
        Route::delete('/{invoice-item}/delete', 'InvoiceItemController@destroy')->name('invoice-items.destroy');
    });

    // PAYMENTS
    Route::group(['prefix' => 'payments'], static function() {
        Route::get('/', 'PaymentController@index')->name('payments.index');
        Route::get('/create', 'PaymentController@create')->name('payments.create');
        Route::post('/', 'PaymentController@store')->name('payments.store');
        Route::get('/{payment}', 'PaymentController@show')->name('payments.show');
        Route::get('/{payment}/edit', 'PaymentController@edit')->name('payments.edit');
        Route::put('/{payment}', 'PaymentController@update')->name('payments.update');
        Route::delete('/{payment}/delete', 'PaymentController@destroy')->name('payments.destroy');
    });

    // Incomes
    Route::resource('incomes', 'IncomeController')->except(['create', 'show']);
    Route::get('/list-incomes', 'IncomeController@list')->name('incomes.list');
    Route::get('/totals', 'IncomeController@totals')->name('totals');

    // Expenses
    Route::resource('expense-categories', 'ExpenseCategoryController')->except(['create', 'show']);
    Route::resource('expenses', 'ExpenseController')->except(['show']);

    // People
    Route::group(['prefix' => 'people', 'as' => 'people.'], function() {
        Route::get('former-list', 'PersonController@formerList')->name('former-list');
        Route::post('change-salary-type/{person}', 'PersonController@changeSalaryType')->name('change-salary-type');
        Route::post('change-contract-type/{person}', 'PersonController@changeContractType')->name('change-contract-type');
        Route::post('make-former/{person}', 'PersonController@makeFormer')->name('make-former');
        Route::post('long-vacation/{person}', 'PersonController@longVacation')->name('long-vacation');
        Route::post('back-to-active/{person}', 'PersonController@backToActive')->name('back-to-active');
        Route::post('pay-data/{person}', 'PersonController@payData')->name('pay-data');
        Route::patch('available-vacations/{person}', 'PersonController@updateAvailableVacations')->name('available-vacations');
        Route::patch('compensate/{person}', 'PersonController@compensate')->name('compensate');
    });
    Route::resource('people', 'PersonController');

    // Certifications
    Route::resource('certifications', 'CertificationController')->except(['show']);

    // Calendar
    Route::get('/calendar', 'CalendarController@index')->name('calendar.index');
    Route::get('/calendar/create', 'CalendarController@create')->name('calendar.create');
    Route::delete('/calendar/{year}', 'CalendarController@destroy')->name('calendar.destroy')->where('year', '\d\d\d\d');
    Route::put('/calendar/updateMonth/{calendarMonth}', 'CalendarController@updateMonth');
    Route::get('/months/{year}', 'CalendarController@months')->name('calendar.months')->where('year', '\d\d\d\d');

    // Holiday
    Route::resource('holidays', 'HolidayController');

    // Bonuses
    Route::resource('bonuses', 'BonusController')->except(['index', 'show']);
    Route::get('/bonuses', 'BonusController@index')->name('bonuses.index');
    Route::get('/bonuses/position/{position}', 'BonusController@byPosition')->name('bonuses.byPosition');
    Route::get('/bonuses/person/{person}', 'BonusController@show')->name('bonuses.person.show');

    // Vacations
    Route::group(['prefix' => 'vacations', 'as' => 'vacations.'], function() {
        Route::get('/', 'VacationController@index')->name('index');
        Route::post('/', 'VacationController@store')->name('store');
        Route::post('/delete', 'VacationController@destroy')->name('destroy');
        Route::get('/{year}/{month}', 'VacationController@month')
            ->name('month')
            ->where(['year' => '\d\d\d\d', 'month' => '\d{1,2}']);
    });

    // Offers
    Route::resource('offers', 'OffersController');
});

