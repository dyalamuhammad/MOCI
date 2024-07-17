<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\CircleDt;
use App\Models\Departemen;
use App\Models\Group;
use App\Models\Langkah;
use App\Models\Org;
use App\Models\Periode;
use App\Models\PowerMeter;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AppController extends Controller
{
    public function praDashboard() {
        return view ('pra-dashboard');
    }
    public function index(Request $request) {
        // Ambil nilai filter dari request
        $filter = $request->filter;

        
        $activePeriode = $filter ? Periode::where('periode', $filter)->first() : Periode::where('status', 1)->first();

            // Cari periode berdasarkan filter, atau ambil periode pertama jika filter tidak ada
        if (!$activePeriode) {
            // Jika tabel periode kosong, atur variabel terkait ke 0 atau nilai default lainnya
            $circleCount = 0;
            $circleCountDt = 0;
            $circleCountCbi = 0;
            $activeCircle1 = 0;
            $activeCircle2 = 0;
            $activeCircle3 = 0;
            $activeCircle4 = 0;
            $activeCircle5 = 0;
            $activeCircle6 = 0;
            $activeCircle7 = 0;
            $activeCircle8 = 0;
            $activeCircle9 = 0;
            $activeCircleDt1 = 0;
            $activeCircleDt2 = 0;
            $activeCircleDt3 = 0;
            $activeCircleDt4 = 0;
            $activeCircleDt5 = 0;
            $activeCircleDt6 = 0;
            $activeCircleDt7 = 0;
            $activeCircleDt8 = 0;
            $activeCircleDt9 = 0;
            $activeCircleCbi1 = 0;
            $activeCircleCbi2 = 0;
            $activeCircleCbi3 = 0;
            $activeCircleCbi4 = 0;
            $activeCircleCbi5 = 0;
            $activeCircleCbi6 = 0;
            $activeCircleCbi7 = 0;
            $activeCircleCbi8 = 0;
            $activeCircleCbi9 = 0;
        } else {
            $circleCount = Circle::where('periode', $activePeriode->periode)->count();

            $circleCountDt = CircleDt::where('periode', $activePeriode->periode)->where('category', 'DT')->count();
            $circleCountCbi = CircleDt::where('periode', $activePeriode->periode)->where('category', 'CBI')->count();


            // -----QCC-----
            // Menghitung jumlah circle aktif (dengan status 1)
            $activeCircle1 = Circle::where('periode', $activePeriode->periode)->where('l1','>=', 1)->count();
            // Menghitung jumlah circle aktif (dengan l$ 2)
            $activeCircle2 = Circle::where('periode', $activePeriode->periode)->where('l2','>=', 1)->count();
            $activeCircle3 = Circle::where('periode', $activePeriode->periode)->where('l3','>=', 1)->count();
            $activeCircle4 = Circle::where('periode', $activePeriode->periode)->where('l4','>=', 1)->count();
            $activeCircle5 = Circle::where('periode', $activePeriode->periode)->where('l5','>=', 1)->count();
            $activeCircle6 = Circle::where('periode', $activePeriode->periode)->where('l6','>=', 1)->count();
            $activeCircle7 = Circle::where('periode', $activePeriode->periode)->where('l7','>=', 1)->count();
            $activeCircle8 = Circle::where('periode', $activePeriode->periode)->where('l8','>=', 1)->count();
            $activeCircle9 = Circle::where('periode', $activePeriode->periode)->where('nqi','>=', 1)->count();

            // -----DESIGN THINKING-----
            $activeCircleDt1 = CircleDt::where('periode', $activePeriode->periode)->where('l1','>=', 1)->where('category', 'DT')->count();
            $activeCircleDt2 = CircleDt::where('periode', $activePeriode->periode)->where('l2','>=', 1)->where('category', 'DT')->count();
            $activeCircleDt3 = CircleDt::where('periode', $activePeriode->periode)->where('l3','>=', 1)->where('category', 'DT')->count();
            $activeCircleDt4 = CircleDt::where('periode', $activePeriode->periode)->where('l4','>=', 1)->where('category', 'DT')->count();
            $activeCircleDt5 = CircleDt::where('periode', $activePeriode->periode)->where('l5','>=', 1)->where('category', 'DT')->count();
            $activeCircleDt6 = CircleDt::where('periode', $activePeriode->periode)->where('l6','>=', 1)->where('category', 'DT')->count();
            $activeCircleDt7 = CircleDt::where('periode', $activePeriode->periode)->where('l7','>=', 1)->where('category', 'DT')->count();
            $activeCircleDt8 = CircleDt::where('periode', $activePeriode->periode)->where('l8','>=', 1)->where('category', 'DT')->count();
            $activeCircleDt9 = CircleDt::where('periode', $activePeriode->periode)->where('nqi','>=', 1)->where('category', 'DT')->count();

            // -----CBI-----
            $activeCircleCbi1 = CircleDt::where('periode', $activePeriode->periode)->where('l1','>=', 1)->where('category', 'CBI')->count();
            $activeCircleCbi2 = CircleDt::where('periode', $activePeriode->periode)->where('l2','>=', 1)->where('category', 'CBI')->count();
            $activeCircleCbi3 = CircleDt::where('periode', $activePeriode->periode)->where('l3','>=', 1)->where('category', 'CBI')->count();
            $activeCircleCbi4 = CircleDt::where('periode', $activePeriode->periode)->where('l4','>=', 1)->where('category', 'CBI')->count();
            $activeCircleCbi5 = CircleDt::where('periode', $activePeriode->periode)->where('l5','>=', 1)->where('category', 'CBI')->count();
            $activeCircleCbi6 = CircleDt::where('periode', $activePeriode->periode)->where('l6','>=', 1)->where('category', 'CBI')->count();
            $activeCircleCbi7 = CircleDt::where('periode', $activePeriode->periode)->where('l7','>=', 1)->where('category', 'CBI')->count();
            $activeCircleCbi8 = CircleDt::where('periode', $activePeriode->periode)->where('l8','>=', 1)->where('category', 'CBI')->count();
            $activeCircleCbi9 = CircleDt::where('periode', $activePeriode->periode)->where('nqi','>=', 1)->where('category', 'CBI')->count();

        }


        if (!$activePeriode) {
            // Jika tabel periode kosong, atur variabel terkait ke nilai default
            $langkahActive = '';
        } else {
            // Mengambil semua data langkah
            $langkahs = Langkah::where('periode_id', $activePeriode->id)->get();
            
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
        }



        // @dd($langkahActive);
        $periodes = Periode::all(); // Mendapatkan semua data dari tabel periode
        $filter = $request->filter ?? '';
        $activePeriode = Periode::where('status', 1)->first();


        return view('dashboard', compact(
            'periodes',
            'activePeriode',
            'filter',
            'circleCount', 
            'circleCountDt', 
            'circleCountCbi', 
            'activeCircle1', 
            'activeCircle2', 
            'activeCircle3', 
            'activeCircle4',
            'activeCircle5',
            'activeCircle6',
            'activeCircle7',
            'activeCircle8',
            'activeCircle9',
            'activeCircleDt1', 
            'activeCircleDt2', 
            'activeCircleDt3', 
            'activeCircleDt4',
            'activeCircleDt5',
            'activeCircleDt6',
            'activeCircleDt7',
            'activeCircleDt8',
            'activeCircleDt9',
            'activeCircleCbi1', 
            'activeCircleCbi2', 
            'activeCircleCbi3', 
            'activeCircleCbi4',
            'activeCircleCbi5',
            'activeCircleCbi6',
            'activeCircleCbi7',
            'activeCircleCbi8',
            'activeCircleCbi9',
            'langkahActive')
        );
}

    public function profile() {
        $user = Auth::user();
        // Ambil NPK user yang sedang login
        $userNpk = auth()->user()->npk;

        $jabatan = $user->jabatan;

        if ($jabatan == 'TL') {
            $jabatan = 'Team Leader';
        } elseif ($jabatan == 'FRM') {
            $jabatan = 'Foreman';
        } elseif ($jabatan == 'SPV') {
            $jabatan = 'Supervisor';
        } elseif ($jabatan == 'MNG' OR $jabatan == 'AMNG') {
            $jabatan = 'Manager';
        } elseif ($jabatan == 'DH') {
            $jabatan = 'Division Head';
        }

        // Cari record di tabel Org berdasarkan NPK user
        $org = Org::where('npk', $userNpk)->first();

        // Jika record ditemukan, ambil ID group dari tabel Org
        if ($org) {
            $groupId = $org->grp;

            // Cari nama group berdasarkan ID group
            $groupName = Group::where('id_group', $groupId)->value('nama_group');
        } else {
            $groupName = "Tidak ada group"; // Atau tindakan lain jika user tidak memiliki grup
        }

        // Jika record ditemukan, ambil ID group dari tabel Org
        if ($org) {
            $sectionId = $org->sect;

            // Cari nama group berdasarkan ID group
            $sectName = Section::where('id_section', $sectionId)->value('section');
        } else {
            $sectName = "Tidak ada section"; // Atau tindakan lain jika user tidak memiliki grup
        }

        // Jika record ditemukan, ambil ID group dari tabel Org
        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

        return view('profile', compact('user', 'groupName', 'sectName', 'deptName', 'jabatan'));
    }

    public function editPassword(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'password' => 'required', // Sesuaikan dengan kebutuhan validasi Anda
            ]);

            // Ambil id pengguna yang sedang masuk
            $userId = Auth::id();

            // Ambil data pengguna
            $user = \App\Models\User::findOrFail($userId);

            // Perbarui kata sandi pengguna
            $user->password = Hash::make($request->password);
            $user->save();

            // Redirect kembali ke halaman profil dengan pesan sukses
            return redirect()->back()->with('success', 'Password berhasil diperbarui.');
         
    
        
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal edit password. Error: ' . $e->getMessage());
        }
    }
}
