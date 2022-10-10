<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\CustomerManagermentController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Client\LoginController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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


Route::get('/test', [TestController::class, 'index'])->name('test');

Route::prefix('account')->name('account.')->group(function ()
{
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('p_register');
    Route::post('/register', [RegisterController::class, 'actionRegister'])->name('p_registerAdmin');

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'actionLogin'])->name('p_login');

    Route::get('/logout', [LoginController::class, 'actionLogout'])->name('logout');
});


Route::get('/', [HomeController::class, 'index'])->name('home');






Route::prefix('admin')->name('admin.')->group(function ()
{
    Route::get('/login', [AdminLoginController::class, 'index'])->name('loginManagement');
    Route::post('/login', [AdminLoginController::class, 'actionLogin'])->name('p_loginManagement');
    Route::post('/register', [AdminLoginController::class, 'actionRegister'])->middleware('adminmiddleware')->name('p_registerManagement');
    Route::get('/logout', [AdminLoginController::class, 'actionLogout'])->middleware('adminmiddleware')->name('logout');

    /*
        Route::get('/customer', [CustomerManagermentController::class, 'index'])->name('customerManagement');
        Route::post('/customer', [CustomerManagermentController::class, 'paginationCustomer'])->name('p_paginationCustomerManagement');
        Route::post('/customer/edit', [CustomerManagermentController::class, 'editCustomer'])->name('p_editCustomerManagement');
        Route::post('/customer/delete', [CustomerManagermentController::class, 'deleteCustomer'])->name('p_deleteCustomerManagement');
        Route::post('/customer/search', [CustomerManagermentController::class, 'searchCustomer'])->name('p_searchcustomerManagement');
        Route::get('/customer/export', [CustomerManagermentController::class, 'exportCSV'])->name('exportCsvCustomerManagement');
        Route::post('/customer/import', [CustomerManagermentController::class, 'importCSV'])->name('p_importCsvCustomerManagement');
    */

    Route::group(['prefix' => 'customer', 'middleware' => 'adminmiddleware'], function ()
    {
        Route::get('/', [CustomerManagermentController::class, 'index'])->name('customerManagement');
        Route::post('/', [CustomerManagermentController::class, 'paginationCustomer'])->name('p_paginationCustomerManagement');
        Route::post('/edit', [CustomerManagermentController::class, 'editCustomer'])->name('p_editCustomerManagement');
        Route::post('/delete', [CustomerManagermentController::class, 'deleteCustomer'])->name('p_deleteCustomerManagement');
        Route::post('/search', [CustomerManagermentController::class, 'searchCustomer'])->name('p_searchcustomerManagement');
        Route::get('/export', [CustomerManagermentController::class, 'exportCSV'])->name('exportCsvCustomerManagement');
        Route::post('/import', [CustomerManagermentController::class, 'importCSV'])->name('p_importCsvCustomerManagement');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'adminmiddleware', 'as'=> 'admin.'], function ()
    {
        Route::get('/', [AdminManagementController::class, 'index'])->name('management');
        Route::post('/', [AdminManagementController::class, 'paginationAdmin'])->name('p_pagination');
        Route::post('/edit', [AdminManagementController::class, 'editAdmin'])->name('p_edit');
        Route::post('/delete', [AdminManagementController::class, 'deleteAdmin'])->name('p_delete');
        Route::post('/search', [AdminManagementController::class, 'searchAdmin'])->name('p_search');
        Route::get('/exportcsv', [AdminManagementController::class, 'exportCSV'])->name('exportCsv');
        Route::post('/importcsv', [AdminManagementController::class, 'importCSV'])->name('p_importCsv');
    });

    Route::group(['prefix' => 'product', 'middleware' => 'adminmiddleware', 'as'=> 'product.'], function ()
    {
        Route::get('/', [ProductManagementController::class, 'index'])->name('management');
        Route::post('/', [ProductManagementController::class, 'paginationProduct'])->name('p_pagination');
        Route::post('/edit', [ProductManagementController::class, 'editProduct'])->name('p_edit');
        Route::post('/delete', [ProductManagementController::class, 'deleteProduct'])->name('p_delete');
        Route::post('/search', [ProductManagementController::class, 'searchProduct'])->name('p_search');
        Route::post('/add', [ProductManagementController::class, 'actionAddProduct'])->name('p_add');
        Route::post('/product', [ProductManagementController::class, 'product'])->name('p_product');
        // Route::get('/{id}', [ProductManagementController::class, 'addProduct'])->name('add');
        // Route::get('/{id}/edit', [ProductManagementController::class, 'addProduct'])->name('edit');
        // Route::post('/{id}/edit', [ProductManagementController::class, 'addProduct'])->name('p_edit');

    });
});
