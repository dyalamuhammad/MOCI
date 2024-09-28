<?php

namespace App\Http\Controllers;

use App\Models\Analisa4m1e;
use App\Models\AspekMutu;
use App\Models\Background;
use App\Models\BackgroundL8;
use App\Models\Circle;
use App\Models\DampakPositif;
use App\Models\ImplemenPerbaikan;
use App\Models\ManfaatPanca;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Notulen1;
use App\Models\Notulen2;
use App\Models\Notulen3;
use App\Models\Notulen4;
use App\Models\Notulen5;
use App\Models\Notulen6;
use App\Models\Notulen7;
use App\Models\Notulen8;
use App\Models\Notulen9;
use App\Models\RencanaPerbaikan;
use App\Models\SmartC;
use App\Models\Standarisasi;
use App\Models\Tema;
use App\Models\UjiPenyebab;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class NotulenController extends Controller
{
    // ------ notulen 1 start ----
    public function add(Request $request) {
        try {
            $this->doValidate($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
        $existingNotulen = Notulen1::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            // $this->updateL1($request);
            $this->storeorupdate($request);
    
            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',
            'judul' => 'required',
            'analisa' => 'required',
            'category' => 'required',
            'target' => 'required',
            'actual' => 'required',
            'judge' => 'required',
            'nama_tema' => 'required',
            'alasan' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate(Request $request, $id = null) {
    
        $obj = $id === null ? new Notulen1() : Notulen1::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->judul = $request->judul;
        $obj->analisa = $request->analisa;
        $obj->foto = $request->foto;
        
        if ($request->foto) {
            date_default_timezone_set('Asia/Jakarta');
            $imageName = date('dmYHis') . '.' .$request->foto->extension();
            $imagePath = 'notulen1/';
            $request->foto->move(public_path($imagePath), $imageName);
            $imgPath = 'notulen1/' . $imageName;
    
            $obj->foto = $imgPath;
        }

        // Dapatkan id terakhir dari record di tabel Background
        $lastBackgroundId = Background::max('id');
        $lastTemaId = Tema::max('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $backgroundId = $lastBackgroundId ? $lastBackgroundId + 1 : 1;
        $temaId = $lastTemaId ? $lastTemaId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->background = $backgroundId;
        $obj->tema = $temaId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $background = new Background();
        $background->id = $backgroundId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $background->circle_id = $request->circle_id;
        $background->notulen_id = $notulenId;

        $background->category = $request->category; // Contoh: $request->category adalah "icare"
        $background->target = $request->target; // Contoh: $request->target adalah 10
        $background->judge = $request->judge; // Contoh: $request->judge adalah 8
        $background->actual = $request->actual; // Contoh: $request->actual adalah 7
        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $categories = $request->category;
        $targets = $request->target;
        $judges = $request->judge;
        $actuals = $request->actual;

        // Simpan setiap baris input ke dalam tabel Background
        foreach ($categories as $key => $category) {
            $background = new Background();
            $background->id = $backgroundId;
            $background->circle_id = $request->circle_id;
            $background->notulen_id = $obj->id;
            $background->category = $category;
            $background->target = $targets[$key];
            $background->judge = $judges[$key];
            $background->actual = $actuals[$key];
            $background->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $backgroundId++;
        }
        $background->save();


        $tema = new Tema();
        $tema->id = $temaId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $tema->circle_id = $request->circle_id;
        $tema->notulen_id = $notulenId;
        $tema->nama_tema = $request->nama_tema; // Contoh: $request->target adalah 10
        $tema->alasan = $request->alasan; // Contoh: $request->judge adalah 8
         
        $tema->save();
            
           

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->l1 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->l1 = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }
    
    // ----- notulen 1 end ----

    // ----- notulen 2 start ----
    public function add_2(Request $request) {
        try {
            $this->doValidate_2($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
            $existingNotulen = Notulen2::where('circle_id', $request->circle_id)->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
            }
            $this->storeorupdate_2($request);

            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }

    public function doValidate_2($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',
        ];  
        $request->validate($model);
    }

    public function storeorupdate_2(Request $request, $id = null) {
        $obj = $id === null ? new Notulen2() : Notulen2::find($id);
        $obj->circle_id = $request->circle_id;

        // Dapatkan id terakhir dari record di tabel Background
        $lastAspekMutuId = AspekMutu::max('id');
        $lastSmartCId = SmartC::max('id');
        $lastDampakId = DampakPositif::max('id');
        
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $aspekMutuId = $lastAspekMutuId ? $lastAspekMutuId + 1 : 1;
        $smartCId = $lastSmartCId ? $lastSmartCId + 1 : 1;
        $dampakId = $lastDampakId ? $lastDampakId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->target_aspek = $aspekMutuId;
        $obj->target_smart = $smartCId;
        $obj->dampak = $dampakId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Aspek Mutu
        $aspekMutu = new AspekMutu();
        $aspekMutu->id = $aspekMutuId;
        $aspekMutu->circle_id = $request->circle_id;
        $aspekMutu->notulen_id = $notulenId;
        $aspekMutu->category = $request->categoryAspek; // Contoh: $request->category adalah "icare"
        $aspekMutu->detail = $request->detailAspek; // Contoh: $request->target adalah 10

        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel Aspek Mutu
        $categories = $request->categoryAspek;
        $details = $request->detailAspek;
      
        // Simpan setiap baris input ke dalam tabel Aspek Mutu
        foreach ($categories as $key => $category) {
            $aspekMutu = new AspekMutu();
            $aspekMutu->id = $aspekMutuId;
            $aspekMutu->circle_id = $request->circle_id;
            $aspekMutu->notulen_id = $obj->id;
            $aspekMutu->category = $category;
            $aspekMutu->detail = $details[$key];
            $aspekMutu->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $aspekMutuId++;
        }
        $aspekMutu->save();

        // Buat entri baru dalam tabel Aspek Mutu
        $smartC = new SmartC();
        $smartC->id = $smartCId;
        $smartC->circle_id = $request->circle_id;
        $smartC->notulen_id = $notulenId;
        $smartC->category = $request->categorySmart; // Contoh: $request->category adalah "icare"
        $smartC->detail = $request->detailSmart; // Contoh: $request->target adalah 10

        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel Aspek Mutu
        $categories = $request->categorySmart;
        $details = $request->detailSmart;
      
        // Simpan setiap baris input ke dalam tabel Aspek Mutu
        foreach ($categories as $key => $category) {
            $smartC = new SmartC();
            $smartC->id = $smartCId;
            $smartC->circle_id = $request->circle_id;
            $smartC->notulen_id = $obj->id;
            $smartC->category = $category;
            $smartC->detail = $details[$key];
            $smartC->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $smartCId++;
        }
        $smartC->save();

       
        
        // Buat entri baru dalam tabel Aspek Mutu
        $dampakPositif = new DampakPositif();
        $dampakPositif->id = $dampakId;
        $dampakPositif->circle_id = $request->circle_id;
        $dampakPositif->notulen_id = $notulenId;
        $dampakPositif->category = $request->categoryDampak; // Contoh: $request->category adalah "icare"
        $dampakPositif->detail = $request->detailDampak; // Contoh: $request->target adalah 10

        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel Aspek Mutu
        $categories = $request->categoryDampak;
        $details = $request->detailDampak;
        // Simpan setiap baris input ke dalam tabel Aspek Mutu
        foreach ($categories as $key => $category) {
            $dampakPositif = new DampakPositif();
            $dampakPositif->id = $dampakId;
            $dampakPositif->circle_id = $request->circle_id;
            $dampakPositif->notulen_id = $obj->id;
            $dampakPositif->category = $category;
            $dampakPositif->detail = $details[$key];
            $dampakPositif->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $dampakId++;
        }
        $dampakPositif->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->l2 = 1;
        $circle->save();
    
        // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l2 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->l2 = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }  
    // --- notulen 2 end ---

    // ------ notulen 3 start ----
    public function add_3(Request $request) {
        try {
            $this->doValidate_3($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
        $existingNotulen = Notulen3::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_3($request);
    
            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_3($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',
            'why1_4m1e' => 'required',
            'akar_masalah' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate_3(Request $request, $id = null) {
    
        $obj = $id === null ? new Notulen3() : Notulen3::find($id);
        $obj->circle_id = $request->circle_id;

        // Dapatkan id terakhir dari record di tabel Background
        $lastAnalisa4m1eId = Analisa4m1e::max('id');
        $lastUjiPenyebabId = UjiPenyebab::max('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $analisa4m1eId = $lastAnalisa4m1eId ? $lastAnalisa4m1eId + 1 : 1;
        $ujiPenyebabId = $lastUjiPenyebabId ? $lastUjiPenyebabId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->analisa_4m1e = $analisa4m1eId;
        $obj->uji_penyebab = $ujiPenyebabId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $analisa4m1e = new Analisa4m1e();
        $analisa4m1e->id = $analisa4m1eId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $analisa4m1e->circle_id = $request->circle_id;
        $analisa4m1e->notulen_id = $notulenId;

        $analisa4m1e->category = $request->category4m1e; // Contoh: $request->category adalah "icare"
        $analisa4m1e->why1 = $request->why1_4m1e; // Contoh: $request->target adalah 10
        $analisa4m1e->why2 = $request->why2_4m1e; // Contoh: $request->target adalah 10
        $analisa4m1e->why3 = $request->why3_4m1e; // Contoh: $request->target adalah 10
        $analisa4m1e->why4 = $request->why4_4m1e; // Contoh: $request->target adalah 10
        $analisa4m1e->why5 = $request->why5_4m1e; // Contoh: $request->target adalah 10
        $analisa4m1e->foto = $request->foto_4m1e; // Contoh: $request->foto adalah 8
        // Jika ada file yang diunggah


        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $categories = $request->category4m1e;
        $why1s = $request->why1_4m1e;
        $why2s = $request->why2_4m1e;
        $why3s = $request->why3_4m1e;
        $why4s = $request->why4_4m1e;
        $why5s = $request->why5_4m1e;
        $fotos = $request->foto_4m1e;

        // Simpan setiap baris input ke dalam tabel Background
        foreach ($categories as $key => $category) {
            $analisa4m1e = new Analisa4m1e();
            $analisa4m1e->id = $analisa4m1eId;
            $analisa4m1e->circle_id = $request->circle_id;
            $analisa4m1e->notulen_id = $obj->id;
            $analisa4m1e->category = $category;
            $analisa4m1e->why1 = $why1s[$key];
            $analisa4m1e->why2 = $why2s[$key];
            $analisa4m1e->why3 = $why3s[$key];
            $analisa4m1e->why4 = $why4s[$key];
            $analisa4m1e->why5 = $why5s[$key];
            // Cek apakah ada file yang diunggah untuk kunci $key
            if (isset($fotos[$key])) {
                // Simpan file di sini
                $file = $fotos[$key];
                $fileName = date('dmYHis') . '_' . $file->getClientOriginalName();
                $file->move(public_path('notulen3'), $fileName);

                // Simpan nama file ke dalam objek Analisa4m1e
                $analisa4m1e->foto = $fileName;
            }           
            
            $analisa4m1e->save();
            // Tingkatkan id background untuk baris berikutnya
            $analisa4m1eId++;
        }

        // Buat entri baru dalam tabel Background
        $ujiPenyebab = new UjiPenyebab();
        $ujiPenyebab->id = $ujiPenyebabId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $ujiPenyebab->circle_id = $request->circle_id;
        $ujiPenyebab->notulen_id = $notulenId;

        $ujiPenyebab->akar_masalah = $request->akar_masalah; // Contoh: $request->category adalah "icare"
        $ujiPenyebab->standar = $request->standar; // Contoh: $request->category adalah "icare"
        $ujiPenyebab->metode_validasi = $request->metode_validasi; // Contoh: $request->category adalah "icare"
        $ujiPenyebab->actual = $request->actual; // Contoh: $request->category adalah "icare"
        $ujiPenyebab->judge = $request->judge; // Contoh: $request->category adalah "icare"
       // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $akar_masalahs = $request->akar_masalah;
        $standars = $request->standar;
        $metode_validasis = $request->metode_validasi;
        $actuals = $request->actual;
        $judges = $request->judge;

        // Ambil panjang array $akar_masalahs
        $maxLength = count($akar_masalahs);

        // Simpan setiap baris input ke dalam tabel Background
        for ($key = 0; $key < $maxLength; $key++) {
            // Lakukan validasi untuk memastikan setidaknya satu bidang diisi untuk setiap kategori
                $ujiPenyebab = new UjiPenyebab();
                $ujiPenyebab->id = $ujiPenyebabId;
                $ujiPenyebab->circle_id = $request->circle_id;
                $ujiPenyebab->notulen_id = $obj->id;
                $ujiPenyebab->akar_masalah = $akar_masalahs[$key];
                $ujiPenyebab->standar = $standars[$key];
                $ujiPenyebab->metode_validasi = $metode_validasis[$key];
                $ujiPenyebab->actual = $actuals[$key];
                $ujiPenyebab->judge = $judges[$key];
                $ujiPenyebab->save();
                
                // Tingkatkan id background untuk baris berikutnya
                $ujiPenyebabId++;
        }

        $ujiPenyebab->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->l3 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->l3 = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }
    // ----- notulen 3 end ----
    
    // ------ notulen 4 start ----
    public function add_4(Request $request) {
        try {
            $this->doValidate_4($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
        $existingNotulen = Notulen4::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_4($request);
    
            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_4($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',

        ];
           
        $request->validate($model);
    }
    public function storeorupdate_4(Request $request, $id = null) {
    
        $obj = $id === null ? new Notulen4() : Notulen4::find($id);
        $obj->circle_id = $request->circle_id;
        

        // Dapatkan id terakhir dari record di tabel Background
        $lastrencanaId = RencanaPerbaikan::max('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $rencanaId = $lastrencanaId ? $lastrencanaId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->rencana_perbaikan = $rencanaId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $rencanaPerbaikan = new RencanaPerbaikan();
        $rencanaPerbaikan->id = $rencanaId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $rencanaPerbaikan->circle_id = $request->circle_id;
        $rencanaPerbaikan->notulen_id = $notulenId;

        $rencanaPerbaikan->what = $request->what; // Contoh: $request->target adalah 10
        $rencanaPerbaikan->how = $request->how; // Contoh: $request->target adalah 10
        $rencanaPerbaikan->why = $request->why; // Contoh: $request->target adalah 10
        $rencanaPerbaikan->where = $request->where; // Contoh: $request->target adalah 10
        $rencanaPerbaikan->who = $request->who; // Contoh: $request->target adalah 10
        $rencanaPerbaikan->when = $request->when; // Contoh: $request->judge adalah 8
        $rencanaPerbaikan->how_much = $request->how_much; // Contoh: $request->judge adalah 8
        $rencanaPerbaikan->target_antara = $request->target_antara; // Contoh: $request->judge adalah 8
        $rencanaPerbaikan->foto = $request->foto; // Contoh: $request->judge adalah 8
        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $whats = $request->what;
        $hows = $request->how;
        $whys = $request->why;
        $wheres = $request->where;
        $whos = $request->who;
        $whens = $request->when;
        $how_muchs = $request->how_much;
        $fotos = $request->foto;

        // Ambil panjang array $akar_masalahs
        $maxLength = count($whats);

        // Simpan setiap baris input ke dalam tabel Background
        for ($key = 0; $key < $maxLength; $key++) {
            $rencanaPerbaikan = new RencanaPerbaikan();
            $rencanaPerbaikan->id = $rencanaId;
            $rencanaPerbaikan->circle_id = $request->circle_id;
            $rencanaPerbaikan->notulen_id = $obj->id;
            $rencanaPerbaikan->what = $whats[$key];
            $rencanaPerbaikan->how = $hows[$key];
            $rencanaPerbaikan->why = $whys[$key];
            $rencanaPerbaikan->where = $wheres[$key];
            $rencanaPerbaikan->who = $whos[$key];
            $rencanaPerbaikan->when = $whens[$key];
            $rencanaPerbaikan->how_much = $how_muchs[$key];
            $rencanaPerbaikan->foto = $fotos[$key];
            // Cek apakah ada file yang diunggah untuk kunci $key
    if (isset($fotos[$key])) {
        // Simpan file di sini
        $file = $fotos[$key];
        $fileName = date('dmYHis') . '_' . $file->getClientOriginalName();
        $file->move(public_path('notulen4'), $fileName);

        // Simpan nama file ke dalam objek Analisa4m1e
        $rencanaPerbaikan->foto = $fileName;
    } 
            $rencanaPerbaikan->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $rencanaId++;
        }
        $rencanaPerbaikan->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->l4 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->l4 = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }
    // ----- notulen 4 end ----

    // ------ notulen 5 start ----
    public function add_5(Request $request) {
        try {
            $this->doValidate_5($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
        $existingNotulen = Notulen5::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_5($request);
    
            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_5($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',
            'foto_improve' => 'required',
            'what' => 'required',
            'how' => 'required',
            'where' => 'required',
            'why' => 'required',
            'when' => 'required',
            'how_much' => 'required',
            'who' => 'required',

        ];
           
        $request->validate($model);
    }
    public function storeorupdate_5(Request $request, $id = null) {
    
        $obj = $id === null ? new Notulen5() : Notulen5::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->foto_improve = $request->foto_improve;
        
        if ($request->foto_improve) {
            date_default_timezone_set('Asia/Jakarta');
            $imageName = date('dmYHis') . '.' .$request->foto_improve->extension();
            $imagePath = 'notulen5/';
            $request->foto_improve->move(public_path($imagePath), $imageName);
            $imgPath = 'notulen5/' . $imageName;
    
            $obj->foto_improve = $imgPath;
        }

        // Dapatkan id terakhir dari record di tabel Background
        $lastImplemenId = ImplemenPerbaikan::max('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $implemenId = $lastImplemenId ? $lastImplemenId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->implemen_perbaikan = $implemenId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $implemenPerbaikan = new ImplemenPerbaikan();
        $implemenPerbaikan->id = $implemenId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $implemenPerbaikan->circle_id = $request->circle_id;
        $implemenPerbaikan->notulen_id = $notulenId;

        $implemenPerbaikan->what = $request->what; // Contoh: $request->target adalah 10
        $implemenPerbaikan->how = $request->how; // Contoh: $request->target adalah 10
        $implemenPerbaikan->why = $request->why; // Contoh: $request->target adalah 10
        $implemenPerbaikan->where = $request->where; // Contoh: $request->target adalah 10
        $implemenPerbaikan->who = $request->who; // Contoh: $request->target adalah 10
        $implemenPerbaikan->when = $request->when; // Contoh: $request->judge adalah 8
        $implemenPerbaikan->how_much = $request->how_much; // Contoh: $request->judge adalah 8
        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $whats = $request->what;
        $hows = $request->how;
        $whys = $request->why;
        $wheres = $request->where;
        $whos = $request->who;
        $whens = $request->when;
        $how_muchs = $request->how_much;

        // Ambil panjang array $akar_masalahs
        $maxLength = count($whats);

        // Simpan setiap baris input ke dalam tabel Background
        for ($key = 0; $key < $maxLength; $key++) {
            $implemenPerbaikan = new ImplemenPerbaikan();
            $implemenPerbaikan->id = $implemenId;
            $implemenPerbaikan->circle_id = $request->circle_id;
            $implemenPerbaikan->notulen_id = $obj->id;
            $implemenPerbaikan->what = $whats[$key];
            $implemenPerbaikan->how = $hows[$key];
            $implemenPerbaikan->why = $whys[$key];
            $implemenPerbaikan->where = $wheres[$key];
            $implemenPerbaikan->who = $whos[$key];
            $implemenPerbaikan->when = $whens[$key];
            $implemenPerbaikan->how_much = $how_muchs[$key];
            $implemenPerbaikan->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $implemenId++;
        }
        $implemenPerbaikan->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->l5 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->l5 = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }
    // ----- notulen 5 end ----

    // ------ notulen 6 start ----
    public function add_6(Request $request) {
        try {
            $this->doValidate_6($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
        $existingNotulen = Notulen6::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_6($request);
    
            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_6($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',
            'safety' => 'required',
            'quality' => 'required',
            'cost' => 'required',
            'delivery' => 'required',
            'moral' => 'required',
            'environment' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate_6(Request $request, $id = null) {
    
        $obj = $id === null ? new Notulen6() : Notulen6::find($id);
        $obj->circle_id = $request->circle_id;
        
        // Dapatkan id terakhir dari record di tabel Background
        $lastmanfaatId = ManfaatPanca::max('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $manfaatId = $lastmanfaatId ? $lastmanfaatId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->manfaat_panca = $manfaatId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $manfaatPanca = new ManfaatPanca();
        $manfaatPanca->id = $manfaatId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $manfaatPanca->circle_id = $request->circle_id;
        $manfaatPanca->notulen_id = $notulenId;

        $manfaatPanca->safety = $request->safety; // Contoh: $request->target adalah 10
        $manfaatPanca->cost = $request->cost; // Contoh: $request->target adalah 10
        $manfaatPanca->quality = $request->quality; // Contoh: $request->target adalah 10
        $manfaatPanca->delivery = $request->delivery; // Contoh: $request->target adalah 10
        $manfaatPanca->moral = $request->moral; // Contoh: $request->target adalah 10
        $manfaatPanca->environment = $request->environment; // Contoh: $request->target adalah 10
   
        $manfaatPanca->save();
        

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->l6 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->l6 = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }
    // ----- notulen 6 end ----

    // ------ notulen 7 start ----
    public function add_7(Request $request) {
        try {
            $this->doValidate_7($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
        $existingNotulen = Notulen7::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_7($request);
    
            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_7($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',
            'what' => 'required',
            'how' => 'required',
            'when' => 'required',
            'who' => 'required',
            'where' => 'required',

        ];
           
        $request->validate($model);
    }
    public function storeorupdate_7(Request $request, $id = null) {
    
        $obj = $id === null ? new Notulen7() : Notulen7::find($id);
        $obj->circle_id = $request->circle_id;

        // Dapatkan id terakhir dari record di tabel Background
        $lastStandarisasiId = Standarisasi::max('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $rencanaId = $lastStandarisasiId ? $lastStandarisasiId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->standarisasi = $rencanaId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $standarisasi = new Standarisasi();
        $standarisasi->id = $rencanaId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $standarisasi->circle_id = $request->circle_id;
        $standarisasi->notulen_id = $notulenId;

        $standarisasi->what = $request->what; // Contoh: $request->target adalah 10
        $standarisasi->how = $request->how; // Contoh: $request->target adalah 10
        $standarisasi->why = $request->why; // Contoh: $request->target adalah 10
        $standarisasi->where = $request->where; // Contoh: $request->target adalah 10
        $standarisasi->who = $request->who; // Contoh: $request->target adalah 10
        $standarisasi->when = $request->when; // Contoh: $request->judge adalah 8
        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $whats = $request->what;
        $hows = $request->how;
        $whys = $request->why;
        $wheres = $request->where;
        $whos = $request->who;
        $whens = $request->when;
 

        // Ambil panjang array $akar_masalahs
        $maxLength = count($whats);

        // Simpan setiap baris input ke dalam tabel Background
        for ($key = 0; $key < $maxLength; $key++) {
            $standarisasi = new Standarisasi();
            $standarisasi->id = $rencanaId;
            $standarisasi->circle_id = $request->circle_id;
            $standarisasi->notulen_id = $obj->id;
            $standarisasi->what = $whats[$key];
            $standarisasi->how = $hows[$key];
            $standarisasi->why = $whys[$key];
            $standarisasi->where = $wheres[$key];
            $standarisasi->who = $whos[$key];
            $standarisasi->when = $whens[$key];
            $standarisasi->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $rencanaId++;
        }
        $standarisasi->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->l7 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->l7 = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }
    // ----- notulen 7 end ----

    // ------ notulen 8 start ----
    public function add_8(Request $request) {
        try {
            $this->doValidate_8($request);
            // Periksa apakah ada entri di tabel notulen8 dengan circle_id yang sama
        $existingNotulen = Notulen8::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            // $this->updateL1($request);
            $this->storeorupdate_8($request);
    
            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_8($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',
            'judul' => 'required',
            'category' => 'required',
            'target' => 'required',
            'actual' => 'required',
            'judge' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate_8(Request $request, $id = null) {
    
        $obj = $id === null ? new Notulen8() : Notulen8::find($id);
        $obj->circle_id = $request->circle_id;
        
        if ($request->foto) {
            date_default_timezone_set('Asia/Jakarta');
            $imageName = date('dmYHis') . '.' .$request->foto->extension();
            $imagePath = 'notulen8/';
            $request->foto->move(public_path($imagePath), $imageName);
            $imgPath = 'notulen8/' . $imageName;
    
            $obj->foto = $imgPath;
        }

        // Dapatkan id terakhir dari record di tabel Background
        $lastBackgroundId = BackgroundL8::max('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $backgroundId = $lastBackgroundId ? $lastBackgroundId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->background = $backgroundId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $background = new BackgroundL8();
        $background->id = $backgroundId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $background->circle_id = $request->circle_id;
        $background->notulen_id = $notulenId;

        $background->category = $request->category; // Contoh: $request->category adalah "icare"
        $background->target = $request->target; // Contoh: $request->target adalah 10
        $background->judge = $request->judge; // Contoh: $request->judge adalah 8
        $background->actual = $request->actual; // Contoh: $request->actual adalah 7
        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $categories = $request->category;
        $targets = $request->target;
        $judges = $request->judge;
        $actuals = $request->actual;

        // Simpan setiap baris input ke dalam tabel Background
        foreach ($categories as $key => $category) {
            $background = new BackgroundL8();
            $background->id = $backgroundId;
            $background->circle_id = $request->circle_id;
            $background->notulen_id = $obj->id;
            $background->category = $category;
            $background->target = $targets[$key];
            $background->judge = $judges[$key];
            $background->actual = $actuals[$key];
            $background->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $backgroundId++;
        }
        $background->save();            
           

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->l8 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->l8 = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }
    // ----- notulen 8 end ----

    // ------ notulen 9 start ----
    public function add_9(Request $request) {
        try {
            $this->doValidate_9($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
        $existingNotulen = Notulen9::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            // $this->updateL1($request);
            $this->storeorupdate_9($request);
    
            return redirect()->route('absensiQcc')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_9($request) {
        $model = [
            'circle_id' => 'required|exists:circles,id',
            'benefit' => 'required',
            'manfaat' => 'required',
            'file' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate_9(Request $request, $id = null) {
    
        $obj = $id === null ? new Notulen9() : Notulen9::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->benefit = $request->benefit;
        $obj->manfaat = $request->manfaat;
        $obj->file = $request->file;
        
        if ($request->file) {
            date_default_timezone_set('Asia/Jakarta');
            $fileName = date('dmYHis') . '.' .$request->file->extension();
            $filePath = 'notulen9/';
            $request->file->move(public_path($filePath), $fileName);
            $imgPath = 'notulen9/' . $fileName;
    
            $obj->file = $imgPath;
        }

    

        $obj->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = Circle::find($request->circle_id);
        $circle->nqi = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = Member::find($memberId);
            if ($member !== null) {
                $member->nqi = $isChecked;
                $member->save();
            } else {
                // Objek $member tidak ditemukan, Anda dapat menangani kasus ini di sini
                echo "Member dengan ID $memberId tidak ditemukan.";
            }
        }
    }
    // ----- notulen 9 end ----

}
