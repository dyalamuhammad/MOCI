<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Circle;
use App\Models\Group;
use App\Models\Langkah;
use App\Models\Member;
use App\Models\Periode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QccController extends Controller
{
    public function index($id = null) {
        $periodes = Periode::all(); // Mendapatkan semua data dari tabel periode
        
        $userNpk = auth()->user()->npk; // Mendapatkan npk dari pengguna yang sedang login
        $circles = Circle::all();
        $userRole = auth()->user()->jabatan; // Mendapatkan jabatan dari pengguna yang sedang login
        $showCircle = [];  
        
        if ($userRole === 'Superadmin') {
            $showCircle = $circles;
        } elseif ($userRole === 'TL') {
            $showCircle = Circle::where('npk_leader', $userNpk)->get();
        } else {
            // Temukan id_group yang sesuai berdasarkan npk pengguna yang sedang login
            $idGroup = \App\Models\Group::where('npk_cord', $userNpk)->value('id_group');
            // Mendapatkan npk_leader yang memiliki grp sesuai dengan id_group pengguna yang sedang login
            $npkLeaders = \App\Models\Org::where('grp', $idGroup)->pluck('npk')->toArray();
            // Mendapatkan circle yang npk_leader nya ada di antara npkLeaders
            $showCircle = Circle::whereIn('npk_leader', $npkLeaders)->get();
        }

        // Kirim data ke tampilan
        return view("qcc.monitor.monitor", compact('circles', 'periodes', 'id', 'showCircle'));
    }
    
    
    public function absensi() {
        $periode = Periode::all(); // Mendapatkan semua data dari tabel periode
        $langkahData = Langkah::join('periodes', 'langkah.periode_id', '=', 'periodes.id')
            ->where('periodes.status', 1)
            ->select('langkah.mulai', 'langkah.sampai')
            ->get();
    
        return view("qcc.absensi.absensi", compact('langkahData', 'periode'));
    }
    
    public function resume() {
     
        $circles = Circle::all();
        $periode = Periode::all();
        $user = Auth::user();
    
        // $circle = Auth::user()->circle;
        $members = Member::all();
        

        $circleName = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
    ->where('periodes.status', 1)
    ->value('circles.name');


        return view("qcc.resume", compact('members', 'circleName', 'periode', 'circles'));
    }
    public function dataNqi() {
        return view("qcc.data-nqi");
    }
    public function dataCircle() {
        $circles = Circle::all();
        $groups = Group::all();

        return view("qcc.data-circle", compact('circles', 'groups'));
    }
    public function register() {
        $periode = Periode::query(); // Memulai kueri dengan menggunakan query builder
        $user = Auth::user();

        $periodes = $periode->orderBy('id', 'asc')->get(); // Mengambil hasil kueri dengan get()
        
        $npkLeader = $user->npk;
        $nameLeader = $user->name;
        $data = [
            'periode' => $periodes,
        ];
        return view("qcc.register", $data, compact('npkLeader', 'nameLeader', 'periodes'));
    }    
    
    public function member($id)
    {
        $circle = Circle::find($id);
        $user = User::find($id);

        if (!$circle) {
            abort(404, 'Circle not found');
        }

        $members = Member::where('circle_id', $id)->get();
        // Mendapatkan waktu saat ini dengan zona waktu lokal
        $localTime = Carbon::now();

        // Menyesuaikan zona waktu ke UTC
        $localTime->timezone('Asia/Jakarta');

        return view('qcc.monitor.monitor-member', compact('circle', 'members', 'user', 'localTime'));
    }
}
