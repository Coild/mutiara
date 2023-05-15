<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class kasir extends Controller
{

    public function dashboard(Request $req)
    {
        // dd(Auth::user());
        $startDate = date('Y-m-d', strtotime('-7 days'));
        $currentMonth = now()->month;
        $currentYear = date('Y');
        $today = date("Y-m-d"); // Get today's date in YYYY-MM-DD format
        $fs = $today;
        $fe = $today;
        $pelanggan = Order::whereMonth('date', '=', $currentMonth)
            ->count();
        $barang = Product::where('status', 1)
            ->whereMonth('updated_at', '=', $currentMonth)
            ->count();

        // dd($barang);

        $todaycash = order::where('payment', 'Cash')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");
        $todayqris = order::where('payment', 'Qris')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");

        $filtercash = $todaycash;
        $filterqris = $todayqris;

        if (isset($req['filter'])) {
            // dd($req);
            $fs = $req['start_date'];
            $fe = $req['end_date'];
            $startDate = Carbon::parse($fs)->startOfDay()->timestamp;
            $sdate = Carbon::createFromTimestamp($startDate);
            $endDate = Carbon::parse($fe)->endOfDay()->timestamp;
            $edate = Carbon::createFromTimestamp($endDate);
            // dd($edate);
            $filtercash =  order::where('payment', 'Cash')
                ->whereBetween('date', [$req['start_date'], $req['end_date']])
                ->sum("total");
            $filterqris =  order::where('payment', 'Qris')
                ->whereBetween('date', [$req['start_date'], $req['end_date']])
                ->sum("total");

            //fillter card dashboard
            $pelanggan = Order::whereBetween('date', [$req['start_date'], $req['end_date']])
                ->count();
            $barang = Product::where('status', 1)
                ->whereBetween('updated_at', [$sdate, $edate])
            ->count();
            // dd($barang->get());

            // dd($barang);

            $todaycash = order::where('payment', 'Cash')
                ->whereBetween('date', [$req['start_date'], $req['end_date']])
                ->sum("total");
            $todayqris = order::where('payment', 'Qris')
                ->whereBetween('date', [$req['start_date'], $req['end_date']])
                ->sum("total");
        }

        $lastcash = order::where('payment', 'Cash')
            ->whereBetween('date', [$startDate, $today])
            ->sum("total");
        $lastqris = order::where('payment', 'Qris')
            ->whereBetween('date', [$startDate, $today])
            ->sum("total");


        $monthcash = order::where('payment', 'Cash')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");
        $monthqris = order::where('payment', 'Qris')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");

        $grafiks = order::selectRaw('MONTH(date) as month, SUM(total) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->get();
        $bulan = [];
        $jumlah = [];
        foreach ($grafiks as $grafik) {
            $monthNumber = $grafik->month;
            $monthName = Carbon::createFromDate(null, $monthNumber, null)->format('F');
            $grafik->month = $monthName;
            array_push($bulan, $monthName);
            array_push($jumlah, $grafik->total);
        }

        // dd($bulan);


        // dd($barang);

        return view('dashboard', compact('pelanggan', 'barang', 'todaycash', 'todayqris', 'lastcash', 'lastqris', 'monthqris', 'monthcash', 'filtercash', 'filterqris', 'bulan', 'jumlah', 'fs', 'fe'));
    }

    public function agregat(Request $request)
    {

        // dd($request);
        // $validator = Validator::make($request->all(), [
        //     "start_date" => "required",
        //     "end_date" => "required",
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'Error',
        //         'message' => $validator->messages()->all()
        //     ], 501);
        // }

        // return $order->product;
        // $pro = [];
        // foreach($order as $or){
        //     array_push($pro, $product->name);
        // }
        // return $pro;

        $start = $request->start_date;
        $end = new DateTime($request->end_date);
        $end = $end->modify('+1 day');
        $end = $end->format('Y-m-d');

        $data = Order::whereBetween('date', [$start, $end]);
        $order = $data->get();
        // return $start;
        // if (count($order) == 0) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Order Not found',
        //         'data' => null
        //     ], 404);
        // }

        // return $order[0]->product[0]->price;

        $total = 0;
        $modal = 0;
        foreach ($order as $or) {
            $total += $or->total;
            foreach ($or->product as $product) {
                $modal += $product->price;
            }
        }

        return view('kasir.agregat', compact('total', 'modal', 'order'));
    }

    public function produk()
    {
        return view('kasir.produk');
    }

    public function jual()
    {

        // dd($message);
        $data = Product::all();
        // dd(Session::all());
        $cek = Session::get('data') ?? [];
        return view('kasir.riwayat', compact('cek', 'data'));
    }

    public function beli(Request $req)
    {
        // dd(Session::get('data'));
        $barang = [];

        foreach (Session::get('data') as  $key => $item) {
            array_push($barang, [
                'product_id' => $item['id'],
                'discount' =>  $req['diskon' . $key] ?? 0,
            ]);
        }

        $beli = [
            'name' => $req['nama'],
            'uang' =>  intval(str_replace('.', '', $req['diterima'])),
            'order' => $barang
        ];


        // return $barang;

        $today = Carbon::now()->format('Y-m-d');
        $data = new Order();

        $data->name = $req['nama'];
        $data->phone = $req['nohp'];
        $data->address = $req['alamat'];
        $data->payment = $req['metode'];
        $data->bill_code = $this->rand_bill();
        $data->code = $req['code'];
        $data->uang =  intval(str_replace('.', '', $req['diterima']));
        $data->date = $today;
        $data->save();

        $total = 0;
        // dd($barang);
        foreach ($barang as $r) {

            $product = Product::where('id', '=', $r['product_id'])->first();
            // return $product;
            if ($r['discount'] != 0) {
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
        }
        $data->total = $total;
        $data->kembalian = $data->uang - $total;
        $data->update();

        Session::forget('data');
        Session::forget('total');
        return redirect(route('jual'))->with('message', 'Berhasil disimpan');;
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
            ->where('product.order_id', '=', $req['id'])
            ->get();
        return view('kasir.detil_transaksi', compact('data'));
    }

    function rand_bill()
    {
        $stringSpace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringLength = strlen($stringSpace);
        $string = str_repeat($stringSpace, ceil(4 / $stringLength));
        $shuffledString = str_shuffle($string);
        $randomString = substr($shuffledString, 1, 4);
        return $randomString;
    }
}
