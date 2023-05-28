<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\grosir as x;
use App\Models\grosir_sell;
use App\Models\Order;
use App\Models\order_grosir;
use Carbon\Carbon;
use SpreadsheetReader;

require('excel/php-excel-reader/excel_reader2.php');

require('excel/SpreadsheetReader.php');

use Exception;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;

class grosir extends Controller
{

    public function grosir()
    {
        $data = x::all();
        return view('kasir.grosir', compact('data'));
    }

    public function tambah_grosir(Request $request)
    {
        $string = uniqid(rand());
        $randomString = substr($string, 0, 8);

        $data = new x();
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
        // $data->status = 0;

        $data->save();

        return redirect(route('grosir'));
    }

    public function edit_grosir(Request $request)
    {
        // dd($request);
        $data = x::firstWhere('id', $request['id']);
        // dd($data);
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
        $data->update();

        return redirect(route('grosir'));
    }

    public function hapus_grosir(Request $request)
    {
        $data = x::findOrFail($request['id']);
        $data->delete();

        return redirect(route('grosir'));
    }

    public function import_grosir(Request $req)
    {
        // dd($req);
        $file = $req->file('uploaded_file');
        $exten = $file->getClientOriginalExtension();
        $nama = 'files' . '.' . $exten;
        $tujuan_upload = 'data/';
        $file->move($tujuan_upload, $nama);
        // dd($tujuan_upload.$nama);
        try {
            $Spreadsheet = new SpreadsheetReader($tujuan_upload . $nama);
            // dd($Spreadsheet);
            // $Sheets = $Spreadsheet->Sheets();
            // dd($Sheets);
            $index = 0;
            foreach ($Spreadsheet as  $row) {
                // echo $Key.': ';
                $index++;
                if ($index > 1) {
                    $string = uniqid(rand());
                    $randomString = substr($string, 0, 8);
                    // dd($row);
                    if ($row) {
                        $data = [
                            'type' => $row[1],
                            'metal' => $row[2],
                            'carat' => $row[3],
                            'weight1' => $row[4],
                            'pearls' => $row[5],
                            'color' => $row[6],
                            'shape' => $row[7],
                            'grade' => $row[8],
                            'weight2' => $row[9],
                            'size' => $row[10],
                            'price' => $row[11],
                            'price_sell' => $row[12],
                            'price_discount' => $row[12],
                            'barcode' => $randomString,
                            'discount' => 0,
                            'stok' => 13,
                        ];
                        // dd($data);
                        try {
                            if ($row[1] != '') {
                                // dd($data);
                                $cek = x::create($data);
                            }
                        } catch (Exception $err) {
                            echo 'Message: ' . $err->getMessage();
                        }
                    } else {
                        echo "kosong";
                        // return "tidak";
                    }
                }
            }
        } catch (Exception $E) {
            echo $E->getMessage();
        }
        return redirect(route('grosir'));
    }

    public function pos_grosir()
    {
        return view('kasir.pos_grosir');
    }

    public function beli_grosir(Request $req)
    {
        // dd(Session::get('data_grosir'));
        // dd($req);
        $barang = [];

        foreach (Session::get('data_grosir') as  $key => $item) {
            array_push($barang, [
                'product_id' => $item['id'],
                'discount' =>  $req['diskon' . $key] ?? 0,
                'jumlah' =>  $req['jumlah' . $key] ?? 0,
                'total' =>  $req['total' . $key] ?? 0,
            ]);
        }

        $beli = [
            'name' => $req['nama'],
            'uang' =>  intval(str_replace('.', '', $req['diterima'])),
            'order' => $barang
        ];


        // return $barang;

        $today = Carbon::now()->format('Y-m-d');
        $data = new order_grosir();

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

            $product = x::where('id', '=', $r['product_id'])->first();
            // return $product;

            $total += $r['total'];

            // return $product->price;
            $product->stok = $product->stok - $r['jumlah'];
            $inputdata = [
                'order_id' => $data->id,
                'grosir_id' => $r['product_id'],
                'diskon' => $r['discount'],
                'jumlah' => $r['jumlah'],
                'total' => $r['total'],
            ];
            grosir_sell::insert($inputdata);
            $product->update();
        }
        $data->total = $total;
        $data->kembalian = $data->uang - $total;
        $data->update();


        Session::forget('data_grosir');
        Session::forget('total_grosir');
        return redirect(route('pos_grosir'))->with('message', 'Berhasil disimpan');
    }

    public function print_grosir(Request $req)
    {
        // dd($req);
        $data = x::find($req['print_id']);
        // dd($data['id']);
        $jumlah = $req['jumlah'];

        return view('kasir.barcode', compact('data', 'jumlah'));
    }

    public function plus_grosir(Request $req)
    {
        // dd($req);
        // $data = x::find($req['plus_id']);
        // dd($data);
        x::where('id', $req['plus_id'])
            ->increment('stok', $req['jumlah']);
        // dd($data['id']);
        // $jumlah = $req['jumlah'];

        return redirect(route('grosir'));
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
