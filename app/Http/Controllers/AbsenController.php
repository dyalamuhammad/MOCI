<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\Departemen;
use App\Models\Group;
use App\Models\Langkah;
use App\Models\Notulen1;
use App\Models\Org;
use App\Models\Periode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    
    public function form() {
        $circles = Circle::all();
        $user = Auth::user();
    
        $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }
            
            $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
            $circleName = Circle::where('npk_leader', $user->npk)->value('name');
            $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');


            // Cari grup tema_leader
            $org = Org::where('npk', $user->npk)->first();
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
            } else {
                // Jika data tema_leader tidak ditemukan di tabel Org
                echo "Data tema_leader tidak ditemukan.";
            }
            $activePeriodeId = Periode::where('status', 1)->value('id');
            $langkah = Langkah::where('name', 'L1')->where('periode_id', $activePeriodeId)->first(); // Mengambil langkah dengan nama L0
            
       
            $today = Carbon::now()->toDateString(); // Tanggal hari ini
            $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
            $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0

            if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = null; // Tidak ada error
            }
        

        $nama_cord = $user_cord->name;
        return view('qcc.absensi.form.form-1', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'error', 'circleId', 'periodeId', 'deptName'));
    }
    public function form2() {
        $circles = Circle::all();
        $user = Auth::user();
    
        $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

            $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
            $circleName = Circle::where('npk_leader', $user->npk)->value('name');
            $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');

            // Cari grup tema_leader
            $org = Org::where('npk', $user->npk)->first();
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
            } else {
                // Jika data tema_leader tidak ditemukan di tabel Org
                echo "Data tema_leader tidak ditemukan.";
            }
            $activePeriodeId = Periode::where('status', 1)->value('id');
            $langkah = Langkah::where('name', 'L2')->where('periode_id', $activePeriodeId)->first(); // Mengambil langkah dengan nama L1

            $today = Carbon::now()->toDateString(); // Tanggal hari ini
            $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
            $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0

            if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = null; // Tidak ada error
            }
                
        $nama_cord = $user_cord->name;
        $judul = Notulen1::where('circle_id', $circleId)->value('judul');
        return view('qcc.absensi.form.form-2', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'circleId', 'judul', 'periodeId', 'deptName'));
    }
    public function form3() {
        $circles = Circle::all();
        $user = Auth::user();
    
        $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');

        // Cari grup tema_leader
        $org = Org::where('npk', $user->npk)->first();
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
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }


        $activePeriodeId = Periode::where('status', 1)->value('id');        
        $langkah = Langkah::where('name', 'L3')->where('periode_id', $activePeriodeId)->first(); // Mengambil langkah dengan nama L2

        $today = Carbon::now()->toDateString(); // Tanggal hari ini
        $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
        $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0
        if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = ''; // Tidak ada error
            }
            
        // Jika nama koordinator ditemukan, tampilkan
        $nama_cord = $user_cord->name;
        $judul = Notulen1::where('circle_id', $circleId)->value('judul');
        return view('qcc.absensi.form.form-3', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'circleId', 'error', 'judul', 'periodeId', 'deptName'));
    }
    public function form4() {
        $circles = Circle::all();
        $user = Auth::user();
    
         $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');

        // Cari grup tema_leader
        $org = Org::where('npk', $user->npk)->first();
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
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }


        $activePeriodeId = Periode::where('status', 1)->value('id');        
        $langkah = Langkah::where('name', 'L4')->where('periode_id', $activePeriodeId)->first(); // Mengambil langkah dengan nama L2

        $today = Carbon::now()->toDateString(); // Tanggal hari ini
        $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
        $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0
        if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = ''; // Tidak ada error
            }
            
        // Jika nama koordinator ditemukan, tampilkan
        $nama_cord = $user_cord->name;
        $judul = Notulen1::where('circle_id', $circleId)->value('judul');
        return view('qcc.absensi.form.form-4', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'circleId', 'error', 'judul', 'periodeId', 'deptName'));
    }
    public function form5() {
        $circles = Circle::all();
        $user = Auth::user();
    
         $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');

        // Cari grup tema_leader
        $org = Org::where('npk', $user->npk)->first();
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
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }


        $activePeriodeId = Periode::where('status', 1)->value('id');        
        $langkah = Langkah::where('name', 'L5')->where('periode_id', $activePeriodeId)->first(); // Mengambil langkah dengan nama L2

        $today = Carbon::now()->toDateString(); // Tanggal hari ini
        $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
        $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0
        if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = ''; // Tidak ada error
            }
            
        // Jika nama koordinator ditemukan, tampilkan
        $nama_cord = $user_cord->name;
        $judul = Notulen1::where('circle_id', $circleId)->value('judul');
        return view('qcc.absensi.form.form-5', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'circleId', 'error', 'judul', 'periodeId', 'deptName'));
    }
    public function form6() {
        $circles = Circle::all();
        $user = Auth::user();
    
         $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');

        // Cari grup tema_leader
        $org = Org::where('npk', $user->npk)->first();

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
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }


        $activePeriodeId = Periode::where('status', 1)->value('id');        
        $langkah = Langkah::where('name', 'L6')->where('periode_id', $activePeriodeId)->first(); // Mengambil langkah dengan nama L2

        $today = Carbon::now()->toDateString(); // Tanggal hari ini
        $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
        $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0
        if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = ''; // Tidak ada error
            }
            
        // Jika nama koordinator ditemukan, tampilkan
        $nama_cord = $user_cord->name;
        $judul = Notulen1::where('circle_id', $circleId)->value('judul');
        return view('qcc.absensi.form.form-6', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'circleId', 'error', 'judul', 'periodeId', 'deptName'));
    }
    public function form7() {
        $circles = Circle::all();
        $user = Auth::user();
    
         $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');

        // Cari grup tema_leader
        $org = Org::where('npk', $user->npk)->first();

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
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }


        $activePeriodeId = Periode::where('status', 1)->value('id');        
        $langkah = Langkah::where('name', 'L7')->where('periode_id', $activePeriodeId)->first(); // Mengambil langkah dengan nama L2

        $today = Carbon::now()->toDateString(); // Tanggal hari ini
        $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
        $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0
        if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = ''; // Tidak ada error
            }
            
        // Jika nama koordinator ditemukan, tampilkan
        $nama_cord = $user_cord->name;
        $judul = Notulen1::where('circle_id', $circleId)->value('judul');
        return view('qcc.absensi.form.form-7', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'circleId', 'error', 'judul', 'periodeId', 'deptName'));
    }
    public function form8() {
        $circles = Circle::all();
        $user = Auth::user();
    
         $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');

        // Cari grup tema_leader
        $org = Org::where('npk', $user->npk)->first();

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
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }


        $activePeriodeId = Periode::where('status', 1)->value('id');        
        $langkah = Langkah::where('name', 'L8')->where('periode_id', $activePeriodeId)->first(); // Mengambil langkah dengan nama L2

        $today = Carbon::now()->toDateString(); // Tanggal hari ini
        $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
        $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0
        if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = ''; // Tidak ada error
            }
            
        // Jika nama koordinator ditemukan, tampilkan
        $nama_cord = $user_cord->name;
        $judul = Notulen1::where('circle_id', $circleId)->value('judul');
        return view('qcc.absensi.form.form-8', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'circleId', 'error', 'judul', 'periodeId', 'deptName'));
    }
    public function form9() {
        $circles = Circle::all();
        $user = Auth::user();
    
         $circleId = Circle::where('npk_leader', $user->npk)
        ->join('periodes', 'circles.periode', '=', 'periodes.periode')
        ->where('periodes.status', 1)
        ->value('circles.id');

            $circle = Circle::find($circleId);
        if ($circle) {
            $members = $circle->members;
        } else {
            $members = [];
        }

        $periodeId = Circle::where('npk_leader', $user->npk)->value('periode');
        $circleName = Circle::where('npk_leader', $user->npk)->value('name');
        $leaderName = Circle::where('npk_leader', $user->npk)->value('leader');

        // Cari grup tema_leader
        $org = Org::where('npk', $user->npk)->first();

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
        } else {
            // Jika data tema_leader tidak ditemukan di tabel Org
            echo "Data tema_leader tidak ditemukan.";
        }


        $activePeriodeId = Periode::where('status', 1)->value('id');        
        $langkah = Langkah::where('name', 'L9')->first(); // Mengambil langkah dengan nama L2

        $today = Carbon::now()->toDateString(); // Tanggal hari ini
        $endDate = $langkah->sampai; // Tanggal sampai pada langkah L0
        $startDate = $langkah->mulai; // Tanggal sampai pada langkah L0
        if ($today > $endDate) {
                $error = 'Masa pengisian langkah telah berakhir.';
            } 
            elseif ($today < $startDate) {
                $error = 'Masa pengisian langkah belum dimulai.';
            } else {
                $error = ''; // Tidak ada error
            }
            
        // Jika nama koordinator ditemukan, tampilkan
        $nama_cord = $user_cord->name;
        $judul = Notulen1::where('circle_id', $circleId)->value('judul');
        return view('qcc.absensi.form.form-9', compact('circles', 'circleName', 'leaderName', 'members', 'nama_cord', 'circleId', 'error', 'judul', 'periodeId', 'deptName'));
    }
   
}
