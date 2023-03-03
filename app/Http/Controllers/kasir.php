<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\isNull;

class kasir extends Controller
{
    public function produk()
    {
        return view('kasir.produk');
    }

    public function jual()
    {

        $data = Product::all();
        // dd(Session::all());
        $cek = Session::get('data') ?? [];
        return view('kasir.riwayat', compact('cek', 'data'));
    }

    public function beli(Request $req)
    {
        // dd(Session::get('data'));
        $barang = [];
        $i = 1;

        foreach (Session::get('data') as $item) {
            array_push($barang, [
                'product_id' => $item['id'],
                'discount' =>  $req['diskon' . $i] ?? 0,
            ]);
            $i = $i + 1;
        }

        $beli = [
            'name' => $req['nama'],
            'uang' => $req['diterima'],
            'order' => $barang
        ];

        $today = Carbon::now()->format('Y-m-d');
        $data = new Order();


        $data->name = $req['nama'];
        $data->uang = $req['diterima'];
        $data->date = $today;
        $data->save();

        $total = 0;
        // dd($barang);
        foreach ($barang as $r) {
            // return $r['product_id'];

            $product = Product::where('id', '=', $r['product_id'])->first();
            // return $product;
            // dd($r['discount']);
            if ($r['discount'] != 0) {
                // if(0 != 0){

                $product = Product::where('id', '=', $r['product_id'])->first();
                // return $product;
                if ($r['discount'] != 0) {
                    // if(0 != 0){

                    $discount = ($r['discount'] / 100) * $product->price_sell;
                    $price_sell = $product->price_sell - $discount;
                    $product->price_discount = $price_sell;
                    $product->discount = $r['discount'];
                    $total += $price_sell;
                } else {
                    $total += $product->price_sell;
                }
                // return $product->price;
                $product->status = 1;
                $product->order_id = $data->id;
                $product->update();
            } else {
                $product = Product::where('id', '=', $r['product_id'])->first();
                $total += $product->price_sell;
                $product->status = 1;
                $product->order_id = $data->id;
                $product->update();
            }
            // dd($total);

            $data->total = $total;
            $data->kembalian = $req['uang'] - $total;
        }
        $data->update();

        Session::forget('data');
        Session::forget('total');
        return redirect(route('jual'));
    }

    public function riwayat(Request $req)
    {
        if (isset($req['filter'])) {
            // dd($req);
            $data = Order::whereBetween('date', [$req['start_date'], $req['end_date']])
                ->get();
        } else {
            $data = Order::all();
        }
        return view('kasir.jual', compact('data'));
    }

    public function detil_transaksi(Request $req)
    {
        $data = Order::join('product', 'product.order_id', '=', 'order.id')
        ->where('product.order_id','=',$req['id'])
        ->get();
        return view('kasir.detil_transaksi', compact('data'));
    }
}
