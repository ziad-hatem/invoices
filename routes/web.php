<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/signout', function () {
    Auth::logout();
    return redirect('/');
})->name('signout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoicesController::class);

Route::resource('sections', SectionsController::class);

Route::resource('products', ProductsController::class);

Route::resource('InvoiceAttachments', InvoiceAttachmentController::class);

Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);

Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit']);

Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);

Route::delete('/deleteInvoice', [InvoicesController::class, 'destroy'])->name('invoices.destroy');

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);

Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::get('/edit_invoice/{id}', [InvoicesController::class, 'edit']);

Route::get('/Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');

Route::post('/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');

Route::resource('Archive', InvoiceAchiveController::class);

Route::get('Invoice_Paid', [InvoicesController::class, 'Invoice_Paid']);

Route::get('Invoice_UnPaid', [InvoicesController::class, 'Invoice_UnPaid']);

Route::get('Invoice_Partial', [InvoicesController::class, 'Invoice_Partial']);

Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice']);

Route::get('export_invoices', [InvoicesController::class, 'export']);


Route::get('invoices_report', [Invoices_Report::class, 'index']);

Route::post('Search_invoices', [Invoices_Report::class, 'Search_invoices']);

Route::get('customers_report', [Customers_Report::class, 'index'])->name("customers_report");

Route::post('Search_customers', [Customers_Report::class, 'Search_customers']);

Route::get('MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');

Route::middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
