<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class kasir extends Controller
{
    public function produk () {
        return view('kasir.produk');
    }

    public function jual () {
        
        $data = Product::all();
        // Session::flush();
        $cek = Session::get('data') ?? [];
        return view('kasir.riwayat', compact('cek','data'));
    }

    public function riwayat () {
        return view('kasir.jual');
    }
}
