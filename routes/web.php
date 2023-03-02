<?php

use App\Http\Controllers\Cproduk;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\kasir;
use App\Http\Controllers\OrderController;
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
})->name('home');

Route::get('/coba', function () {
    return view('dummy');
});

Route::post('/produk', [Cproduk::class, 'store'])->name('produk.post');
Route::post('/produkedit', [Cproduk::class, 'update'])->name('produk.edit');
Route::get('/produkhapus', [Cproduk::class, 'destroy'])->name('produk.hapus');
Route::get('/produk', [Cproduk::class, 'index'])->name('produk');
Route::get('/jual', [kasir::class, 'jual'])->name('jual');
Route::get('/riwayat', [kasir::class, 'riwayat'])->name('riwayat');
Route::get('/detil_transaksi', [kasir::class, 'detil_transaksi'])->name('detil.transaksi');
Route::get('/setting', [kasir::class, 'setting'])->name('setting');
Route::post('/buy', [kasir::class, 'beli'])->name('beli');
Route::get('/dummy', [Cproduk::class, 'cetakBarcode'])->name('cetak');


Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ProductController::class, 'get'])->name('product.get');
Route::get('/product/barcode/{barcode}', [ProductController::class, 'getByBarcode'])->name('product.getByBarcode');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/product/print/barcode', [ProductController::class, 'print_all_barcode'])->name('print_all.barcode');
Route::get('/product/print_barcode/{id}', [ProductController::class, 'print_barcode'])->name('print.barcode');
Route::get('/product/sertificate/{id}', [ProductController::class, 'print_sertificate'])->name('user.print.sertificate');
Route::post('/product/upload-content', [ProductController::class, 'import'])->name('import.product');

Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::post('/order/agregat', [OrderController::class, 'agregat'])->name('order.agregat');
Route::get('/order/invoice/{id}', [OrderController::class, 'print_invoice'])->name('order.print_invoice');
