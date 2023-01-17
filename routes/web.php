<?php

use App\Http\Controllers\ProductController;
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
});

Route::get('/product',[ProductController::class,'index'])->name('product.index');
Route::get('/product/{id}',[ProductController::class,'get'])->name('product.get');
Route::get('/product/barcode/{barcode}',[ProductController::class,'getByBarcode'])->name('product.getByBarcode');
Route::post('/product',[ProductController::class,'store'])->name('product.store');
Route::put('/product/{id}',[ProductController::class,'update'])->name('product.update');
Route::delete('/product/{id}',[ProductController::class,'destroy'])->name('product.destroy');
Route::get('/product/print_barcode/{id}', [ProductController::class, 'print_barcode'])->name('print.barcode');
Route::get('/product/sertificate/{id}',[ProductController::class, 'print_sertificate'])->name('user.print.sertificate');

