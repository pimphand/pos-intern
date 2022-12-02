<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\PermissionController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\CategoryProductController;
use App\Http\Controllers\Api\Admin\OrderCategoryController;
use App\Http\Controllers\Api\Admin\PrinterController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\PurchaseController;
use App\Http\Controllers\Api\Admin\StockProductController;
use App\Http\Controllers\Api\Admin\SupplierController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\UserController as Madjou;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login',  [LoginController::class, 'login']);


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetCodeResponse'])
    ->name('password.sent');
Route::post('/forgot-code', [ForgotPasswordController::class, 'checkToken']);
Route::post('/reset-password', [ForgotPasswordController::class, 'sendResetResponse'])
    ->name('password.reset');

Route::post('/sync-product', [Madjou::class, 'create']);
Route::get('/sync-product', [Madjou::class, 'list']);

// Protected routes
Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function ($router) {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::resource('/permission', PermissionController::class);
    Route::resource('/role', RoleController::class);
    Route::resource('/category-product', CategoryProductController::class);
    Route::resource('/order-category', OrderCategoryController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/stock-product', StockProductController::class);
    Route::resource('/purchase', PurchaseController::class);
    Route::resource('/supplier', SupplierController::class);
    Route::resource('/transaction', TransactionController::class);
    Route::post('/setting-printer', [PrinterController::class, 'setting']);
    Route::get('/print', [PrinterController::class, 'tes']);
    Route::resource('/user', UserController::class);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
});
