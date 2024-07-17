<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\DeptImport;
use App\Imports\GroupImport;
use App\Imports\SectionImport;
use App\Imports\UsersImport;
use App\Models\Departemen;
use App\Models\Group;
use App\Models\Langkah;
use App\Models\Member;
use App\Models\Org;
use App\Models\Periode;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class AdminController extends Controller
{
    public function index(Request $request) {
        $users = User::query(); // Memulai kueri dengan menggunakan query builder
        $group = Group::all();
        $section = Section::all();
        $department = Departemen::all();

        $search = $request->query('search', '');
        $filter = $request->query('filter', '');
        
        $query = User::query()
                ->select('users.*');

        // Filter berdasarkan periode
            if ($filter) {
                $query->where('users.jabatan', $filter);
            } 

        // Pencarian berdasarkan nama atau NPK
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.npk', 'like', "%{$search}%")
                ->orWhere('users.name', 'like', "%{$search}%")
                  ->orWhere(function ($q) use ($search) {
                      $q->whereHas('department', function ($q) use ($search) {
                          $q->where('dept', 'like', "%{$search}%");
                      })
                      ->orWhereHas('section', function ($q) use ($search) {
                          $q->where('section', 'like', "%{$search}%");
                      })
                      ->orWhereHas('group', function ($q) use ($search) {
                          $q->where('nama_group', 'like', "%{$search}%");
                      });
                  });
            });
        }

        $users = $query->paginate(50);  
        $data = [
            'users' => $users,
            'filter' => $filter,
            'search' => $search
        ];
        
        return view("admin.karyawan", $data, compact('group', 'department', 'section'));
    }
    public function controlStep() {
        $periode = Periode::all(); // Mengambil semua data dari tabel periode

        return view("admin.control-step", compact('periode'));
    }
    public function controlPeriod() {
        $periode = Periode::all(); // Mengambil semua data dari tabel periode
    
        // Kirim data ke tampilan
        return view("admin.control-period", ['periode' => $periode]);
    }

    // --------------------- //
    // CONTROL MEMBER START //
    // --------------------- //
    public function controlMember(Request $request) {
        $activePeriode = Periode::where('status', 1)->first();
        $search = $request->query('search', '');
        $filter = $request->query('filter', '');
        $periodes = Periode::all(); // Mengambil semua data dari tabel periode
        $circles = \App\Models\Circle::where('periode', $activePeriode->periode)->get();

        $query = User::query();
        if($filter) {
            if ($filter === 'circle') {
                // Filter pengguna yang memiliki circle di periode yang aktif
                $query->where(function($q) use ($activePeriode) {
                    $q->whereHas('member.circle', function ($query) use ($activePeriode) {
                        $query->where('periode', $activePeriode->periode);
                    })->orWhereHas('leaderCircles', function ($query) use ($activePeriode) {
                        $query->where('periode', $activePeriode->periode);
                    });
                });
            } elseif ($filter === 'no_circle') {
                // Filter pengguna yang tidak memiliki circle di periode yang aktif
                $query->whereDoesntHave('member.circle', function ($query) use ($activePeriode) {
                    $query->where('periode', $activePeriode->periode);
                })->whereDoesntHave('leaderCircles', function ($query) use ($activePeriode) {
                    $query->where('periode', $activePeriode->periode);
                });
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('npk', 'like', "%{$search}%")
                    ->orWhereHas('circle', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            });
        }

        $user = $query->paginate(20);
    
        // Kirim data ke tampilan
        return view("admin.control-member", compact('search', 'filter', 'activePeriode', 'periodes', 'user', 'circles'));
    }

    public function pindahCircle(Request $request) {
        try {
            $request->validate([
                'npk' => 'required',
                'circle_id' => 'required|exists:circles,id',
            ]);
    
            // Cari periode yang sedang aktif
            $activePeriode = Periode::where('status', 1)->first();

            // Cari member berdasarkan npk_anggota dan periode aktif
            $member = Member::where('npk_anggota', $request->npk)
                ->whereHas('circle', function ($query) use ($activePeriode) {
                    $query->where('periode', $activePeriode->periode);
                })
                ->first();
    
            if ($member) {
                $member->circle_id = $request->circle_id;
                $member->save();
            }
    
            return redirect()->back()->with('success', 'Circle berhasil diubah');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal ubah circle. Error: ' . $e->getMessage());
        }
    }

    // --------------------- //
    // CONTROL MEMBER END //
    // --------------------- //

    // --------------------- //
    // CONTROL ORG START //
    // --------------------- //
    
    // ------GROUP START-----------
    public function group(Request $request) {
        // $group = Group::all(); // Mengambil semua data dari tabel group
        $search = $request->query('search', '');
        
        $query = Group::query();

        // Pencarian berdasarkan nama atau NPK
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id_group', 'like', "%{$search}%")
                ->orWhere('nama_group', 'like', "%{$search}%")
                ->orWhere('npk_cord', 'like', "%{$search}%")
                ->orWhere(function ($q) use ($search) {
                      $q->whereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                      });
               
            });
        }

        $group = $query->paginate(150); 
        return view("admin.group", compact('group', 'search'));
    }
    public function formGroup() {
        $group = Group::all();
        $section = Section::all();
        $department = Departemen::all();
        return view('admin.form.group.add', compact('section'));
    }
    public function addGroup(Request $request) {
        try {
            $this->storeorupdateGroup($request);
    
            return redirect()->route('group')
                ->with('success', 'Berhasil menambahkan group');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan group. Error: ' . $e->getMessage());
        }
    }
    public function storeorupdateGroup(Request $request, $id = null) {
        $obj = $id === null ? new Group() : Group::find($id);
        $obj->id_group = $request->id_group;
        $obj->nama_group = $request->nama_group;
        $obj->npk_cord = $request->npk_cord;
        $obj->id_section = $request->id_section;
        $obj->part = 'group';
    
        $obj->save();
    }
    public function softDeleteGroup($id) {
        $group = Group::find($id); // Menggunakan find() karena primaryKey telah ditentukan
        if ($group) {
            $group_name = $group->nama_group;
            $group->delete();
            return redirect()->back()->with('success', 'Berhasil hapus group: ' . $group_name);
        } else {
            return redirect()->back()->with('error', 'Group tidak ditemukan.');
        }
    }
    public function editGroup($id) {
        $group = Group::find($id);
        $section = Section::all();
        $sectionName = Section::where('id_section', $group->id_section)->value('section');

        $data = [
            'forms' => $group
        ];

        return view('admin.form.group.edit', $data ,compact('group', 'sectionName', 'section'));
    }
    public function updateGroup(Request $request, $id) {
        try {
            $this->storeorupdateGroup($request, $id);
            
            return redirect()->route('group')
            ->with('success', 'Berhasil edit group');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal ubah group. Error: ' . $e->getMessage());
        }
    }
    public function importGroup(Request $request) {
        try {

            $file = $request->file('file')->store('public/import');
        
            $import = new GroupImport;
            $import->import($file);
        
            return redirect()->back()->with('success', 'Berhasil import data group');
        }
        catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menambah group. Error: ' . $e->getMessage());
        }
    }
    // ------GROUP ENDS-----------
    
    // ------SECTION START-----------
    public function section(Request $request) {
        $search = $request->query('search', '');
        
        $query = Section::query();

        // Pencarian berdasarkan nama atau NPK
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id_section', 'like', "%{$search}%")
                ->orWhere('section', 'like', "%{$search}%")
                ->orWhere('npk_cord', 'like', "%{$search}%");
               
            });
        }

        $section = $query->paginate(150); 
        return view("admin.section", compact('section', 'search'));
    } 
    public function formSection() {
        $group = Group::all();
        $section = Section::all();
        $department = Departemen::all();
        return view('admin.form.section.add', compact('section', 'department'));
    }
    public function addSection(Request $request) {
        try {
            $this->storeorupdateSection($request);
    
            return redirect()->route('section')
                ->with('success', 'Berhasil menambahkan section');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan section. Error: ' . $e->getMessage());
        }
    }
    public function storeorupdateSection(Request $request, $id = null) {
        $obj = $id === null ? new Section() : Section::find($id);
        $obj->id_section = $request->id_section;
        $obj->section = $request->section;
        $obj->npk_cord = $request->npk_cord;
        $obj->id_dept = $request->id_dept;
        $obj->part = 'section';
    
        $obj->save();
    }
    public function softDeleteSection($id) {
        $section = Section::find($id); // Menggunakan find() karena primaryKey telah ditentukan
        if ($section) {
            $section_name = $section->section;
            $section->delete();
            return redirect()->back()->with('success', 'Berhasil hapus section: ' . $section_name);
        } else {
            return redirect()->back()->with('error', 'Section tidak ditemukan.');
        }
    }
    public function editSection($id) {
        $section = Section::find($id);
        $department = Departemen::all();
        $deptName = Departemen::where('id_dept', $section->id_dept)->value('dept');

        $data = [
            'forms' => $section
        ];

        return view('admin.form.section.edit', $data ,compact('section', 'deptName', 'department'));
    }
    public function updateSection(Request $request, $id) {
        try {
            $this->storeorupdateSection($request, $id);
            
            return redirect()->route('section')
            ->with('success', 'Berhasil edit section');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal ubah section. Error: ' . $e->getMessage());
        }
    }  
    public function importSection(Request $request) {
        try {

            $file = $request->file('file')->store('public/import');
        
            $import = new SectionImport;
            $import->import($file);
        
            return redirect()->back()->with('success', 'Berhasil import data section');
        }
        catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menambah section. Error: ' . $e->getMessage());
        }
    } 
    // ------SECTION ENDS-----------

    public function department(Request $request) {
        // $department = Departemen::all(); // Mengambil semua data dari tabel department
        $search = $request->query('search', '');
        
        $query = Departemen::query();

        // Pencarian berdasarkan nama atau NPK
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id_dept', 'like', "%{$search}%")
                ->orWhere('dept', 'like', "%{$search}%")
                ->orWhere('npk_cord', 'like', "%{$search}%");
               
            });
        }

        $department = $query->paginate(150); 
        return view("admin.department", compact('department', 'search'));
    }   
    public function formDepartment() {
        $group = Group::all();
        $section = Section::all();
        $department = Departemen::all();
        return view('admin.form.department.add', compact('section', 'department'));
    }
    public function addDepartment(Request $request) {
        try {
            $this->storeorupdateDepartment($request);
    
            return redirect()->route('department')
                ->with('success', 'Berhasil menambahkan department');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan department. Error: ' . $e->getMessage());
        }
    }
    public function storeorupdateDepartment(Request $request, $id = null) {
        $obj = $id === null ? new Departemen() : Departemen::find($id);
        $obj->id_dept = $request->id_dept;
        $obj->dept = $request->dept;
        $obj->npk_cord = $request->npk_cord;
        $obj->id_div = $request->id_div;
        $obj->part = 'dept';
    
        $obj->save();
    }
    public function softDeleteDepartment($id) {
        $department = Departemen::find($id); // Menggunakan find() karena primaryKey telah ditentukan
        if ($department) {
            $department_name = $department->section;
            $department->delete();
            return redirect()->back()->with('success', 'Berhasil hapus department: ' . $department_name);
        } else {
            return redirect()->back()->with('error', 'Department tidak ditemukan.');
        }
    }
    public function editDepartment($id) {
        $department = Departemen::find($id);
       
        $divName = 'Body Divisi';

        $data = [
            'forms' => $department
        ];

        return view('admin.form.department.edit', $data ,compact('department', 'divName', ));
    }
    public function updateDepartment(Request $request, $id) {
        try {
            $this->storeorupdateDepartment($request, $id);
            
            return redirect()->route('department')
            ->with('success', 'Berhasil edit department');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal ubah department. Error: ' . $e->getMessage());
        }
    } 
    public function importDept(Request $request) {
        try {

            $file = $request->file('file')->store('public/import');
        
            $import = new DeptImport;
            $import->import($file);
        
            return redirect()->back()->with('success', 'Berhasil import data department');
        }
        catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menambah department. Error: ' . $e->getMessage());
        }
    } 
    // --------------------- //
    // CONTROL ORG ENDS //
    // --------------------- //

    // add user start
    public function storeorupdate(Request $request, $id = null) {
        
        $obj = $id === null ? new User() : User::find($id);
        $obj->name = $request->name;
        $obj->npk = $request->npk;
        $obj->jabatan = $request->jabatan;
        $obj->status = $request->status;
        $obj->shift = $request->shift;
        $obj->password = $request->password;
        $obj->tgl_masuk = $request->tgl_masuk;
        
        
        $obj->save();
        
        // Simpan data org
        $org = Org::firstOrNew(['npk' => $request->npk]);
        $org->grp = $request->grp;
        $org->sect = $request->sect;
        $org->dept = $request->dept;
        $org->division = '1-001';
        $org->save();

    }
    public function doValidate($request, $id=null) {
        $model = [
            'name' => 'required',
            'npk' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'jabatan' => 'required',
            'tgl_masuk' => 'required',
            'npk' => 'required|string|max:255|unique:users,npk,' . $id,
        ];
           
        $request->validate($model);
    }
    public function add(Request $request) {
        try {
            $this->storeorupdate($request);
    
            return redirect()->route('karyawan')
                ->with('success', 'Berhasil menambahkan karyawan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan karyawan. Error: ' . $e->getMessage());
        }
    }
    public function form() {
        $group = Group::all();
        $section = Section::all();
        $department = Departemen::all();

        return view('admin.form.add', compact('group', 'section', 'department'));
    }
    // add user end


    // add periode
    public function tambahBaris(Request $request) {
        // Validasi inp
        // Cek apakah periode sudah ada

        try {
            if (Periode::where('periode', $request->periode)->exists()) {
                return redirect()->back()->with('error', 'Gagal menambah periode. Periode sudah ada.');    
            }

            // Lakukan penambahan periode atau operasi lainnya di sini
            
            // Set status menjadi 0 untuk semua baris
            Periode::where('status', 1)->update(['status' => 0]);
            
            // Tambahkan baris baru dengan status 1
            $periode = Periode::create([
                'periode' => $request->periode,
                'tema' => $request->tema,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'status' => 1
            ]);
            
            // Proses data dari form untuk tabel langkah
            $nomorLangkah = 0; // Nomor langkah awal
            
            foreach ($request->langkah as $langkahData) {
                Langkah::create([
                    'periode_id' => $periode->id,
                    'name' => 'L' . $nomorLangkah,
                    'mulai' => $langkahData['mulai'] ?? now()->toDateString(), // Use current date as default if not provided
                    'sampai' => $langkahData['sampai'],
                ]);

                $nomorLangkah++; // Tambahkan nomor langkah
            }
            return redirect()->route('controlStep')->with('success', 'Berhasil menambah periode.');
        } catch (QueryException $e) {
        return redirect()->back()->with('error', 'Gagal menambah periode. Error: ' . $e->getMessage());
        }
    }

    // import user
    public function import(Request $request) {
        try {

            $file = $request->file('file')->store('public/import');
        
            $import = new UsersImport;
            $import->import($file);
        
            return redirect()->back()->with('success', 'Berhasil import data karyawan');
        }
        catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menambah user. Error: ' . $e->getMessage());
        }
    }

    // edit user start
    public function editUser($id) {
        $user = User::find($id); 
        $group = Group::all();
        $section = Section::all();
        $department = Departemen::all();
     
        // Ambil NPK user yang sedang login
        $userNpk = $user->npk;

        // tanggal masuk
        $tglMasuk = $user->tgl_masuk;
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
            $sectionName = Section::where('id_section', $sectionId)->value('section');
        } else {
            $sectionName = "Tidak ada section"; // Atau tindakan lain jika user tidak memiliki grup
        }

        // Jika record ditemukan, ambil ID group dari tabel Org
        if ($org) {
            $deptId = $org->dept;

            // Cari nama group berdasarkan ID group
            $deptName = Departemen::where('id_dept', $deptId)->value('dept');
        } else {
            $deptName = "Tidak ada departemen"; // Atau tindakan lain jika user tidak memiliki grup
        } 

        // Data yang akan dikirimkan ke view
        $data = [
            'forms' => $user,
            'groupId' => $groupId,
            'groupName' => $groupName,
            'sectionId' => $sectionId,
            'sectionName' => $sectionName,
            'deptId' => $deptId,
            'deptName' => $deptName,
            'tglMasuk' => $tglMasuk
        ];
        return view('admin.form.edit', $data, compact('group', 'section', 'department'));
    }
    public function updateUser(Request $request, $id) {
        try {
            $this->doValidate($request, $id);
            $this->storeorupdate($request, $id);
            
            return redirect()->route('karyawan')
            ->with('success', 'Berhasil edit manpower');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal ubah manpower. Error: ' . $e->getMessage());
        }
    }
    // edit user end

    // edit periode start
    public function editPeriode($id) {
        $periode = Periode::find($id);  
        // Ambil langkah yang terkait dengan periode_id
        $langkah = Langkah::where('periode_id', $periode->id)->get();
        // @dd($langkah);

        // Data yang akan dikirimkan ke view
        $data = [
            'forms' => $periode,
            'langkah' => $langkah
        ];
        return view('admin.control-period', $data);
    }
    public function updatePeriode(Request $request, $id) {
        try {
            $this->storeNewPeriode($request, $id);
    
            return redirect()->route('controlStep')
            ->with('success', 'Berhasil ubah periode');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal ubah periode. Error: ' . $e->getMessage());
        }
    }
    // edit periode end

    public function storeNewPeriode(Request $request, $id) {
        // Validasi input
        // Cek apakah periode sudah ada
        try {
            // Ambil periode yang ingin diupdate
            $periode = Periode::findOrFail($id);
            
            // Update periode
            $periode->update([
                'periode' => $request->periode,
                'tema' => $request->tema,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
            ]);
            
            // Update atau buat data langkah
            foreach ($request->langkah as $index => $langkahData) {
                $langkah = Langkah::updateOrCreate(
                    ['periode_id' => $periode->id, 'name' => 'L' . $index],
                    [
                        'mulai' => $langkahData['mulai'] ?? now()->toDateString(), 
                        'sampai' => $langkahData['sampai'],
                    ]
                );
            }
            
            return redirect()->route('controlStep')->with('success', 'Berhasil mengupdate periode.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate periode. Error: ' . $e->getMessage());
        }
    }

    // hapus periode
    public function softDelete($id) {
        $obj = Periode::find($id);
        $obj->save();
    	$obj->delete();
        return redirect()->back()->with('success', 'Berhasil hapus periode');
    }

    // hapus user
    public function softDeleteUser($id) {
        $user = User::where('npk', $id)->first();
        $org = Org::where('npk', $id)->first();

        $username = $user->name;
    	$user->delete();
    	$org->delete();
        return redirect()->back()->with('success', 'Berhasil hapus manpower: '. $username);
    }

    // download format import user
    public function downloadFormat() {
        $filePath = public_path('format/format_user.xlsx');
        return Response::download($filePath);
    }
    // download list ID user
    public function downloadList() {
        $filePath = public_path('format/list_user.xlsx');
        return Response::download($filePath);
    }
    // download format group
    public function downloadGroup() {
        $filePath = public_path('format/format_group.xlsx');
        return Response::download($filePath);
    }
    // download format group
    public function downloadSection() {
        $filePath = public_path('format/format_section.xlsx');
        return Response::download($filePath);
    }
    // download format group
    public function downloadDept() {
        $filePath = public_path('format/format_dept.xlsx');
        return Response::download($filePath);
    }

    // export all users
    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }




}
