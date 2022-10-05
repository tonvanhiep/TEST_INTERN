<?php

use App\Http\Controllers\Admin\CustomerManagermentController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\LoginController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\TestController;
use App\Models\User;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/test', [TestController::class, 'index'])->name('test');



Route::prefix('taikhoan')->name('account.')->group(function ()
{
    Route::get('/dangky', [RegisterController::class, 'index'])->name('register');
    Route::post('/dangky', [RegisterController::class, 'actionRegister'])->name('p_register');

    Route::get('/dangnhap', [LoginController::class, 'index'])->name('login');
    Route::post('/dangnhap', [LoginController::class, 'actionLogin'])->name('p_login');

    Route::get('/dangxuat', [LoginController::class, 'actionLogout'])->name('logout');
});


Route::prefix('quanly')->name('admin.')->group(function ()
{
    Route::get('/dangnhap', [AdminLoginController::class, 'index'])->name('loginManagement');
    Route::post('/dangnhap', [AdminLoginController::class, 'actionLogin'])->name('p_loginManagement');
    Route::post('/dangky', [AdminLoginController::class, 'actionRegister'])->name('p_registerManagement');
    Route::get('/dangxuat', [AdminLoginController::class, 'actionLogout'])->name('logoutManagement');

    Route::get('/khachhang', [CustomerManagermentController::class, 'index'])->name('customerManagement');
    Route::post('/khachhang', [CustomerManagermentController::class, 'paginationCustomer'])->name('p_paginationCustomerManagement');
    Route::post('/chinhsuakh', [CustomerManagermentController::class, 'editCustomer'])->name('p_editCustomerManagement');
    Route::post('/xoakh', [CustomerManagermentController::class, 'deleteCustomer'])->name('p_deleteCustomerManagement');
    Route::post('/timkiemkh', [CustomerManagermentController::class, 'searchCustomer'])->name('p_searchcustomerManagement');
    Route::get('/khachhang/xuatcsv', [CustomerManagermentController::class, 'exportCSV'])->name('exportCsvCustomerManagement');
    Route::post('/khachhang/nhapcsv', [CustomerManagermentController::class, 'importCSV'])->name('p_importCsvCustomerManagement');

    Route::get('/quantrivien', [UserController::class, 'index'])->name('adminManagement');
    Route::get('/sanpham', [ProductController::class, 'index'])->name('productManagement');
});

// Route::get('test', function(){
//     return Excel::download(new User(), 'users.xlsx');
// });
