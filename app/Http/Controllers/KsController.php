<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\CircleDt;
use App\Models\Departemen;
use App\Models\Group;
use App\Models\KnowSharing;
use App\Models\Langkah;
use App\Models\Org;
use App\Models\Periode;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KsController extends Controller
{
    public function index(Request $request) {
        $files = KnowSharing::query();
        $userRole = auth()->user()->jabatan; // Mendapatkan jabatan dari pengguna yang sedang login

        $filter = $request->filter ?? '';
        if ($filter === 'safety') {
            $files->where('category', KnowSharing::SAFETY);
        } else if ($filter === 'cost') {
            $files->where('category', KnowSharing::COST);
        } else if ($filter === 'quality') {
            $files->where('category', KnowSharing::QUALITY);
        } else if ($filter === 'environment') {
            $files->where('category', KnowSharing::ENVIRONMENT);
        } else if ($filter === 'delivery') {
            $files->where('category', KnowSharing::DELIVERY);
        } else if ($filter === 'morale') {
            $files->where('category', KnowSharing::MORALE);
        }
     

        // Pencarian berdasarkan nama atau atribut lainnya
        $search = $request->input('search');
        if ($search) {
            $files->where('category', 'like', "%$search%")
                ->orWhere('file', 'like', "%$search%")
                ->orWhere('problem', 'like', "%$search%")
                ->orWhere('improvement', 'like', "%$search%");
        }

        $files = $files->orderBy('id', 'asc')->get();     
        // @dd($files);


        $data = [
            'user' => Auth::user(),
            'files' => $files,
            'filter' => $filter,
            'search' => $search,
            'userRole' => $userRole
        ];

        return view('knowledge-sharing.index', $data);
    }

    public function add(Request $request) {
        try {
            $this->doValidate($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
            // $this->updateL1($request);
            $this->storeorupdate($request);
    
            return redirect()->route('home-ks')
                ->with('success', 'Berhasil upload file');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan file. Error: ' . $e->getMessage());
        }
    }
    public function doValidate($request) {
        $model = [
            'category' => 'required',
            'file' => 'required',   
            'problem' => 'required',   
            'improvement' => 'required',   
        ];
           
        $request->validate($model);
    }
    public function storeorupdate(Request $request, $id = null) {
    
        $obj = $id === null ? new KnowSharing() : KnowSharing::find($id);
        $obj->category = $request->category;
        $obj->problem = $request->problem;
        $obj->improvement = $request->improvement;
   
        $obj->file = $request->file;
        
        if ($request->hasFile('file')) {
            // Mengambil file yang diunggah oleh pengguna
            $uploadedFile = $request->file('file');

            // Mengambil nama asli file yang diunggah
            $fileName = $uploadedFile->getClientOriginalName();

            // Menentukan direktori penyimpanan file
            $filePath = 'knowledgeSharing/';

            // Memindahkan file yang diunggah ke direktori penyimpanan dengan nama asli
            $uploadedFile->move(public_path($filePath), $fileName);

            // Menyimpan path file ke dalam variabel
            $filePath = $fileName;

            // Menyimpan path file ke dalam properti 'file' dari objek yang ditangani
            $obj->file = $filePath;
        }   
        $obj->save();

    }

    public function cleanFiles(Request $request)
    {
        KnowSharing::truncate(); // Menghapus semua isi tabel
        return redirect()->back()->with('success', 'All files have been cleaned.');
    }
    

   
}