<?php

namespace App\Http\Controllers;

use App\Models\Analisa4m1e;
use App\Models\AspekMutu;
use App\Models\Background;
use App\Models\BackgroundL8;
use App\Models\Brainstorming;
use App\Models\BrainstormingCbi;
use App\Models\Circle;
use App\Models\CircleDt;
use App\Models\Comment;
use App\Models\CommentCbi;
use App\Models\CommentCbi2;
use App\Models\CommentCbi3;
use App\Models\CommentCbi4;
use App\Models\CommentCbi5;
use App\Models\CommentCbi6;
use App\Models\CommentCbi7;
use App\Models\CommentCbi8;
use App\Models\CommentCbi9;
use App\Models\DampakPositif;
use App\Models\Departemen;
use App\Models\Group;
use App\Models\ImplemenPerbaikan;
use App\Models\Iterasi;
use App\Models\IterasiCbi;
use App\Models\ManfaatPanca;
use App\Models\Notulen1;
use App\Models\Notulen4;
use App\Models\Notulen5;
use App\Models\Notulen8;
use App\Models\Notulen9;
use App\Models\NotulenCbi1;
use App\Models\NotulenCbi2;
use App\Models\NotulenCbi3;
use App\Models\NotulenCbi4;
use App\Models\NotulenCbi5;
use App\Models\NotulenCbi6;
use App\Models\NotulenCbi7;
use App\Models\NotulenCbi8;
use App\Models\NotulenCbi9;
use App\Models\Org;
use App\Models\Persona;
use App\Models\PersonaCbi;
use App\Models\RencanaPerbaikan;
use App\Models\SmartC;
use App\Models\Standarisasi;
use App\Models\StoryAfter;
use App\Models\StoryAfterCbi;
use App\Models\StoryAfterCbi7;
use App\Models\StoryAfterDt7;
use App\Models\StoryBefore;
use App\Models\StoryBeforeCbi;
use App\Models\StoryBeforeCbi7;
use App\Models\StoryBeforeDt7;
use App\Models\Tema;
use App\Models\UjiPenyebab;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentCbiController extends Controller
{
    public function doc1(Request $request) {
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

        $notulenId = NotulenCbi1::where('circle_id', $circleId)->value('id');
        // Cari judul dari tabel notulen1 berdasarkan id Circle yang didapatkan
        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi1::where('circle_id', $circleId)->value('id');
        $background = NotulenCbi1::where('circle_id', $circleId)->value('background');
        $demografi = NotulenCbi1::where('circle_id', $circleId)->value('demo_customer');
        // pemilihan persona
        $namaPersona = PersonaCbi::where('circle_id', $circleId)->value('nama');
        $usiaPersona = PersonaCbi::where('circle_id', $circleId)->value('usia');
        $asalPersona = PersonaCbi::where('circle_id', $circleId)->value('asal');
        $motivasiPersona = PersonaCbi::where('circle_id', $circleId)->value('motivasi');
        $apaPersona = PersonaCbi::where('circle_id', $circleId)->value('apa');
        $comment = CommentCbi::where('circle_id', $circleId)->value('comment');
        
        

        return view('cbi.absensi.doc.langkah1', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'asalPersona', 'motivasiPersona', 'background', 'usiaPersona', 'namaPersona', 'demografi', 'apaPersona'));
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
        
        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi2::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi2::where('circle_id', $circleId)->value('id');
        $see = NotulenCbi2::where('circle_id', $circleId)->value('see');
        $hear = NotulenCbi2::where('circle_id', $circleId)->value('hear');
        $think = NotulenCbi2::where('circle_id', $circleId)->value('think');
        $pain = NotulenCbi2::where('circle_id', $circleId)->value('pain');
        $gain = NotulenCbi2::where('circle_id', $circleId)->value('gain');
        $do = NotulenCbi2::where('circle_id', $circleId)->value('do');
        


        return view('cbi.absensi.doc.langkah2', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'see', 'hear', 'do', 'think', 'pain', 'gain'));
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

        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi3::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi3::where('circle_id', $circleId)->value('id');
        $notulen3cbi = NotulenCbi3::where('circle_id', $circleId)->get();
        $stage = NotulenCbi3::where('circle_id', $circleId)->value('stage');
        $touchPoint = NotulenCbi3::where('circle_id', $circleId)->value('touch_point');
        $doing = NotulenCbi3::where('circle_id', $circleId)->value('doing');
        $expect = NotulenCbi3::where('circle_id', $circleId)->value('expect');
        $thinking = NotulenCbi3::where('circle_id', $circleId)->value('thinking');
        $painPoint = NotulenCbi3::where('circle_id', $circleId)->value('pain_point');
        
        return view('cbi.absensi.doc.langkah3', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'stage', 'touchPoint', 'doing', 'expect', 'thinking', 'painPoint', 'notulen3cbi'));
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

        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi4::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi4::where('circle_id', $circleId)->value('id');
        $pengguna = NotulenCbi4::where('circle_id', $circleId)->value('pengguna');
        $kebutuhan = NotulenCbi4::where('circle_id', $circleId)->value('kebutuhan');
        $insight = NotulenCbi4::where('circle_id', $circleId)->value('insight');
        $problem = NotulenCbi4::where('circle_id', $circleId)->value('problem');
     


        return view('cbi.absensi.doc.langkah4', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'pengguna', 'kebutuhan', 'insight', 'problem'));
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

        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi5::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi5::where('circle_id', $circleId)->value('id');
        $brainstorms = BrainstormingCbi::where('circle_id', $circleId)->get();
        $rank_1 = NotulenCbi5::where('circle_id', $circleId)->value('rank_1');
        $rank_2 = NotulenCbi5::where('circle_id', $circleId)->value('rank_2');
        $rank_3 = NotulenCbi5::where('circle_id', $circleId)->value('rank_3');
        $ideTerpilih = NotulenCbi5::where('circle_id', $circleId)->value('ide_terpilih');
        $feasebility = NotulenCbi5::where('circle_id', $circleId)->value('feasebility');
        $viability = NotulenCbi5::where('circle_id', $circleId)->value('viability');
        $desirability = NotulenCbi5::where('circle_id', $circleId)->value('desirability');


        return view('cbi.absensi.doc.langkah5', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'brainstorms', 'rank_1', 'rank_2', 'rank_3', 'feasebility', 'viability', 'desirability', 'ideTerpilih'));
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

        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi6::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi6::where('circle_id', $circleId)->value('id');
        $storyBefores = StoryBeforeCbi::where('circle_id', $circleId)->get();
        $storyAfters = StoryAfterCbi::where('circle_id', $circleId)->get();
        $foto = NotulenCbi6::where('circle_id', $circleId)->value('foto');


        return view('cbi.absensi.doc.langkah6', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'storyBefores', 'storyAfters', 'foto'));
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
        

        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi7::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi7::where('circle_id', $circleId)->value('id');
        $nama_improve = NotulenCbi7::where('circle_id', $circleId)->value('nama_improve');
        $nama_persona = NotulenCbi7::where('circle_id', $circleId)->value('nama_persona');
        $tanggal_uji = NotulenCbi7::where('circle_id', $circleId)->value('tanggal_uji');
        $suka = NotulenCbi7::where('circle_id', $circleId)->value('suka');
        $tidak_mengerti = NotulenCbi7::where('circle_id', $circleId)->value('tidak_mengerti');
        $pertimbangkan = NotulenCbi7::where('circle_id', $circleId)->value('pertimbangkan');
        $tingkatkan = NotulenCbi7::where('circle_id', $circleId)->value('tingkatkan');
        $hypotesis = NotulenCbi7::where('circle_id', $circleId)->value('hypotesis');
        $observation = NotulenCbi7::where('circle_id', $circleId)->value('observation');
        $learning = NotulenCbi7::where('circle_id', $circleId)->value('learning');
        $decision = NotulenCbi7::where('circle_id', $circleId)->value('decision');
        $iterasi = NotulenCbi7::where('circle_id', $circleId)->value('iterasi');
        $storyBefores = StoryBeforeCbi7::where('circle_id', $circleId)->get();
        $storyAfters = StoryAfterCbi7::where('circle_id', $circleId)->get();
        $foto = IterasiCbi::where('circle_id', $circleId)->value('foto');


        return view('cbi.absensi.doc.langkah7', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'suka', 'tingkatkan', 'pertimbangkan', 'tidak_mengerti', 'observation', 'decision', 'hypotesis', 'learning', 'iterasi', 'storyBefores', 'storyAfters', 'foto', 'nama_persona','tanggal_uji', 'nama_improve'));
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
        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi8::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi8::where('circle_id', $circleId)->value('id');
        $csi = NotulenCbi8::where('circle_id', $circleId)->value('csi');
        $cei = NotulenCbi8::where('circle_id', $circleId)->value('cei');
        $nps = NotulenCbi8::where('circle_id', $circleId)->value('nps');
        $cost = NotulenCbi8::where('circle_id', $circleId)->value('cost');
        $delivery = NotulenCbi8::where('circle_id', $circleId)->value('delivery');
        $moral = NotulenCbi8::where('circle_id', $circleId)->value('moral');
        $safety = NotulenCbi8::where('circle_id', $circleId)->value('safety');
        $quality = NotulenCbi8::where('circle_id', $circleId)->value('quality');
        $environment = NotulenCbi8::where('circle_id', $circleId)->value('environment');
        

        return view('cbi.absensi.doc.langkah8', compact('deptName','comment','circleId','notulenId','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen', 'csi' ,'cei', 'nps', 'safety', 'quality', 'cost', 'delivery', 'moral', 'environment'));
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

        $judulNotulen = NotulenCbi1::where('circle_id', $circleId)->value('judul');
        $comment = CommentCbi9::where('circle_id', $circleId)->value('comment');
        $notulenId = NotulenCbi9::where('circle_id', $circleId)->value('id');
        $problem = NotulenCbi9::where('circle_id', $circleId)->value('problem');
        $hasil = NotulenCbi9::where('circle_id', $circleId)->value('hasil');
        $solusi = NotulenCbi9::where('circle_id', $circleId)->value('solusi');
        $manfaat = NotulenCbi9::where('circle_id', $circleId)->value('manfaat');
        $benefit = NotulenCbi9::where('circle_id', $circleId)->value('benefit');
        $fileNqi = NotulenCbi9::where('circle_id', $circleId)->value('file');


        return view('cbi.absensi.doc.langkah9', compact('circleId','notulenId','comment','deptName','circle','members', 'leaderName', 'npkLeader', 'circleName', 'nama_cord', 'judulNotulen','problem','hasil','solusi', 'benefit', 'manfaat', 'fileNqi'));
    }

}
