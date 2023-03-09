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
        $data->type = $request->type;
        $data->metal = $request->metal;
        $data->carat = $request->carat;
        $data->weight1 = $request->weight1;
        $data->pearls = $request->pearls;
        $data->color = $request->color;
        $data->shape = $request->shape;
        $data->grade = $request->grade;
        $data->weight2 = $request->weight2;
        $data->size = $request->size;
        $data->price = $request->price;
        $data->price_sell = $request->price_sell;
        $data->price_discount = $request->price_sell;
        $data->barcode = $randomString;
        $data->discount = 0;
        $data->status = 0;

        $data->save();
        return redirect('produk');
    }

    public function update(Request $request)
    {
        $produk = Product::find($request->id);
        $produk->update($request->except(['_token']));

        return redirect(route('produk'));
    }

    public function destroy(Request $req)
    {
        $produk = Product::find($req->id);
        $produk->delete();

        return redirect(route('produk'));
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

        $data = Product::all();

        // $no  = 1;
        // $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        // $pdf->setPaper('a4', 'potrait');
        // return $pdf->stream('produk.pdf');
        return view('kasir.barcode', compact('data'));
    }
}
