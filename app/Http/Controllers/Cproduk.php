<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

class Cproduk extends Controller
{
    //
    public function store(Request $request)
    {

        $produk = Produk::latest()->first() ?? new Produk();
        $request['kode_produk'] = 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6);

        $produk = Produk::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        // foreach ($request->id_produk as $id) {
        //     $produk = Produk::find($id);
        //     $dataproduk[] = $produk;
        // }

        // $no  = 1;
        // $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        // $pdf->setPaper('a4', 'potrait');
        // return $pdf->stream('produk.pdf');
        return view('kasir.barcode');
    }
}
