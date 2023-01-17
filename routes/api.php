<?php

use App\Http\Controllers\Cproduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/produk',[Cproduk::class,'load'])->name('produk.load');
Route::get('/produk/{id}',[Cproduk::class,'get'])->name('produk.get');
Route::post('/produk',[Cproduk::class,'store'])->name('produk.store');
Route::post('/produk/{id}',[Cproduk::class,'update'])->name('product.update');
// Route::get('/generate_barcode/{id}', [Cproduk::class, 'generate_barcode'])->name('generate.barcode');
