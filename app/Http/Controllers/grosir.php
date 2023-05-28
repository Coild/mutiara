<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\grosir as x;
use App\Models\grosir as ModelsGrosir;
use SpreadsheetReader;

require('excel/php-excel-reader/excel_reader2.php');

require('excel/SpreadsheetReader.php');

use Exception;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\Date;

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

    public function hapus_grosir(Request $request) {
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
                            if($row[0] != '') {
                                ModelsGrosir::create($data);
                            }
                            
                        } catch (Exception $err) {
                            echo 'Message: ' .$err->getMessage();
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

    public function print_grosir(Request $req) {
        // dd($req);
        $data = x::find($req['print_id']);
        // dd($data['id']);
        $jumlah = $req['jumlah'];
        
        return view('kasir.barcode', compact('data', 'jumlah'));
        
    }

    public function plus_grosir(Request $req) {
        // dd($req);
        // $data = x::find($req['plus_id']);
        // dd($data);
        x::where('id', $req['plus_id'])
        ->increment('stok', $req['jumlah']);
        // dd($data['id']);
        // $jumlah = $req['jumlah'];
        
        return redirect(route('grosir'));
        
    }
}
