<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
                    $userName = Auth::user()->name; 
                    return redirect()->intended('/')
                    ->withSuccess('Selamat datang kembali ' . $userName);
                }
            } catch (\Exception $e) {
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

    public function setFaceAuth(Request $request)
{
    $npk = $request->input('npk');

    // Cek apakah ada di tabel faces
    $face = DB::table('faces')->where('npk', $npk)->first();
    if (!$face) {
        return response()->json(['success' => false, 'error' => 'NPK tidak ditemukan!'], 401);
    }

    // Cek apakah ada di tabel users
    $user = DB::table('users')->where('npk', $npk)->first();
    if (!$user) {
        return response()->json(['success' => false, 'error' => 'User tidak ditemukan!'], 401);
    }

    Auth::loginUsingId($user->id);

    // Simpan session flash message
    Session::flash('success', 'Selamat datang kembali ' . $user->name);

    return response()->json(['success' => true, 'redirect' => url('/home')]);
}





}
