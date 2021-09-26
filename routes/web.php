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

use App\Http\Controllers\{
    AccountController,
    BonusController,
    CalendarController,
    CertificationController,
    ClientController,
    ContractController,
    DashboardController,
    ExpenseCategoryController,
    ExpenseController,
    HolidayController,
    IncomeController,
    InvoiceController,
    InvoiceItemController,
    MoneyFlowController,
    OffersController,
    PaymentController,
    PaymentGridController,
    PayslipController,
    FinalPayslipController,
    PersonController,
    SalaryController,
    SalaryReviewController,
    UserController,
    VacationController,
    WalletController,
};

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function() {

    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Users
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/profile', [UserController::class, 'userProfile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'profileUpdate'])->name('user.profile.update');

    // Wallets
    Route::resource('wallets', WalletController::class)->except(['create']);
    Route::group(['prefix' => 'wallets'], static function() {
        Route::get('{wallet}/accounts', [WalletController::class, 'walletAccounts'])->name('wallets.accounts');
    });

    // Accounts
    Route::resource('accounts', AccountController::class)->only(['index', 'edit', 'update']);

    // Money Flows
    Route::resource('money-flows', MoneyFlowController::class)->except(['show']);

    // Clients
    Route::resource('clients', ClientController::class);
    Route::get('clients/{client}/contracts', [ClientController::class, 'clientContracts'])->name('client.contracts');

    // Contracts
    Route::resource('contracts', ContractController::class);

    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::group(['prefix' => 'invoices'], static function() {
        Route::get('{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::post('{invoice}/payment', [InvoiceController::class, 'payment'])->name('invoices.payment');
    });

    // Invoice-item
    Route::resource('invoice-items', InvoiceItemController::class);

    // Payments
    Route::resource('payments', PaymentController::class);
    Route::get('payment-grid', [PaymentGridController::class, 'index'])->name('payments.grid.index');

    // Incomes
    Route::resource('incomes', IncomeController::class)->except(['create', 'show']);
    Route::get('/list-incomes', [IncomeController::class, 'list'])->name('incomes.list');
    Route::get('/totals', [IncomeController::class, 'totals'])->name('totals');

    // Expenses
    Route::resource('expense-categories', ExpenseCategoryController::class)->except(['create', 'show']);
    Route::resource('expenses', ExpenseController::class)->except(['show']);

    // People
    Route::group(['prefix' => 'people', 'as' => 'people.'], function() {
        Route::get('former-list', [PersonController::class, 'formerList'])->name('former-list');
        Route::post('change-salary-type/{person}', [PersonController::class, 'changeSalaryType'])->name('change-salary-type');
        Route::post('change-contract-type/{person}', [PersonController::class, 'changeContractType'])->name('change-contract-type');
        Route::post('make-former/{person}', [PersonController::class, 'makeFormer'])->name('make-former');
        Route::post('long-vacation/{person}', [PersonController::class, 'longVacation'])->name('long-vacation');
        Route::post('back-to-active/{person}', [PersonController::class, 'backToActive'])->name('back-to-active');
        Route::post('pay-data/{person}', [PersonController::class, 'payData'])->name('pay-data');
        Route::patch('available-vacations/{person}', [PersonController::class, 'updateAvailableVacations'])->name('available-vacations');
        Route::patch('compensate/{person}', [PersonController::class, 'compensate'])->name('compensate');
        Route::get('{person}/info', [PersonController::class, 'info'])->name('info');
    });
    Route::resource('people', PersonController::class);

    // Certifications
    Route::resource('certifications', CertificationController::class)->except(['show']);

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/create', [CalendarController::class, 'create'])->name('calendar.create');
    Route::delete('/calendar/{year}', [CalendarController::class, 'destroy'])->name('calendar.destroy')->where('year', '\d\d\d\d');
    Route::put('/calendar/updateMonth/{calendarMonth}', [CalendarController::class, 'updateMonth']);
    Route::get('/months/{year}', [CalendarController::class, 'months'])->name('calendar.months')->where('year', '\d\d\d\d');
    Route::get('calendar/year/{calendarYearId}/months', [CalendarController::class, 'yearMonths'])->name('calendar.year.months');

    // Holiday
    Route::resource('holidays', HolidayController::class);

    // Bonuses
    Route::resource('bonuses', BonusController::class)->except(['index', 'show']);
    Route::group(['prefix' => 'bonuses'], static function() {
        Route::get('/', [BonusController::class, 'index'])->name('bonuses.index');
        Route::get('/position/{position}', [BonusController::class, 'byPosition'])->name('bonuses.byPosition');
        Route::get('/person/{person}', [BonusController::class, 'show'])->name('bonuses.person.show');
    });

    // Vacations
    Route::group(['prefix' => 'vacations', 'as' => 'vacations.'], function() {
        Route::get('/', [VacationController::class, 'index'])->name('index');
        Route::post('/', [VacationController::class, 'store'])->name('store');
        Route::post('/delete', [VacationController::class, 'destroy'])->name('destroy');
        Route::get('/{year}/{month}', [VacationController::class, 'month'])->name('month')
            ->where(['year' => '\d\d\d\d', 'month' => '\d{1,2}']);
    });

    // Offers
    Route::resource('offers', OffersController::class);

    // Salary Reviews
    Route::resource('salary-reviews', SalaryReviewController::class);
    Route::get('/salary-reviews/year/{year}/quarter/{quarter}', [SalaryReviewController::class, 'quarter'])
        ->name('salary-reviews.quarter');

    // Salary
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
    Route::get('/salaries/{year}/{month}', [SalaryController::class, 'month'])->name('salaries.month')
        ->where(['year' => '\d\d\d\d', 'month' => '\d{1,2}']);

    // Salary Payments
    Route::resource('salary-payments', SalaryController::class)->except(['index']);
    Route::get('/salary-payments/create', [SalaryController::class, 'create'])->name('salary-payments.create');

    Route::get('/payslip/print', [PayslipController::class, 'index'])->name('payslip.print');

    // Final Payslip
    Route::get('/final-payslip/person/{person}', [FinalPayslipController::class, 'person'])->name('final-payslip.create.person');

    Route::resource('final-payslip', FinalPayslipController::class);
});

