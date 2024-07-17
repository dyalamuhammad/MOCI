<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\CircleDt;
use App\Models\Langkah;
use App\Models\Member;
use App\Models\MemberDt;
use App\Models\Periode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CbiController extends Controller
{
    public function index(Request $request) {
        $periodes = Periode::all(); // Mendapatkan semua data dari tabel periode
        $activePeriode = Periode::where('status', 1)->first();
        $userNpk = auth()->user()->npk; // Mendapatkan npk dari pengguna yang sedang login
        $userRole = auth()->user()->jabatan; // Mendapatkan jabatan dari pengguna yang sedang login
        
        $search = $request->query('search', '');
        $filter = $request->query('filter', '');

        if($userRole === 'FRM') {
                // Temukan id_group yang sesuai berdasarkan npk pengguna yang sedang login
                $idGroups = \App\Models\Group::where('npk_cord', $userNpk)->pluck('id_group')->toArray();
              
                // Inisialisasi array kosong untuk menyimpan semua npk_leader yang ditemukan
            $npkLeaders = [];
    
                foreach ($idGroups as $idGroup) {
                    // Mendapatkan npk_leader yang memiliki grp sesuai dengan id_group pengguna yang sedang login
                    $npkLeadersGroup = \App\Models\Org::where('grp', $idGroup)->pluck('npk')->toArray();
               
                   // Gabungkan npk_leader yang ditemukan dengan array utama npkLeaders
                $npkLeaders = array_merge($npkLeaders, $npkLeadersGroup); 
            }
            // Menghapus duplikat npk_leader jika ada
            $npkLeaders = array_unique($npkLeaders);
            
            // Mendapatkan circle yang npk_leader nya ada di antara npkLeaders dan filter by periode
            $query = CircleDt::whereIn('npk_leader', $npkLeaders);
            $query->where('category', 'cbi');
        } elseif ($userRole === 'SPV') {
            // Temukan id_group yang sesuai berdasarkan npk pengguna yang sedang login
            $idSects = \App\Models\Section::where('npk_cord', $userNpk)->pluck('id_section')->toArray();

            $npkLeaders = [];
            // Loop melalui setiap idSect untuk mencari npk_leader yang terkait
            foreach ($idSects as $idSect) {
                // Temukan npk_leader yang memiliki sect yang sesuai dengan idSect pengguna yang sedang login
                $npkLeadersGroup = \App\Models\Org::where('sect', $idSect)->pluck('npk')->toArray();
                
                // Gabungkan npk_leader yang ditemukan dengan array utama npkLeaders
                $npkLeaders = array_merge($npkLeaders, $npkLeadersGroup);
            }
            // Menghapus duplikat npk_leader jika ada
            $npkLeaders = array_unique($npkLeaders);

            // Mendapatkan circle yang npk_leader nya ada di antara npkLeaders
            $query = CircleDt::whereIn('npk_leader', $npkLeaders);
            $query->where('category', 'cbi');
        } elseif ($userRole === 'TL') {
            $query = CircleDt::where('npk_leader', $userNpk);
            $query->where('category', 'cbi');
        } else {
            $query = CircleDt::query();
            $query ->where('category', 'cbi');
        }

        if($activePeriode) {
            // Filter berdasarkan periode
            if ($filter && $filter !== 'all') {
                $query->where('periode', $filter);
            } elseif (!$filter && !$search) {
                $query->where('periode', $activePeriode->periode);
            }
        }


        if ($search) {
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('npk_leader', 'like', "%{$search}%")
                    ->orWhereHas('leader', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.group.coordinator', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.section.coordinator', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }


            $showCircle = $query->paginate(50);

        return view("cbi.monitor.monitor", compact('periodes',  'showCircle', 'search', 'activePeriode', 'userRole', 'filter'));
    }

    public function absensi() {
        $periode = Periode::all(); // Mendapatkan semua data dari tabel periode
        $langkahData = Langkah::join('periodes', 'langkah.periode_id', '=', 'periodes.id')
            ->where('periodes.status', 1)
            ->select('langkah.mulai', 'langkah.sampai')
            ->get();
        $userRole = auth()->user()->jabatan; // Mendapatkan jabatan dari pengguna yang sedang login

    
        return view("cbi.absensi.absensi" , compact('langkahData', 'periode', 'userRole'));
    }
    public function resume(Request $request) {
        $periodes = Periode::all();
        $userNpk = Auth::user()->npk;
        $userRole = auth()->user()->jabatan; // Mendapatkan jabatan dari pengguna yang sedang login
        $activePeriode = Periode::where('status', 1)->first();

        $search = $request->query('search', '');
        $filter = $request->query('filter', '');
        if ($userRole === 'SPV'){
            // Temukan id_group yang sesuai berdasarkan npk pengguna yang sedang login
            $idSects = \App\Models\Section::where('npk_cord', $userNpk)->pluck('id_section')->toArray();

            $npkLeaders = [];
            // Loop melalui setiap idSect untuk mencari npk_leader yang terkait
            foreach ($idSects as $idSect) {
                // Temukan npk_leader yang memiliki sect yang sesuai dengan idSect pengguna yang sedang login
                $npkLeadersGroup = \App\Models\Org::where('sect', $idSect)->pluck('npk')->toArray();
                
                // Gabungkan npk_leader yang ditemukan dengan array utama npkLeaders
                $npkLeaders = array_merge($npkLeaders, $npkLeadersGroup);
            }
            // Menghapus duplikat npk_leader jika ada
            $npkLeaders = array_unique($npkLeaders);
            $query = MemberDt::query()
                ->join('circles_dt_cbi', 'members_dt.circle_id', '=', 'circles_dt_cbi.id')
                ->where('category', 'cbi')
                ->whereIn('circles_dt_cbi.npk_leader', $npkLeaders)
                ->select('members_dt.*');
        } elseif ($userRole === 'FRM'){
            // Temukan id_group yang sesuai berdasarkan npk pengguna yang sedang login
                $idGroups = \App\Models\Group::where('npk_cord', $userNpk)->pluck('id_group')->toArray();
              
                // Inisialisasi array kosong untuk menyimpan semua npk_leader yang ditemukan
            $npkLeaders = [];
    
                foreach ($idGroups as $idGroup) {
                    // Mendapatkan npk_leader yang memiliki grp sesuai dengan id_group pengguna yang sedang login
                    $npkLeadersGroup = \App\Models\Org::where('grp', $idGroup)->pluck('npk')->toArray();
               
                   // Gabungkan npk_leader yang ditemukan dengan array utama npkLeaders
                $npkLeaders = array_merge($npkLeaders, $npkLeadersGroup); 
            }
            $npkLeaders = array_unique($npkLeaders);
            $query = MemberDt::query()
                ->join('circles_dt_cbi', 'members_dt.circle_id', '=', 'circles_dt_cbi.id')
                ->where('category', 'cbi')
                ->whereIn('circles_dt_cbi.npk_leader', $npkLeaders)
                ->select('members_dt.*');
        }elseif ($userRole === 'TL') {
            $query = MemberDt::query()
                ->join('circles_dt_cbi', 'members_dt.circle_id', '=', 'circles_dt_cbi.id')
                ->where('category', 'cbi')
                ->where('circles_dt_cbi.npk_leader', $userNpk)
                ->select('members_dt.*');
        } else {
            $query = MemberDt::query()
                ->join('circles_dt_cbi', 'members_dt.circle_id', '=', 'circles_dt_cbi.id')
                ->where('category', 'cbi')
                ->select('members_dt.*');
        }

            if($activePeriode) {
            // Filter berdasarkan periode
                if ($filter && $filter !== 'all') {
                    $query->where('circles_dt_cbi.periode', $filter);
                } elseif (!$filter && !$search) {
                    $query->where('circles_dt_cbi.periode', $activePeriode->periode);
                }
            }

        // Pencarian berdasarkan nama atau NPK
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('members_dt.npk_anggota', 'like', "%{$search}%")
                  ->orWhere(function ($q) use ($search) {
                      $q->whereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('circle', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                  });
            });
        }

        $members = $query->paginate(50);
        

        $circleName = Circle::where('npk_leader', $userNpk)
            ->join('periodes', 'circles.periode', '=', 'periodes.periode')
            ->where('periodes.status', 1)
            ->value('circles.name');
        
        $totalDisplayedRows = $members->count() + $members->groupBy('circle_id')->count();

        return view("cbi.resume", compact('members', 'circleName', 'periodes', 'activePeriode', 'search', 'userRole', 'filter', 'totalDisplayedRows'));
    }

    public function member($id)
    {
        $circle = CircleDt::find($id);
        $user = User::find($id);

        if (!$circle) {
            abort(404, 'Circle not found');
        }

        $members = MemberDt::where('circle_id', $id)->get();
        // Mendapatkan waktu saat ini dengan zona waktu lokal
        $localTime = Carbon::now();

        // Menyesuaikan zona waktu ke UTC
        $localTime->timezone('Asia/Jakarta');

        return view('cbi.monitor.detail-circle', compact('circle', 'members', 'user', 'localTime'));
    }
}
