<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Circle;
use App\Models\Group;
use App\Models\Langkah;
use App\Models\Member;
use App\Models\Notulen9;
use App\Models\NotulenCbi9;
use App\Models\NotulenDt9;
use App\Models\Periode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QccController extends Controller
{
    public function index(Request  $request,$id = null) {
        $periodes = Periode::all(); // Mendapatkan semua data dari tabel periode
        $activePeriode = Periode::where('status', 1)->first();
        $userNpk = auth()->user()->npk; // Mendapatkan npk dari pengguna yang sedang login
        $userRole = auth()->user()->jabatan; // Mendapatkan jabatan dari pengguna yang sedang login

        $search = $request->query('search', '');
        $filter = $request->query('filter', '');

        if ($userRole === 'FRM') {
            // Temukan id_group yang sesuai berdasarkan npk pengguna yang sedang login
            $idGroups = \App\Models\Group::where('npk_cord', $userNpk)->pluck('id_group')->toArray();
            // Inisialisasi array kosong untuk menyimpan semua npk_leader yang ditemukan
            $npkLeaders = [];
            
            // Loop melalui setiap idGroup untuk mencari npk_leader yang terkait
            foreach ($idGroups as $idGroup) {
                // Temukan npk_leader yang memiliki grup yang sesuai dengan id_group pengguna yang sedang login
                $npkLeadersGroup = \App\Models\Org::where('grp', $idGroup)->pluck('npk')->toArray();
                
                // Gabungkan npk_leader yang ditemukan dengan array utama npkLeaders
                $npkLeaders = array_merge($npkLeaders, $npkLeadersGroup);
            }
            // Menghapus duplikat npk_leader jika ada
            $npkLeaders = array_unique($npkLeaders);
            // @dd($npkLeaders);

            // Mendapatkan circle yang npk_leader nya ada di antara npkLeaders dan filter by periode
            $query = Circle::whereIn('npk_leader', $npkLeaders);
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
            $query = Circle::whereIn('npk_leader', $npkLeaders);
        } elseif ($userRole === 'TL') {
            $query = Circle::where('npk_leader', $userNpk);
        } else {
            $query = Circle::query();
        }

        if ($activePeriode) {
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
        


        // Kirim data ke tampilan
        return view("qcc.monitor.monitor", compact( 'periodes', 'id', 'showCircle', 'search', 'activePeriode', 'userRole', 'filter'));
    }
    
    
    public function absensi() {
        $userRole = auth()->user()->jabatan;
        $periode = Periode::all(); // Mendapatkan semua data dari tabel periode
        $langkahData = Langkah::join('periodes', 'langkah.periode_id', '=', 'periodes.id')
            ->where('periodes.status', 1)
            ->select('langkah.mulai', 'langkah.sampai')
            ->get();
    
        return view("qcc.absensi.absensi", compact('langkahData', 'periode', 'userRole'));
    }
    
    public function resume(Request $request) {
     
        $periode = Periode::all();
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
            $query = Member::query()
                ->join('circles', 'members.circle_id', '=', 'circles.id')
                ->whereIn('circles.npk_leader', $npkLeaders)
                ->select('members.*');
        } elseif ($userRole === 'FRM') {
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
            // @dd($npkLeaders);
            $query = Member::query()
                ->join('circles', 'members.circle_id', '=', 'circles.id')
                ->whereIn('circles.npk_leader', $npkLeaders)
                ->select('members.*');
        } elseif ($userRole === 'TL') {
            $query = Member::query()
                ->join('circles', 'members.circle_id', '=', 'circles.id')
                ->where('circles.npk_leader', $userNpk)
                ->select('members.*');
        } else {
            $query = Member::query()
                ->join('circles', 'members.circle_id', '=', 'circles.id')
                ->select('members.*');

        }

        if ($activePeriode) {
            // Filter berdasarkan periode
            if ($filter && $filter !== 'all') {
                $query->where('circles.periode', $filter);
            } elseif (!$filter && !$search) {
                $query->where('circles.periode', $activePeriode->periode);
            }
        }

        // Pencarian berdasarkan nama atau NPK
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('members.npk_anggota', 'like', "%{$search}%")
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

        $members = $query->paginate(20);
        

        $circleName = Circle::where('npk_leader', $userNpk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.name');

        $totalDisplayedRows = $members->count() + $members->groupBy('circle_id')->count();



        return view("qcc.resume", compact('members', 'circleName', 'periode', 'activePeriode', 'search', 'filter', 'userRole', 'totalDisplayedRows'));
    }
    public function dataNqi(Request $request) {
        $periodes = Periode::all();
        $search = $request->query('search', '');
        $filter = $request->query('filter', '');
        $activePeriode = Periode::where('status', 1)->first();

        // Ambil periode dari request, gunakan periode default jika tidak ada
        $periode = $request->input('periode', 'default_periode');

        // Filter data berdasarkan periode
        $cbi = NotulenCbi9::query()
            ->join('circles', 'notulen_cbi_9.circle_id', '=', 'circles.id')
            ->where('circles.periode', $periode)
            ->select('notulen_cbi_9.*')
            ->get();
        $dt = NotulenDt9::query()
            ->join('circles', 'notulen_dt_9.circle_id', '=', 'circles.id')
            ->where('circles.periode', $periode)
            ->select('notulen_dt_9.*')
            ->get();
        $qcc = Notulen9::query()
            ->join('circles', 'notulen_qcc_9.circle_id', '=', 'circles.id')
            ->where('circles.periode', $periode)
            ->select('notulen_qcc_9.*')
            ->get();

        $data = [
            'groups' => Group::all(),
            'circles' => Circle::all(),
        ];
        return view("qcc.data-nqi", $data, compact('search', 'filter', 'activePeriode', 'periodes', 'cbi', 'periode', 'dt', 'qcc'));
    }
    public function dataCircle() {
        $data = [
            'groups' => Group::all(),
            'circles' => Circle::all(),
            'cbi' => NotulenCbi9::all(),
            'dt' => NotulenDt9::all(),
            'qcc' => Notulen9::all(),
        ];

        return view("qcc.data-circle", $data);
    }
    public function register() {
        $activePeriode = Periode::where('status', 1)->first();
        // Jika tidak ada periode yang aktif, kembalikan pesan error
        if ($activePeriode)  {
            $langkah = Langkah::where('name', 'L0')->where('periode_id', $activePeriode->id)->first();
            $today = Carbon::now()->toDateString(); // Tanggal hari ini
                $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
                $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0
    
                if ($today > $endDate) {
                    $error = 'Masa registrasi telah berakhir.';
                } 
                elseif ($today < $startDate) {
                    $formattedStartDate = Carbon::parse($startDate)->translatedFormat('j F Y');
                    $error = 'Masa registrasi belum dimulai. Akan dimulai tanggal ' . $formattedStartDate;
                } else {
                    $error = null; // Tidak ada error
                }
        } else {
            $error = 'Periode belum dibuat';
        }
        $user = Auth::user();

        $periode = Periode::orderBy('id', 'asc')->get(); // Mengambil hasil kueri dengan get()
        
        $npkLeader = $user->npk;
        $nameLeader = $user->name;
       
        return view("qcc.register", compact('npkLeader', 'nameLeader', 'periode', 'error'));
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

        return view('qcc.monitor.detail-circle', compact('circle', 'members', 'user', 'localTime'));
    }
}
