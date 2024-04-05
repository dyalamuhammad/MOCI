<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Langkah;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    public function index(Request $request) {
        $users = User::query(); // Memulai kueri dengan menggunakan query builder
    
        $filter = $request->filter ?? '';
        if ($filter === 'tm') {
            $users->where('jabatan', User::TM);
        } else if ($filter === 'tl') {
            $users->where('jabatan', User::TL);
        } else if ($filter === 'fm') {
            $users->where('jabatan', User::FM);
        } else if ($filter === 'dh') {
            $users->where('jabatan', User::DH);
        }
        else if ($filter === 'superadmin') {
            $users->where('jabatan', User::SUPERADMIN);
        }
    
        $users = $users->orderBy('id', 'asc')->paginate(10);     
        $data = [
            'users' => $users,
            'filter' => $filter
        ];
        return view("admin.karyawan", $data);
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

    public function storeorupdate(Request $request, $id = null) {
    
        $obj = $id === null ? new User() : User::find($id);
        $obj->name = $request->name;
        $obj->npk = $request->npk;
        $obj->jabatan = $request->jabatan;
        $obj->section = $request->section;
        $obj->status = $request->status;
        $obj->shift = $request->shift;
        $obj->password = $request->password;
        
        
        $obj->save();
        

    }
    public function doValidate($request, $id=null) {
        $model = [
            'name' => 'required',
            'npk' => 'required',
            'jabatan' => 'required',
            'section' => 'required',
            'status' => 'required',
            'jabatan' => 'required',
        ];
           
        $request->validate($model);
    }
    public function add(Request $request) {
        try {
            $this->doValidate($request);
            $this->storeorupdate($request);
    
            return redirect()->route('karyawan')
                ->with('success', 'Berhasil menambahkan karyawan');
        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'Gagal menambahkan karyawan. Error: ' . $e->getMessage());
        }
    }
    public function form() {

        return view('admin.form');
    }



public function tambahBaris(Request $request)
{
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



    // Return success response
}
public function import(Request $request)
{
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

public function ubahPeriode($id) {
        $periode = Periode::find($id);  
        // Ambil langkah yang terkait dengan periode_id
        $langkah = Langkah::where('periode_id', $periode->id)->get();

        // Data yang akan dikirimkan ke view
        $data = [
            'forms' => $periode,
            'langkah' => $langkah
        ];
        return view('admin.control-period', $data);
    }
    public function softDelete($id) {
        $obj = Periode::find($id);
        $obj->save();
    	$obj->delete();
        return redirect()->back()->with('success', 'Berhasil hapus periode');
    }

}
