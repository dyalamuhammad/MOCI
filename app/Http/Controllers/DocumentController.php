<?php

namespace App\Http\Controllers;

use App\Models\Analisa4m1e;
use App\Models\AspekMutu;
use App\Models\Background;
use App\Models\BackgroundL8;
use App\Models\Circle;
use App\Models\DampakPositif;
use App\Models\Group;
use App\Models\ImplemenPerbaikan;
use App\Models\ManfaatPanca;
use App\Models\Notulen1;
use App\Models\Notulen4;
use App\Models\Notulen5;
use App\Models\Notulen8;
use App\Models\Notulen9;
use App\Models\Org;
use App\Models\RencanaPerbaikan;
use App\Models\SmartC;
use App\Models\Standarisasi;
use App\Models\Tema;
use App\Models\UjiPenyebab;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function doc1(Request $request) {
        $circles = Circle::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }
        
        
        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $sectionLeader = User::where('npk', $npkLeader)->value('section');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');
        $backgrounds = Background::where('circle_id', $circleId)->get();
        // @dd($backgrounds);

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } 

        // Cari judul dari tabel notulen1 berdasarkan id Circle yang didapatkan
        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        
        $analisaNotulen = Notulen1::where('circle_id', $circleId)->value('analisa');
    
        $fotoNotulen = Notulen1::where('circle_id', $circleId)->value('foto');

        $namaTema = Tema::where('circle_id', $circleId)->value('nama_tema');
        $alasanTema = Tema::where('circle_id', $circleId)->value('alasan');

        return view('qcc.absensi.doc.langkah1', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'analisaNotulen', 'fotoNotulen', 'backgrounds', 'namaTema', 'alasanTema'));
    }
 
    
    
    public function doc2() {
        $circles = Circle::all();
        $user = Auth::user();

        $circleId = request()->query('id');
    
        $circle = Auth::user()->circle;
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $org = Org::where('npk', $user->npk)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $npkLeader = $user->npk;
        $sectionLeader = $user->section;
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');
        $nama_cord = $user_cord->name;
        $aspekMutus = AspekMutu::where('circle_id', $circleId)->get();
        $dampaks = DampakPositif::where('circle_id', $circleId)->get();
        $smartCs = SmartC::where('circle_id', $circleId)->get();


        return view('qcc.absensi.doc.langkah2', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'aspekMutus', 'dampaks', 'smartCs'));
    }

    public function doc3() {
        $circles = Circle::all();
        $user = Auth::user();

        $circleId = request()->query('id');
    
        $circle = Auth::user()->circle;
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $org = Org::where('npk', $user->npk)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $npkLeader = $user->npk;
        $sectionLeader = $user->section;
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');
        $nama_cord = $user_cord->name;
        $ujiPenyebabs = UjiPenyebab::where('circle_id', $circleId)->get();
        $analisa4m1es = Analisa4m1e::where('circle_id', $circleId)->get();


        return view('qcc.absensi.doc.langkah3', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'ujiPenyebabs', 'analisa4m1es'));
    }

    public function doc4() {
        $circles = Circle::all();
        $user = Auth::user();

        $circleId = request()->query('id');
    
        $circle = Auth::user()->circle;
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $org = Org::where('npk', $user->npk)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $npkLeader = $user->npk;
        $sectionLeader = $user->section;
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');
        $nama_cord = $user_cord->name;
        $rencanas = RencanaPerbaikan::where('circle_id', $circleId)->get();
        $designImprove = Notulen4::where('circle_id', $circleId)->value('design_improve');


        return view('qcc.absensi.doc.langkah4', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'rencanas', 'designImprove'));
    }
    public function doc5() {
        $circles = Circle::all();
        $user = Auth::user();

        $circleId = request()->query('id');
    
        $circle = Auth::user()->circle;
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $org = Org::where('npk', $user->npk)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $npkLeader = $user->npk;
        $sectionLeader = $user->section;
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');
        $nama_cord = $user_cord->name;
        $implemens = ImplemenPerbaikan::where('circle_id', $circleId)->get();
        $fotoImprove = Notulen5::where('circle_id', $circleId)->value('foto_improve');


        return view('qcc.absensi.doc.langkah5', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'implemens', 'fotoImprove'));
    }
    public function doc6() {
        $circles = Circle::all();
        $user = Auth::user();

        $circleId = request()->query('id');
    
        $circle = Auth::user()->circle;
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $org = Org::where('npk', $user->npk)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $npkLeader = $user->npk;
        $sectionLeader = $user->section;
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');
        $nama_cord = $user_cord->name;
        $manfaat = ManfaatPanca::where('circle_id', $circleId)->get();


        return view('qcc.absensi.doc.langkah6', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'manfaat'));
    }
    public function doc7() {
        $circles = Circle::all();
        $user = Auth::user();

        $circleId = request()->query('id');
    
        $circle = Auth::user()->circle;
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $org = Org::where('npk', $user->npk)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $npkLeader = $user->npk;
        $sectionLeader = $user->section;
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');
        $nama_cord = $user_cord->name;
        $standar = Standarisasi::where('circle_id', $circleId)->get();


        return view('qcc.absensi.doc.langkah7', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'standar'));
    }
    public function doc8(Request $request) {
        $circles = Circle::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }
        
        
        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $sectionLeader = User::where('npk', $npkLeader)->value('section');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');
        $backgrounds = BackgroundL8::where('circle_id', $circleId)->get();
        // @dd($backgrounds);

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } 

        // Cari judul dari tabel notulen1 berdasarkan id Circle yang didapatkan
        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        

        return view('qcc.absensi.doc.langkah8', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'backgrounds'));
    }
    
    public function doc9() {
        $circles = Circle::all();
        $user = Auth::user();

        $circleId = request()->query('id');
    
        $circle = Auth::user()->circle;
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $org = Org::where('npk', $user->npk)->first();

        if ($org) {
            // Ambil grp tema_leader
            $grp_tema_leader = $org->grp;

            // Cari npk_cord dari tabel Group berdasarkan id_group yang sesuai dengan grp tema_leader
            $group_data = Group::where('id_group', $grp_tema_leader)->first();

            if ($group_data) {
                // Ambil npk_cord
                $npk_cord = $group_data->npk_cord;

                // Cari nama koordinator berdasarkan npk_cord
                $user_cord = User::where('npk', $npk_cord)->first();

                if ($user_cord) {
                    // Jika nama koordinator ditemukan, tampilkan
                    $nama_cord = $user_cord->name;
                } else {
                    // Jika npk_cord tidak ditemukan di tabel User
                    echo "Nama Koordinator tidak ditemukan.";
                }
            } else {
                // Jika data grup tidak ditemukan di tabel Group
                echo "Data grup tidak ditemukan.";
            }
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $npkLeader = $user->npk;
        $sectionLeader = $user->section;
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');
        $nama_cord = $user_cord->name;
        $manfaat = Notulen9::where('circle_id', $circleId)->value('manfaat');
        $benefit = Notulen9::where('circle_id', $circleId)->value('benefit');
        $fileNqi = Notulen9::where('circle_id', $circleId)->value('file');


        return view('qcc.absensi.doc.langkah9', compact('members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'sectionLeader', 'judulNotulen', 'benefit', 'manfaat', 'fileNqi'));
    }

    public function lihatFile($nama_file)
    {
        // Lakukan validasi nama file jika diperlukan
        
        // Path ke direktori penyimpanan file
        $path = public_path($nama_file);

        // Periksa apakah file ada
        if (Storage::exists($path)) {
            // Jika file ada, kembalikan file
            return response()->file($path);
        } else {
            // Jika file tidak ditemukan, tampilkan pesan error
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }
    }
}
