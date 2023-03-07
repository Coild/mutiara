<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return redirect('/login')->with('message', 'Username atau password salah');
        }
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect('login');
    }
}
