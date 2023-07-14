<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

use App\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionSummaryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);


// ROUTE RESOURCE
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('customers', CustomerController::class);
Route::resource('transactions', TransactionController::class);
Route::resource('transaction_summaries', TransactionSummaryController::class);

// API
Route::get('/api/products', [App\Http\Controllers\ProductController::class, 'api']);
Route::get('/api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);
Route::get('/api/customers', [App\Http\Controllers\CustomerController::class, 'api']);
Route::get('/api/categories', [App\Http\Controllers\CategoryController::class, 'api']);




