<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // dd(Admin::bersih($request->input('username')));
        $data = [
            'nama'     => $request->input('nama'),
            'password'  => $request->input('password'),
        ];
        // dd($data);
        Auth::attempt($data);
        // dd(Auth::attempt($data));
        if (Auth::attempt($data)) { // true sekalian session field di users nanti bisa dipanggil via Auth
            // echo "Login Success";
            if(Auth::user()->level=='admin'){
                return redirect(route('home'));
            }else {
                return redirect(route('jual'));
            }
            
        } else { // false

            //Login Fail
            return redirect(route('login'))->with('message', 'Username atau password salah');
        }
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect(redirect('login'));
    }

    public function tampil_ganti_password()
    {
        return view('kasir.ganti');
    }

    public function ganti_password(Request $req)
    {

        if (Hash::check($req['lama'], Auth::user()->password)) {
            $id = Auth::user()->id;
            $data = [
                'nama' => $req['nama'] ?? Auth::user()->nama,
                'password' => Hash::make($req['baru']),
            ];
            // dd($data);
            $user = User::all()->where("id", $id)->first()->update($data);
        } else {
            return redirect(route('ganti'))->with('status', 'Kata sandi lama anda salah!');
        }
        return redirect(route('home'))->with('success', 'Password berhasil diganti!');
    }
}
