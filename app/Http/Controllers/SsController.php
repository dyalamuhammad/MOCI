<?php

namespace App\Http\Controllers;

use App\Imports\SsImport;
use App\Imports\SsImportBulanan;
use App\Imports\UsersImport;
use App\Models\Circle;
use App\Models\Periode;
use App\Models\Ss;
use App\Models\SsBulanan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SsController extends Controller
{
    public function index(Request $request) {
        // Mengambil tahun-tahun unik dari kolom created_at
        $years = Ss::select(DB::raw('YEAR(created_at) as year'))
                      ->distinct()
                      ->pluck('year');

        // Menyaring data berdasarkan tahun yang dipilih
        $ssQuery = Ss::query();
        if ($request->has('year') && !empty($request->year)) {
            $ssQuery->whereYear('created_at', $request->year);
        }

        $data_year = $ssQuery->get();

        // Ambil parameter pencarian
        $search = $request->input('search');

        // Ambil semua data SS
        $ss = Ss::all();

        // Lakukan pencarian jika parameter search ada
        if ($search) {
            $ssQuery->where(function ($q) use ($search) {
                    $q->where('npk', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.group', function ($q) use ($search) {
                        $q->where('nama_group', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.group.coordinator', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.section', function ($q) use ($search) {
                        $q->where('section', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.section.coordinator', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });         
        }

        $data_year = $ssQuery->orderBy('id', 'asc')->get();     

        $data = [
            'search' => $request->input('search'),
            'periode' => Periode::all(), // Mendapatkan semua data dari tabel periode
            'activePeriode' => Periode::where('status', 1)->first(),
            'userNpk' => auth()->user()->npk, // Mendapatkan npk dari pengguna yang sedang login
            'circles' => Circle::paginate(50),
            'userRole' => auth()->user()->jabatan,
            'ss' => $ss,
        ];

        return view('ss.index', $data, compact('data_year', 'years'));
    }

    public function ssBulanan (Request $request) {
        $userRole = auth()->user()->jabatan; // Mendapatkan jabatan dari pengguna yang sedang login
        $search = $request->query('search', '');
        $filter = $request->query('filter', '');
        $month = $request->query('month', '');
        $year = $request->query('year', '');
    $uniqueMonths = SsBulanan::select('bulan')->distinct()->pluck('bulan');
    $uniqueYears = SsBulanan::select('tahun')->distinct()->pluck('tahun');
        $query = SsBulanan::query();
           if ($filter) {
        $query->where('status', $filter);
    }

    if ($month) {
        $query->where('bulan', $month);
    }
    if ($year) {
        $query->where('tahun', $year);
    }
        if ($search) {
            $query->where(function ($q) use ($search) {
                    $q->where('npk', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.group.coordinator', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.group', function ($q) use ($search) {
                        $q->where('nama_group', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.section', function ($q) use ($search) {
                        $q->where('section', 'like', "%{$search}%");
                    })
                    ->orWhereHas('org.section.coordinator', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $ssBulanan = $query->paginate(500);
        return view('ss.ss-bulanan', compact('ssBulanan', 'search', 'filter', 'uniqueMonths', 'uniqueYears', 'userRole', 'month', 'year'));
    }

    public function import(Request $request) {
        try {
            // Validasi file input
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
                'month' => 'required|string|in:januari,februari,maret,april,mei,juni,juli,agustus,september,oktober,november,desember'
            ]);

            // Simpan file import ke storage
            $file = $request->file('file')->store('public/import');

            // Ambil bulan dari request
            $month = $request->input('month');

            // Lakukan import data dengan bulan yang dipilih
            $import = new SsImport($month);
            Excel::import($import, $file);

            // Hapus file import setelah selesai
            Storage::delete($file);

            return redirect()->back()->with('success', 'Berhasil import data ss');
        } catch (\Exception $e) {
            // Tangkap dan log error
            Log::error('Gagal import data ss. Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal import data ss. Error: ' . $e->getMessage());
        }
    }

    public function importBulanan(Request $request) {
        try {
            // Validasi file input
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);

            $file = $request->file('file')->store('public/import');
        
            $import = new SsImportBulanan($request->bulan, $request->tahun);
            $import->import($file);

            // Hapus file import setelah selesai
             Storage::delete($file);
        
            return redirect()->back()->with('success', 'Berhasil import SS');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menambah ss. Error: ' . $e->getMessage());
    }   catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambah ss. Error: ' . $e->getMessage());
    }
}

    public function downloadFormat()
    {
        $filePath = public_path('format/format_ss.xlsx');
        return Response::download($filePath);
    }

    public function downloadFormatBulanan()
    {
        $filePath = public_path('format/format_ss_bulanan.xlsx');
        return Response::download($filePath);
    }

    public function cleanFilesSs()
    {
        Ss::truncate(); // Menghapus semua isi tabel
        return redirect()->back()->with('success', 'All files have been cleaned.');
    }
    public function cleanFiles()
    {
        SsBulanan::truncate(); // Menghapus semua isi tabel
        return redirect()->back()->with('success', 'All files have been cleaned.');
    }

    public function deleteSelected(Request $request) {
    $ids = $request->input('ids', []);

    if (!empty($ids)) {
        SsBulanan::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', 'Selected rows deleted successfully.');
    }

    return redirect()->back()->with('error', 'No rows selected for deletion.');
}



}
