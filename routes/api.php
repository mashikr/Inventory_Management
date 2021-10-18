<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\api\SupplierController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ExpenseController;
use App\Http\Controllers\api\SalaryController;
use App\Http\Controllers\api\SellController;
use App\Http\Controllers\api\CustomerController;
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

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::prefix('employee')->middleware('api')->group(function () {
    Route::get('all', [EmployeeController::class, 'index']);
    Route::post('add', [EmployeeController::class, 'store']);
    Route::delete('delete/{id}', [EmployeeController::class, 'destroy']);
    Route::get('show/{id}', [EmployeeController::class, 'show']);
    Route::patch('edit/{id}', [EmployeeController::class, 'edit']);
});

Route::resource('/supplier', SupplierController::class);
Route::resource('/category', CategoryController::class);
Route::resource('/product', ProductController::class);
Route::resource('/expense', ExpenseController::class);
Route::resource('/salary', SalaryController::class);
Route::resource('/sell', SellController::class);
Route::resource('/customer', CustomerController::class);
Route::post('/customer/search', [CustomerController::class, 'search']);

