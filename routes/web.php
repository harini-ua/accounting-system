<?php

use App\DataTables\UsersDataTable;
use App\Http\Controllers\LanguageController;
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

Auth::routes();

Route::get('/', 'DashboardController@index')->name('home');

// Users
Route::resource('users', 'UserController');
Route::get('/user-profile-page', 'UserController@userProfile');

// Invoices
//Route::resource('invoices', 'InvoiceController');
Route::get('/app-invoice-list', 'InvoiceController@invoiceList');
Route::get('/app-invoice-view', 'InvoiceController@invoiceView');
Route::get('/app-invoice-edit', 'InvoiceController@invoiceEdit');
Route::get('/app-invoice-add', 'InvoiceController@invoiceAdd');

