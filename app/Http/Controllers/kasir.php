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
        $todaytf = order::where('payment', 'Transfer')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");
        $todaycard = order::where('payment', 'Card')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");

        $filtercash = $todaycash;
        $filterqris = $todayqris;
        $filtertf = $todaytf;
        $filtercard = $todaycard;

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
            $filtertf =  order::where('payment', 'Transfer')
                ->whereBetween('date', [$req['start_date'], $req['end_date']])
                ->sum("total");
            $filtercard =  order::where('payment', 'Card')
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
            $todaytf = order::where('payment', 'Transfer')
                ->whereBetween('date', [$req['start_date'], $req['end_date']])
                ->sum("total");
            $todaycard = order::where('payment', 'Card')
                ->whereBetween('date', [$req['start_date'], $req['end_date']])
                ->sum("total");
        }

        $lastcash = order::where('payment', 'Cash')
            ->whereBetween('date', [$startDate, $today])
            ->sum("total");
        $lastqris = order::where('payment', 'Qris')
            ->whereBetween('date', [$startDate, $today])
            ->sum("total");
        $lasttf = order::where('payment', 'Transfer')
            ->whereBetween('date', [$startDate, $today])
            ->sum("total");
        $lastcard = order::where('payment', 'Card')
            ->whereBetween('date', [$startDate, $today])
            ->sum("total");


        $monthcash = order::where('payment', 'Cash')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");
        $monthqris = order::where('payment', 'Qris')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");
        $monthtf = order::where('payment', 'Transfer')
            ->whereMonth('date', '=', $currentMonth)
            ->sum("total");
        $monthcard = order::where('payment', 'Card')
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

        return view('dashboard', compact('pelanggan', 'barang', 'todaycash', 'todayqris', 'todaytf', 'todaycard', 'lastcash', 'lastqris', 'lasttf', 'lastcard', 'monthqris', 'monthcash', 'monthtf', 'monthcard', 'filtercash', 'filterqris', 'filtertf', 'filtercard', 'bulan', 'jumlah', 'fs', 'fe'));
    }

    public function agregat(Request $request)
    {


        $start = $request->start_date;
        $end = new DateTime($request->end_date);
        $end = $end->modify('+1 day');
        $end = $end->format('Y-m-d');

        $data = Order::whereBetween('date', [$start, $end]);
        $order = $data->get();
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

    // Mengambil data dengan server-side processing tanpa Yajra
    public function getData(Request $request)
    {
        // Ambil parameter pencarian, urutan, dan jumlah data per halaman dari request DataTables
        $search = $request->input('search.value');
        $orderColumn = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
        $start = $request->input('start');
        $length = $request->input('length');

        // Query dasar untuk mengambil data Order
        $query = Order::query();

        // Filter data berdasarkan pencarian
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('total', 'like', "%{$search}%")
                ->orWhere('date', 'like', "%{$search}%");
        }

        // Urutkan data berdasarkan kolom yang diinginkan
        $columns = ['id', 'name', 'total', 'date'];
        if (isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDirection);
        }

        // Hitung total record dan record yang difilter
        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        // Ambil data sesuai dengan paginasi
        $orders = $query->skip($start)->take($length)->get();

        // Format data untuk dikirim ke DataTables
        $data = $orders->map(function ($order, $index) use ($start) {
            return [
                'id' => $start + $index + 1,
                'name' => $order->name,
                'total' => 'Rp ' . number_format($order->total, 0, ',', '.'),
                'date' => Carbon::parse($order->date)->format('d-m-Y'),
                'action' => '
                    <button class="btn btn-success" onclick="window.location.href=\'' . route('detil.transaksi', ['id' => $order->id]) . '\'">
                        <i class="fa fa-eye"></i> Lihat
                    </button>
                    <button class="btn btn-primary" onclick="window.location.href=\'' . url('/order/invoice/' . $order->id) . '\'">
                        <i class="fa fa-book"></i> Cetak
                    </button>',
            ];
        });

        // Kembalikan data dalam format JSON yang sesuai dengan DataTables
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
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
        return redirect(route('jual'))->with('message', 'Berhasil disimpan');
    }

    public function riwayat(Request $req)
    {
        $start = $req['start_date'];
        $end = $req['end_date'];
        $kode = $req['kode'];
        // dd($kode);
        if (isset($req['filter'])) {
            // dd($req);
            if ($kode != null) {
                $data = Order::whereBetween('date', [$start, $end])
                    ->orWhere('bill_code', 'like', '%' . $kode . '%')
                    ->get();
            } else {
                $data = Order::whereBetween('date', [$start, $end])
                    ->get();
            }
        } else {
            $data = Order::all();
        }
        return view('kasir.jual', compact('data', 'start', 'end', 'kode'));
    }

    public function edit_payment(Request $req)
    {
        // dd($req);
        $produk = Order::find($req->id);
        $produk->update(["payment" => $req->metode]);
        return redirect(route('riwayat'));
    }

    public function detil_transaksi(Request $req)
    {
        $data = Order::join('product', 'product.order_id', '=', 'order.id')
            ->where('product.order_id', '=', $req['id'])
            ->get();
        return view('kasir.detil_transaksi', compact('data'));
    }

    public function hapus_transaksi(Request $req)
    {
        $data = Order::find($req['id']);
        $data->delete();
        return redirect(route('riwayat'));
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
