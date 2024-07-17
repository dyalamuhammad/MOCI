<?php

namespace App\Http\Controllers;

use App\Models\Analisa4m1e;
use App\Models\AspekMutu;
use App\Models\Background;
use App\Models\BackgroundL8;
use App\Models\Brainstorming;
use App\Models\Circle;
use App\Models\CircleDt;
use App\Models\Comment;
use App\Models\CommentDt;
use App\Models\CommentDt2;
use App\Models\CommentDt3;
use App\Models\CommentDt4;
use App\Models\CommentDt5;
use App\Models\CommentDt6;
use App\Models\CommentDt7;
use App\Models\CommentDt8;
use App\Models\CommentDt9;
use App\Models\DampakPositif;
use App\Models\Departemen;
use App\Models\Group;
use App\Models\ImplemenPerbaikan;
use App\Models\Iterasi;
use App\Models\ManfaatPanca;
use App\Models\Notulen1;
use App\Models\Notulen4;
use App\Models\Notulen5;
use App\Models\Notulen8;
use App\Models\Notulen9;
use App\Models\NotulenDt1;
use App\Models\NotulenDt2;
use App\Models\NotulenDt3;
use App\Models\NotulenDt4;
use App\Models\NotulenDt5;
use App\Models\NotulenDt6;
use App\Models\NotulenDt7;
use App\Models\NotulenDt8;
use App\Models\NotulenDt9;
use App\Models\Org;
use App\Models\Persona;
use App\Models\RencanaPerbaikan;
use App\Models\SmartC;
use App\Models\Standarisasi;
use App\Models\StoryAfter;
use App\Models\StoryAfterDt7;
use App\Models\StoryBefore;
use App\Models\StoryBeforeDt7;
use App\Models\Tema;
use App\Models\UjiPenyebab;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentDtController extends Controller
{
    public function doc1(Request $request) {
        $circles = Circle::all();

        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }
        
        
        $npkLeader = CircleDt::where('id', $circleId)->value('npk_leader');
        $leaderName = CircleDt::where('id', $circleId)->value('leader');
        $circleName = CircleDt::where('id', $circleId)->value('name');
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

        $notulenId = NotulenDt1::where('circle_id', $circleId)->value('id');
        // Cari judul dari tabel notulen1 berdasarkan id Circle yang didapatkan
        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = Comment::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt1::where('circle_id', $circleId)->value('id');
        $background = NotulenDt1::where('circle_id', $circleId)->value('background');
        $demografi = NotulenDt1::where('circle_id', $circleId)->value('demo_customer');
        // pemilihan persona
        $namaPersona = Persona::where('circle_id', $circleId)->value('nama');
        $usiaPersona = Persona::where('circle_id', $circleId)->value('usia');
        $asalPersona = Persona::where('circle_id', $circleId)->value('asal');
        $motivasiPersona = Persona::where('circle_id', $circleId)->value('motivasi');
        $apaPersona = Persona::where('circle_id', $circleId)->value('apa');
        $comment = CommentDt::where('circle_id', $circleId)->value('comment');
        
        

        return view('dt.absensi.doc.langkah1', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'asalPersona', 'motivasiPersona', 'background', 'usiaPersona', 'namaPersona', 'demografi', 'apaPersona'));
    }
 
    public function doc2() {
        $circles = CircleDt::all();

        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');

        $org = Org::where('npk', $npkLeader)->first();

        // Cari grup tema_leader
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
        
        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = CommentDt2::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt2::where('circle_id', $circleId)->value('id');
        $see = NotulenDt2::where('circle_id', $circleId)->value('see');
        $hear = NotulenDt2::where('circle_id', $circleId)->value('hear');
        $think = NotulenDt2::where('circle_id', $circleId)->value('think');
        $pain = NotulenDt2::where('circle_id', $circleId)->value('pain');
        $gain = NotulenDt2::where('circle_id', $circleId)->value('gain');
        $do = NotulenDt2::where('circle_id', $circleId)->value('do');
        


        return view('dt.absensi.doc.langkah2', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'see', 'hear', 'do', 'think', 'pain', 'gain'));
    }

    public function doc3() {
        $circles = CircleDt::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');

        $org = Org::where('npk', $npkLeader)->first();

        // Cari grup tema_leader
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

        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = CommentDt3::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt3::where('circle_id', $circleId)->value('id');
        $notulen3dt = NotulenDt3::where('circle_id', $circleId)->get();
        $stage = NotulenDt3::where('circle_id', $circleId)->value('stage');
        $touchPoint = NotulenDt3::where('circle_id', $circleId)->value('touch_point');
        $doing = NotulenDt3::where('circle_id', $circleId)->value('doing');
        $expect = NotulenDt3::where('circle_id', $circleId)->value('expect');
        $thinking = NotulenDt3::where('circle_id', $circleId)->value('thinking');
        $painPoint = NotulenDt3::where('circle_id', $circleId)->value('pain_point');
        
        return view('dt.absensi.doc.langkah3', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'notulen3dt'));
    }

    public function doc4() {
        $circles = CircleDt::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');

        $org = Org::where('npk', $npkLeader)->first();

        // Cari grup tema_leader
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

        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = CommentDt4::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt4::where('circle_id', $circleId)->value('id');
        $pengguna = NotulenDt4::where('circle_id', $circleId)->value('pengguna');
        $kebutuhan = NotulenDt4::where('circle_id', $circleId)->value('kebutuhan');
        $insight = NotulenDt4::where('circle_id', $circleId)->value('insight');
        $problem = NotulenDt4::where('circle_id', $circleId)->value('problem');
     


        return view('dt.absensi.doc.langkah4', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'pengguna', 'kebutuhan', 'insight', 'problem'));
    }
    public function doc5() {
        $circles = CircleDt::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = CircleDt::where('id', $circleId)->value('npk_leader');
        $leaderName = CircleDt::where('id', $circleId)->value('leader');
        $circleName = CircleDt::where('id', $circleId)->value('name');

        $org = Org::where('npk', $npkLeader)->first();

        // Cari grup tema_leader
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

        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = CommentDt5::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt5::where('circle_id', $circleId)->value('id');
        $brainstorms = Brainstorming::where('circle_id', $circleId)->get();
        $rank_1 = NotulenDt5::where('circle_id', $circleId)->value('rank_1');
        $rank_2 = NotulenDt5::where('circle_id', $circleId)->value('rank_2');
        $rank_3 = NotulenDt5::where('circle_id', $circleId)->value('rank_3');
        $ideTerpilih = NotulenDt5::where('circle_id', $circleId)->value('ide_terpilih');
        $feasebility = NotulenDt5::where('circle_id', $circleId)->value('feasebility');
        $viability = NotulenDt5::where('circle_id', $circleId)->value('viability');
        $desirability = NotulenDt5::where('circle_id', $circleId)->value('desirability');


        return view('dt.absensi.doc.langkah5', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'brainstorms', 'rank_1', 'rank_2', 'rank_3', 'feasebility', 'viability', 'desirability', 'ideTerpilih'));
    }
    public function doc6() {
        $circles = Circle::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');

        $org = Org::where('npk', $npkLeader)->first();

        // Cari grup tema_leader
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

        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = CommentDt6::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt6::where('circle_id', $circleId)->value('id');
        $storyBefores = StoryBefore::where('circle_id', $circleId)->get();
        $storyAfters = StoryAfter::where('circle_id', $circleId)->get();
        $foto = NotulenDt6::where('circle_id', $circleId)->value('foto');


        return view('dt.absensi.doc.langkah6', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'storyBefores', 'storyAfters', 'foto'));
    }
    public function doc7() {
        $circles = CircleDt::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $npkLeader = CircleDt::where('id', $circleId)->value('npk_leader');
        $leaderName = CircleDt::where('id', $circleId)->value('leader');
        $circleName = CircleDt::where('id', $circleId)->value('name');

        $org = Org::where('npk', $npkLeader)->first();

        // Cari grup tema_leader
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
        

        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = CommentDt7::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt7::where('circle_id', $circleId)->value('id');
        $notulendt7 = NotulenDt7::where('circle_id', $circleId)->get();
        $nama_improve = NotulenDt7::where('circle_id', $circleId)->value('nama_improve');
        $tanggal_uji = NotulenDt7::where('circle_id', $circleId)->value('tanggal_uji');
        $nama_persona = NotulenDt7::where('circle_id', $circleId)->value('nama_persona');
        $suka = NotulenDt7::where('circle_id', $circleId)->value('suka');
        $tidak_mengerti = NotulenDt7::where('circle_id', $circleId)->value('tidak_mengerti');
        $pertimbangkan = NotulenDt7::where('circle_id', $circleId)->value('pertimbangkan');
        $tingkatkan = NotulenDt7::where('circle_id', $circleId)->value('tingkatkan');
        $hypotesis = NotulenDt7::where('circle_id', $circleId)->value('hypotesis');
        $observation = NotulenDt7::where('circle_id', $circleId)->value('observation');
        $learning = NotulenDt7::where('circle_id', $circleId)->value('learning');
        $decision = NotulenDt7::where('circle_id', $circleId)->value('decision');
        $iterasi = NotulenDt7::where('circle_id', $circleId)->value('iterasi');
        $storyBefores = StoryBeforeDt7::where('circle_id', $circleId)->get();
        $storyAfters = StoryAfterDt7::where('circle_id', $circleId)->get();
        $foto = Iterasi::where('circle_id', $circleId)->value('foto');


        return view('dt.absensi.doc.langkah7', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'suka', 'tingkatkan', 'pertimbangkan', 'tidak_mengerti', 'observation', 'decision', 'hypotesis', 'learning', 'iterasi', 'storyBefores', 'storyAfters', 'foto', 'nama_improve', 'nama_persona', 'tanggal_uji'));
    }
    public function doc8(Request $request) {
        $circles = CircleDt::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }
        
        
        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
        $leaderName = Circle::where('id', $circleId)->value('leader');
        $circleName = Circle::where('id', $circleId)->value('name');
        $backgrounds = BackgroundL8::where('circle_id', $circleId)->get();

        $org = Org::where('npk', $npkLeader)->first();

        // Cari grup tema_leader
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
        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = CommentDt8::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt8::where('circle_id', $circleId)->value('id');
        $csi = NotulenDt8::where('circle_id', $circleId)->value('csi');
        $cei = NotulenDt8::where('circle_id', $circleId)->value('cei');
        $nps = NotulenDt8::where('circle_id', $circleId)->value('nps');
        $cost = NotulenDt8::where('circle_id', $circleId)->value('cost');
        $delivery = NotulenDt8::where('circle_id', $circleId)->value('delivery');
        $moral = NotulenDt8::where('circle_id', $circleId)->value('moral');
        $safety = NotulenDt8::where('circle_id', $circleId)->value('safety');
        $quality = NotulenDt8::where('circle_id', $circleId)->value('quality');
        $environment = NotulenDt8::where('circle_id', $circleId)->value('environment');
        

        return view('dt.absensi.doc.langkah8', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'csi' ,'cei', 'nps', 'safety', 'quality', 'cost', 'delivery', 'moral', 'environment'));
    }
    
    public function doc9() {
        $circles = CircleDt::all();
        
        
        // Temukan data circle berdasarkan circle_id
        $circleId = request()->query('id');
        
        // Temukan data circle berdasarkan circle_id
        $circle = CircleDt::where('id', $circleId)->first();
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }
        
                    $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
                $npkLeader = Circle::where('id', $circleId)->value('npk_leader');
                $leaderName = Circle::where('id', $circleId)->value('leader');
                $circleName = Circle::where('id', $circleId)->value('name');

        $org = Org::where('npk', $npkLeader)->first();

        // Cari grup tema_leader
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

        $judulNotulen = NotulenDt1::where('circle_id', $circleId)->value('judul');
        $comment = CommentDt9::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenDt9::where('circle_id', $circleId)->value('id');
        $problem = NotulenDt9::where('circle_id', $circleId)->value('problem');
        $hasil = NotulenDt9::where('circle_id', $circleId)->value('hasil');
        $solusi = NotulenDt9::where('circle_id', $circleId)->value('solusi');
        $manfaat = NotulenDt9::where('circle_id', $circleId)->value('manfaat');
        $benefit = NotulenDt9::where('circle_id', $circleId)->value('benefit');
        $fileNqi = NotulenDt9::where('circle_id', $circleId)->value('file');


        return view('dt.absensi.doc.langkah9', compact('circleId','notulenId','comment','deptName','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen','problem','hasil','solusi', 'benefit', 'manfaat', 'fileNqi'));
    }

}
