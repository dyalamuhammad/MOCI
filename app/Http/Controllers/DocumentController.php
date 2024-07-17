<?php

namespace App\Http\Controllers;

use App\Models\Analisa4m1e;
use App\Models\AspekMutu;
use App\Models\Background;
use App\Models\BackgroundL8;
use App\Models\Circle;
use App\Models\Comment;
use App\Models\CommentQcc2;
use App\Models\CommentQcc3;
use App\Models\CommentQcc4;
use App\Models\CommentQcc5;
use App\Models\CommentQcc6;
use App\Models\CommentQcc7;
use App\Models\CommentQcc8;
use App\Models\CommentQcc9;
use App\Models\DampakPositif;
use App\Models\Departemen;
use App\Models\Group;
use App\Models\ImplemenPerbaikan;
use App\Models\ManfaatPanca;
use App\Models\Notulen1;
use App\Models\Notulen2;
use App\Models\Notulen3;
use App\Models\Notulen4;
use App\Models\Notulen5;
use App\Models\Notulen6;
use App\Models\Notulen7;
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
        // @dd($circleId);
        
        // Temukan data circle berdasarkan circle_id
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }
        
        
        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');
        $backgrounds = Background::where('circle_id', $circleId)->get();
        // @dd($backgrounds);

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
        $notulenId = Notulen1::where('circle_id', $circleId)->value('id');
        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        
        $analisaNotulen = Notulen1::where('circle_id', $circleId)->value('analisa');
    
        $fotoNotulen = Notulen1::where('circle_id', $circleId)->value('foto');

        $namaTema = Tema::where('circle_id', $circleId)->value('nama_tema');
        $alasanTema = Tema::where('circle_id', $circleId)->value('alasan');
        $comment = Comment::where('circle_id', $circleId)->value('comment');

        return view('qcc.absensi.doc.langkah1', compact('circleId','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'analisaNotulen', 'fotoNotulen', 'backgrounds', 'namaTema', 'alasanTema', 'circle', 'notulenId', 'notulenId' ,'comment', 'deptName'));
    }

    public function doc2() {
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
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');        
        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
       
        $notulenId = Notulen2::where('circle_id', $circleId)->value('id');

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
     
        $aspekMutus = AspekMutu::where('circle_id', $circleId)->get();
        $dampaks = DampakPositif::where('circle_id', $circleId)->get();
        $smartCs = SmartC::where('circle_id', $circleId)->get();
        $comment = CommentQcc2::where('notulen_id', $notulenId)->value('comment');


        return view('qcc.absensi.doc.langkah2', compact('circleId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'aspekMutus', 'dampaks', 'smartCs', 'circleId', 'notulenId' ,'comment', 'deptName'));
    }

    public function doc3() {
        $circles = Circle::all();

        $circleId = request()->query('id');
    
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');        

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
       
        $notulenId = Notulen3::where('circle_id', $circleId)->value('id');

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');

        $ujiPenyebabs = UjiPenyebab::where('circle_id', $circleId)->get();
        $analisa4m1es = Analisa4m1e::where('circle_id', $circleId)->get();
        $comment = CommentQcc3::where('circle_id', $circleId)->value('comment');



        return view('qcc.absensi.doc.langkah3', compact('circleId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'ujiPenyebabs', 'analisa4m1es', 'notulenId' ,'comment', 'deptName'));
    }

    public function doc4() {
        $circles = Circle::all();

        $circleId = request()->query('id');
    
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');        

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
       
        $notulenId = Notulen4::where('circle_id', $circleId)->value('id');

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');

        $rencanas = RencanaPerbaikan::where('circle_id', $circleId)->get();
        $comment = CommentQcc4::where('circle_id', $circleId)->value('comment');



        return view('qcc.absensi.doc.langkah4', compact('circleId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'rencanas', 'notulenId' ,'comment', 'deptName'));
    }
    public function doc5() {
        $circles = Circle::all();

        $circleId = request()->query('id');
    
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');        

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
        
        $notulenId = Notulen5::where('circle_id', $circleId)->value('id');

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
       
        
        $implemens = ImplemenPerbaikan::where('circle_id', $circleId)->get();
        $fotoImprove = Notulen5::where('circle_id', $circleId)->value('foto_improve');
        $comment = CommentQcc5::where('circle_id', $circleId)->value('comment');



        return view('qcc.absensi.doc.langkah5', compact('circleId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'implemens', 'fotoImprove', 'notulenId' ,'comment', 'deptName'));
    }
    public function doc6() {
        $circles = Circle::all();

        $circleId = request()->query('id');
    
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');        

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
       
        $notulenId = Notulen6::where('circle_id', $circleId)->value('id');

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        
        $manfaat = ManfaatPanca::where('circle_id', $circleId)->get();
        $comment = CommentQcc6::where('circle_id', $circleId)->value('comment');



        return view('qcc.absensi.doc.langkah6', compact('circleId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'manfaat', 'notulenId' ,'comment', 'deptName'));
    }
    public function doc7() {
       $circles = Circle::all();

        $circleId = request()->query('id');
    
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');        

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
       
        $notulenId = Notulen7::where('circle_id', $circleId)->value('id');

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $standar = Standarisasi::where('circle_id', $circleId)->get();
        $comment = CommentQcc7::where('circle_id', $circleId)->value('comment');



        return view('qcc.absensi.doc.langkah7', compact('circleId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'standar', 'notulenId' ,'comment', 'deptName'));
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
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');
        $backgrounds = BackgroundL8::where('circle_id', $circleId)->get();
        // @dd($backgrounds);

        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
        $notulenId = Notulen8::where('circle_id', $circleId)->value('id');

        // Cari judul dari tabel notulen1 berdasarkan id Circle yang didapatkan
        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        $comment = CommentQcc8::where('circle_id', $circleId)->value('comment');
        
        

        return view('qcc.absensi.doc.langkah8', compact('circleId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'backgrounds', 'notulenId' ,'comment', 'deptName'));
    }
    
    public function doc9() {
        $circles = Circle::all();
        $user = Auth::user();

        $circleId = request()->query('id');
    
        $circle = Circle::where('id', $circleId)->first();
        if ($circle) {
        $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');
        $org = Org::where('npk', $npkLeader)->first();

        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

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
        
        $notulenId = Notulen9::where('circle_id', $circleId)->value('id');

        $judulNotulen = Notulen1::where('circle_id', $circleId)->value('judul');
        
        $manfaat = Notulen9::where('circle_id', $circleId)->value('manfaat');
        $benefit = Notulen9::where('circle_id', $circleId)->value('benefit');
        $fileNqi = Notulen9::where('circle_id', $circleId)->value('file');
        $comment = CommentQcc9::where('circle_id', $circleId)->value('comment');



        return view('qcc.absensi.doc.langkah9', compact('circleId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'benefit', 'manfaat', 'fileNqi', 'notulenId','comment', 'deptName'));
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
   public function downloadNqiFile($fileName)
{
    $filePath = $fileName; // Sesuaikan dengan lokasi file Anda
    @dd($filePath);
    // Pastikan file ada sebelum mencoba untuk mengunduhnya
    if (Storage::exists($filePath)) {
        return Storage::download($filePath);
    } else {
        // Handle jika file tidak ditemukan, misalnya dengan melempar error 404
        abort(404);
    }
}


}
