<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\Langkah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index() {
        $circleCount = Circle::count();

    // Menghitung jumlah circle aktif (dengan status 1)
    $activeCircle1 = Circle::where('l1','>=', 1)->count();
    // Menghitung jumlah circle aktif (dengan l$ 2)
    $activeCircle2 = Circle::where('l2','>=', 1)->count();
    $activeCircle3 = Circle::where('l3','>=', 1)->count();
    $activeCircle4 = Circle::where('l4','>=', 1)->count();
    $activeCircle5 = Circle::where('l5','>=', 1)->count();
    $activeCircle6 = Circle::where('l6','>=', 1)->count();
    $activeCircle7 = Circle::where('l7','>=', 1)->count();
    $activeCircle8 = Circle::where('l8','>=', 1)->count();
    $activeCircle9 = Circle::where('nqi','>=', 1)->count();

    // Mengambil semua data langkah
    $langkahs = Langkah::all();
    
    // Mencari langkah aktif berdasarkan tanggal mulai dan tanggal akhir
    $langkahActive = '';
    $today = Carbon::now()->format('Y-m-d');
    foreach ($langkahs as $langkah) {
        $mulai = $langkah->mulai;
        $sampai = $langkah->sampai;
        if ($today >= $mulai && $today <= $sampai) {
            $langkahActive = $langkah->name;
            break; // Langsung keluar dari perulangan jika sudah menemukan langkah aktif
        }
    }
    // Konversi nilai langkahActive ke bentuk "Langkah 1" hingga "Langkah 9"
    $langkahMap = [
        'L0' => 'Langkah 1',
        'L1' => 'Langkah 2',
        'L2' => 'Langkah 3',
        'L3' => 'Langkah 4',
        'L4' => 'Langkah 5',
        'L5' => 'Langkah 6',
        'L6' => 'Langkah 7',
        'L7' => 'Langkah 8',
        'L8' => 'NQI',
    ];

    $langkahActive = isset($langkahMap[$langkahActive]) ? $langkahMap[$langkahActive] : '';
    // @dd($langkahActive);

    return view('dashboard', compact('circleCount', 'activeCircle1', 'activeCircle2', 'activeCircle3', 'activeCircle4', 'activeCircle5', 'activeCircle6', 'activeCircle7', 'activeCircle8', 'activeCircle9', 'langkahActive'));
    }

    public function profile() {
        $user = Auth::user();

        return view('profile', compact('user'));
    }
}
