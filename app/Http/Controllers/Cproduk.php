<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\produk;
use Illuminate\Http\Request;
class Cproduk extends Controller
{
    //
    public function index(Request $request)
    {

        $data = Product::all();
        return view('kasir.produk', compact('data'));
    }

    public function store(Request $request)
    {

        $string = uniqid(rand());
        $randomString = substr($string, 0, 8);

        $data = new Product();
        $data->name = $request->name;
        $data->barcode = $randomString;
        $data->size = $request->size;
        $data->type = $request->type;
        $data->karat = $request->karat;
        $data->weight = $request->weight;
        $data->grade = $request->grade;
        $data->price = $request->price;
        $data->status = 0;

        $data->save();
        return redirect('produk');
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
