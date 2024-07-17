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
        try {

            $request->validate([
                'npk' => 'required',
                'password' => 'required',
            ]);
            
            $credentials = $request->only('npk', 'password');
            try {
                if (Auth::attempt($credentials)) {
                    $userName = Auth::user()->name; // Mengambil nama pengguna yang sedang masuk
                    return redirect()->intended('/')
                    ->withSuccess('Selamat datang kembali ' . $userName);
                }
            } catch (\Exception $e) {
                // Tangani pengecualian dan kirimkan pesan kesalahan ke tampilan
                return redirect()->back()
                ->with('error', 'password' . $e->getMessage());
            }
            
            
            return redirect()->back()->with('error', 'NPK atau Password salah!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal melakukan login. Error: ' . $e->getMessage());
        }
    }

    public function doLogout()
    {
        $userName = Auth::user()->name;
        Auth::logout(); // menghapus session yang aktif
        return redirect()->intended('/')->with('success', 'Sampai bertemu kembali ' . $userName);
    }
}
