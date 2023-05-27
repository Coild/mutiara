<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\grosir as x;
use SpreadsheetReader;

require 'excel/SpreadsheetReader.php';
use Exception;

class grosir extends Controller
{

    public function grosir() {
        $data = x::all();
        return view('kasir.grosir', compact('data'));
    }

    public function tambah_grosir() {

    }

    public function edit_grosir() {

    }

    public function import_grosir(Request $req) {
        $file = $req->file('excel');
        $exten = $file->getClientOriginalExtension();
        $nama = $req['nama'] . '_' . substr($req['tanggal'], 0, 10) . '.' . $exten;
        $tujuan_upload = 'data/';
        $file->move($tujuan_upload, $nama);
        try {
            $Spreadsheet = new SpreadsheetReader($tujuan_upload.$nama);
            // dd($Spreadsheet);
            // $Sheets = $Spreadsheet -> Sheets();		

            foreach ($Spreadsheet as  $Row) {
                // echo $Key.': ';
                if ($Row) {
                    $data = [
                        'nama' => $Row[4],
                        'no_hp' => $Row[6],
                        'tema' => $Row[1],
                        'kampus' => $Row[2],
                        'no_peserta' => $Row[3],
                        'email' => $Row[5],
                        'az' => $Row[7] == 'YA' ? true : false,
                        'dp' => $Row[8]  == 'YA' ? true : false,
                        'ai' => $Row[9]  == 'YA' ? true : false,
                        'level' => 0,
                        'password' => bcrypt("akunbaru"),
                    ];
                    dd($data);
                } else {
                    echo "kosong";
                    // return "tidak";
                }
            }
        } catch (Exception $E) {
            echo $E->getMessage();
        }
        return redirect("/list_peserta");
    }

    public function pos_grosir() {
        return view('kasir.pos_grosir');
    }
}
