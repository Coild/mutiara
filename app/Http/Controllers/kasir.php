<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class kasir extends Controller
{
    public function produk () {
        return view('kasir.produk');
    }

    public function jual () {
        return view('kasir.jual');
    }

    public function riwayat () {
        return view('kasir.riwayat');
    }
}
