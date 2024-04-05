<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\Periode;
use Illuminate\Http\Request;

class CircleController extends Controller
{

public function store(Request $request)
{
    try {
        // Validasi data yang dikirim dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'leader' => [
                'required',
                'string',
                'max:255',
                // Menambahkan aturan validasi khusus untuk memeriksa apakah nama leader sudah ada di tabel circle
                function ($attribute, $value, $fail) {
                    // Cari circle dengan leader yang sama
                    $existingCircle = Circle::where('leader', $value)->first();
                    
                    if ($existingCircle) {
                        // Jika ada circle dengan leader yang sama, periksa juga periode circle tersebut
                        $activePeriode = Periode::where('status', 1)->first();
                        
                        if ($activePeriode && $activePeriode->periode == $existingCircle->periode) {
                            // Jika periode circle tidak sama dengan periode yang aktif sekarang
                            $fail('Nama leader sudah ada di dalam circle lain untuk periode yang berbeda.');
                        }
                    }
                },
            ],
            'npkMembers.*' => 'required|string|max:255', // Validasi untuk setiap anggota (opsional)
            'npkMembers' => 'required|array|min:3' // Validasi untuk minimal empat anggota
        ], [
            'npkMembers.min' => 'Anggota minimal harus 3 orang.'
        ]);

        // Simpan data circle ke dalam database
        $circle = new Circle();
        $circle->periode = $request->periode;
        $circle->npk_leader = $request->npk_leader;
        $circle->name = $request->name;
        $circle->leader = $request->leader;
        $circle->save();

        // Simpan data NPK anggota ke dalam tabel circles jika ada
if ($request->has('npkMembers')) {
    foreach ($request->npkMembers as $memberNpk) {
        $circle->npkMembers()->create([
            'npk_anggota' => $memberNpk , 
            'l1' => 0,
            'l2' => '0',
            'l3' => '0',
            'l4' => '0',
            'l5' => '0',
            'l6' => '0',
            'l7' => '0',
            'l8' => '0',
            'nqi' => '0',
        ]);
    }
}


        // Redirect ke halaman tertentu setelah penyimpanan berhasil
        return redirect()->route('home')->with('success', 'Circle successfully created.');
    } catch (\Exception $e) {
        // Tangkap error dan tampilkan pesan kesalahan
        return redirect()->back()->with('error', 'Failed to create circle. Error: ' . $e->getMessage());
    }
}



  
}
