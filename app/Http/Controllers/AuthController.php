<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        return view("login");
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'npk' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('npk', 'password');
        if (Auth::attempt($credentials)) {
            $userName = Auth::user()->name; // Mengambil nama pengguna yang sedang masuk
            return redirect()->intended('/')
                ->withSuccess('Selamat datang kembali ' . $userName);
        }

        return redirect()->back()->with('error', 'NPK atau Password salah!');
    }

    public function doLogout()
    {
        $userName = Auth::user()->name;
        Auth::logout(); // menghapus session yang aktif
        return redirect('/login')->with('success', 'Sampai bertemu kembali ' . $userName);
    }
}
