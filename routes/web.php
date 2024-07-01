<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

use App\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionSummaryController;
use App\Http\Controllers\Product_DetailController;
use App\Http\Controllers\Note_buyerController;
use App\Http\Controllers\StoreController;


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
Route::resource('Product_Detail', Product_DetailController::class);
Route::resource('store', StoreController::class);
Route::resource('note_buyer', Note_buyerController::class);

// untuk membawa tombol creaate id dari table store ke table note_buyer
Route::get('store/{store}', [StoreController::class, 'show'])->name('store.show');

// untuk bisa create dari tombol create ke halaman create yang membawa id dari table store
Route::get('note_buyer/{store}/create', [Note_buyerController::class, 'create'])->name('note_buyer.create');

// untuk filter keuntungan harian sesuai bulan
Route::get('/admin/transaction-summary', [TransactionSummaryController::class, 'index'])
    ->name('admin.transaction_summary.index');

// API
Route::get('/api/products', [App\Http\Controllers\ProductController::class, 'api']);
Route::get('/api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);
Route::get('/api/customers', [App\Http\Controllers\CustomerController::class, 'api']);
Route::get('/api/categories', [App\Http\Controllers\CategoryController::class, 'api']);
Route::get('/api/store', [App\Http\Controllers\StoreController::class, 'api']);
// Route::get('/api/note_buyer', [App\Http\Controllers\Note_buyerController::class, 'api']);
// Route::get('/api/note_buyer_detail', [App\Http\Controllers\Note_buyer_detailController::class, 'api']);

// membuat api dari database note_buyers sesuai id 
Route::get('/api/note_buyer/{store_id}', [App\Http\Controllers\Note_buyerController::class, 'api']);

// membuat api note note_buyer_detail sesuai id dari table note_buyer
Route::get('/api/note_buyer_detail/{note_buyer_id}', [App\Http\Controllers\Note_buyer_detailController::class, 'api']);

// menggabungkan api note_buyer_details dan products 
Route::get('/api/note_buyer_detail_with_products/{note_buyer_id}', [App\Http\Controllers\Note_buyer_detailController::class, 'apiWithProducts']);
