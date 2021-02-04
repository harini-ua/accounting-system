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
    Route::get('/profile', 'UserController@userProfile')->name('user.profile');
    Route::put('/profile', 'UserController@profileUpdate')->name('user.profile.update');

    // Wallets
    Route::resource('wallets', 'WalletController')->except(['create']);
    Route::get('wallets/{wallet}/accounts', 'WalletController@walletAccounts')->name('wallets.accounts');

    // Accounts
    Route::resource('accounts', 'AccountController')->only(['index', 'edit', 'update']);

    // Money Flows
    Route::resource('money-flows', 'MoneyFlowController')->except(['show']);

    // Clients
    Route::resource('clients', 'ClientController');
    Route::get('clients/{client}/contracts', 'ClientController@clientContracts')->name('client.contracts');

    // Contracts
    Route::resource('contracts', 'ContractController');

    // Invoices
    Route::resource('invoices', 'InvoiceController');
    Route::group(['prefix' => 'invoices'], static function() {
        Route::get('{invoice}/download', 'InvoiceController@download')->name('invoices.download');
        Route::post('{invoice}/payment', 'InvoiceController@payment')->name('invoices.payment');
    });

    // Invoice-item
    Route::resource('invoice-items', 'InvoiceItemController');

    // Payments
    Route::resource('payments', 'PaymentController');

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
        Route::get('{person}/info', 'PersonController@info')->name('info');
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
    Route::get('calendar/year/{calendarYearId}/months', 'CalendarController@yearMonths')->name('calendar.year.months');

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

    // Salary Reviews
    Route::resource('salary-reviews', 'SalaryReviewController');
    Route::group(['prefix' => 'salary-reviews', 'as' => 'salary-reviews.'], function() {
        Route::get('year/{year}/quarter/{quarter}', 'SalaryReviewController@quarter')->name('quarter');
    });

    // Salary
    Route::get('/salaries', 'SalaryController@index')->name('salaries.index');
    Route::get('/salaries/{year}/{month}', 'SalaryController@month')->name('salaries.month')
        ->where(['year' => '\d\d\d\d', 'month' => '\d{1,2}']);

    Route::resource('salary-payments', 'SalaryController')->except(['index']);
//    Route::get('/salary-payments/create', 'SalaryController@create')->name('salary-payments.create');

    Route::get('/payslip/print', 'PayslipController@index')->name('payslip.print');
});

