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
use App\Models\DampakPositif;
use App\Models\ImplemenPerbaikan;
use App\Models\Iterasi;
use App\Models\IterasiCbi;
use App\Models\ManfaatPanca;
use App\Models\Member;
use App\Models\MemberDt;
use Illuminate\Http\Request;

use App\Models\NotulenCbi1;
use App\Models\NotulenCbi2;
use App\Models\NotulenCbi3;
use App\Models\NotulenCbi4;
use App\Models\NotulenCbi5;
use App\Models\NotulenCbi6;
use App\Models\NotulenCbi7;
use App\Models\NotulenCbi8;
use App\Models\NotulenCbi9;

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
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class NotulenCbiController extends Controller
{
    // ------ notulen 1 start ----
    public function add(Request $request) {
        try {
            $this->doValidate($request);
            // Periksa apakah ada entri di tabel notulen1 dengan circle_id yang sama
        $existingNotulen = NotulenCbi1::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            // $this->updateL1($request);
            $this->storeorupdate($request);
    
            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',
            'judul' => 'required',
            'background' => 'required',
            'demo_customer' => 'required',
            'nama' => 'required',
            'usia' => 'required',
            'asal' => 'required',
            'motivasi' => 'required',
            'apa' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate(Request $request, $id = null) {
        $obj = $id === null ? new NotulenCbi1() : NotulenCbi1::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->judul = $request->judul;
        $obj->background = $request->background;
        $obj->demo_customer = $request->demo_customer;

        // Dapatkan id terakhir dari record di tabel Background
        $lastPersonaId = PersonaCbi::latest()->value('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $personaId = $lastPersonaId ? $lastPersonaId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->persona = $personaId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $persona = new PersonaCbi();
        $persona->id = $personaId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $persona->circle_id = $request->circle_id;
        $persona->notulen_id = $notulenId;

        $persona->nama = $request->nama; // Contoh: $request->nama adalah "icare"
        $persona->usia = $request->usia; // Contoh: $request->asal adalah 10
        $persona->asal = $request->asal; // Contoh: $request->asal adalah 10
        $persona->motivasi = $request->motivasi; // Contoh: $request->motivasi adalah 8
        $persona->apa = $request->apa; // Contoh: $request->apa adalah 7
        
        $persona->save();
            
           

        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->l1 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
            $existingNotulen = NotulenCbi2::where('circle_id', $request->circle_id)->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
            }
            $this->storeorupdate_2($request);

            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }

    public function doValidate_2($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',
            'see' => 'required',
            'hear' => 'required',
            'think' => 'required',
            'do' => 'required',
            'pain' => 'required',
            'gain' => 'required',
        ];  
        $request->validate($model);
    }

    public function storeorupdate_2(Request $request, $id = null) {
        $obj = $id === null ? new NotulenCbi2() : NotulenCbi2::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->see = $request->see;
        $obj->hear = $request->hear;
        $obj->think = $request->think;
        $obj->do = $request->do;
        $obj->pain = $request->pain;
        $obj->gain = $request->gain;



        $obj->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->l2 = 1;
        $circle->save();
    
        // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l2 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
        $existingNotulen = NotulenCbi3::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_3($request);
    
            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_3($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',
            'stage' => 'required',
            'touch_point' => 'required',
            'doing' => 'required',
            'expect' => 'required',
            'thinking' => 'required',
            'pain_point' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate_3(Request $request, $id = null) {
    
        $obj = $id === null ? new NotulenCbi3() : NotulenCbi3::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->stage = $request->stage;
        $obj->touch_point = $request->touch_point;
        $obj->doing = $request->doing;
        $obj->expect = $request->expect;
        $obj->thinking = $request->thinking;
        $obj->pain_point = $request->pain_point;
      

        // Simpan setiap baris input ke dalam tabel NotulenCbi3
        foreach ($request->stage as $key => $stage) {
            $obj = new NotulenCbi3();
            $obj->circle_id = $request->circle_id;
            $obj->stage = $stage;
            $obj->touch_point = $request->touch_point[$key];
            $obj->doing = $request->doing[$key];
            $obj->expect = $request->expect[$key];
            $obj->thinking = $request->thinking[$key];
            $obj->pain_point = $request->pain_point[$key];
            $obj->save();
        }


        $obj->save();
        
        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->l3 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
        $existingNotulen = NotulenCbi4::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_4($request);
    
            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_4($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',

        ];
           
        $request->validate($model);
    }
    public function storeorupdate_4(Request $request, $id = null) {
    
        $obj = $id === null ? new NotulenCbi4() : NotulenCbi4::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->pengguna = $request->pengguna;
        $obj->kebutuhan = $request->kebutuhan;
        $obj->insight = $request->insight;
        $obj->problem = $request->problem;
        

        $obj->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->l4 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
        $existingNotulen = NotulenCbi5::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_5($request);
    
            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_5($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',
            'rank_1' => 'required',
            'rank_2' => 'required',
            'rank_3' => 'required',
            'desirability' => 'required',
            'viability' => 'required',
            'feasebility' => 'required',
            'ide_terpilih' => 'required',
          ];
           
        $request->validate($model);
    }
    public function storeorupdate_5(Request $request, $id = null) {
    
        $obj = $id === null ? new NotulenCbi5() : NotulenCbi5::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->rank_1 = $request->rank_1;
        $obj->rank_2 = $request->rank_2;
        $obj->rank_3 = $request->rank_3;
        $obj->desirability = $request->desirability;
        $obj->viability = $request->viability;
        $obj->feasebility = $request->feasebility;
        $obj->ide_terpilih = $request->ide_terpilih;
        

        // Dapatkan id terakhir dari record di tabel Background
        $lastBrainstormId = BrainstormingCbi::latest()->value('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $brainstormId = $lastBrainstormId ? $lastBrainstormId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->brainstorming = $brainstormId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $brainstorming = new BrainstormingCbi();
        $brainstorming->id = $brainstormId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $brainstorming->circle_id = $request->circle_id;
        $brainstorming->notulen_id = $notulenId;

        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $brainstorming->anggota = $request->anggota; // Contoh: $request->category adalah "icare"
        $brainstorming->ide_1 = $request->ide_1; // Contoh: $request->target adalah 10
        $brainstorming->ide_2 = $request->ide_2; // Contoh: $request->judge adalah 8
        $brainstorming->ide_3 = $request->ide_3; // Contoh: $request->actual adalah 7
        // Simpan nilai-nilai yang diperlukan dari setiap baris input pada tabel background
        $anggotas = $request->anggota;
        $ide_1s = $request->ide_1;
        $ide_2s = $request->ide_2;
        $ide_3s = $request->ide_3;

        // Simpan setiap baris input ke dalam tabel Background
        foreach ($anggotas as $key => $anggota) {
            $brainstorming = new BrainstormingCbi();
            $brainstorming->id = $brainstormId;
            $brainstorming->circle_id = $request->circle_id;
            $brainstorming->notulen_id = $obj->id;
            $brainstorming->anggota = $anggota;
            $brainstorming->ide_1 = $ide_1s[$key];
            $brainstorming->ide_2 = $ide_2s[$key];
            $brainstorming->ide_3 = $ide_3s[$key];
            $brainstorming->save();
            
            // Tingkatkan id background untuk baris berikutnya
            $brainstormId++;
        }
        $brainstorming->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->l5 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
        $existingNotulen = NotulenCbi6::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_6($request);
    
            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_6($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',
            'foto' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate_6(Request $request, $id = null) {
    
        $obj = $id === null ? new NotulenCbi6() : NotulenCbi6::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->foto = $request->foto;
        $obj->foto_3d = $request->foto_3d;
        $obj->foto_sketsa = $request->foto_sketsa;
        
        if ($request->foto_3d) {
            date_default_timezone_set('Asia/Jakarta');
            $imageName = date('dmYHis') . '.' .$request->foto_3d->extension();
            $imagePath = 'notulencbi6/';
            $request->foto_3d->move(public_path($imagePath), $imageName);
            $imgPath = 'notulencbi6/' . $imageName;
    
            $obj->foto_3d = $imgPath;
        }
        if ($request->foto_sketsa) {
            date_default_timezone_set('Asia/Jakarta');
            $imageName = date('dmYHis') . '.' .$request->foto_sketsa->extension();
            $imagePath = 'notulencbi6/';
            $request->foto_sketsa->move(public_path($imagePath), $imageName);
            $imgPath = 'notulencbi6/' . $imageName;
    
            $obj->foto_sketsa = $imgPath;
        }
        if ($request->foto) {
            date_default_timezone_set('Asia/Jakarta');
            $imageName = date('dmYHis') . '.' .$request->foto->extension();
            $imagePath = 'notulencbi6/';
            $request->foto->move(public_path($imagePath), $imageName);
            $imgPath = 'notulencbi6/' . $imageName;
    
            $obj->foto = $imgPath;
        }
        
        // Dapatkan id terakhir dari record di tabel Background
        $lastBeforeId = StoryBeforeCbi::latest()->value('id');
        $lastAfterId = StoryAfterCbi::latest()->value('id');
            
        // Jika tidak ada id terakhir, atur id pertama ke 1
        $beforeId = $lastBeforeId ? $lastBeforeId + 1 : 1;
        $afterId = $lastAfterId ? $lastAfterId + 1 : 1;

        // Masukkan id background ke dalam kolom background pada Notulen1
        $obj->story_before = $beforeId;
        $obj->story_after = $afterId;

        $obj->save();
        $notulenId = $obj->id;

        // Buat entri baru dalam tabel Background
        $storyBefore = new StoryBeforeCbi();
        $storyBefore->id = $beforeId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $storyBefore->circle_id = $request->circle_id;
        $storyBefore->notulen_id = $notulenId;

        $storyBefore->step = $request->step_before; // Contoh: $request->target adalah 10
        $storyBefore->detail = $request->detail_before; // Contoh: $request->target adalah 10
        $storyBefore->foto = $request->foto_before; // Contoh: $request->target adalah 10
   
        $steps = $request->step_before;
        $details = $request->detail_before;
        $fotos = $request->foto_before;
    
        // Simpan setiap baris input ke dalam tabel Story Before
        foreach ($steps as $key => $step) {
            $storyBefore = new StoryBeforeCbi();
            $storyBefore->id = $beforeId;
            $storyBefore->circle_id = $request->circle_id;
            $storyBefore->notulen_id = $obj->id;
            $storyBefore->step = $step;
            $storyBefore->detail = $details[$key];
            // Cek apakah ada file yang diunggah untuk kunci $key
            if (isset($fotos[$key])) {
                // Simpan file di sini
                date_default_timezone_set('Asia/Jakarta');
                $file = $fotos[$key];
                $fileName = date('His') . $beforeId . '.' .$file->extension();
                $imagePath = 'notulencbi6/story-before/';
                $file->move(public_path($imagePath), $fileName);
                $filePath = 'notulencbi6/story-before/' . $fileName;

                // Simpan nama file ke dalam objek Analisa4m1e
                $storyBefore->foto = $filePath;
            }       
            $storyBefore->save();
            
            // Tingkatkan id Story Before untuk baris berikutnya
            $beforeId++;
        }
        $storyBefore->save();

        // Buat entri baru dalam tabel story after
        $storyAfter = new StoryAfterCbi();
        $storyAfter->id = $beforeId;
        // Set nilai-nilai lainnya sesuai dengan kebutuhan
        $storyAfter->circle_id = $request->circle_id;
        $storyAfter->notulen_id = $notulenId;

        $storyAfter->step = $request->step_after; // Contoh: $request->target adalah 10
        $storyAfter->detail = $request->detail_after; // Contoh: $request->target adalah 10
        $storyAfter->foto = $request->foto_after; // Contoh: $request->target adalah 10

        $steps = $request->step_after;
        $details = $request->detail_after;
        $fotos = $request->foto_after;
    
        // Simpan setiap baris input ke dalam tabel Story after
        foreach ($steps as $key => $step) {
            $storyAfter = new StoryAfterCbi();
            $storyAfter->id = $afterId;
            $storyAfter->circle_id = $request->circle_id;
            $storyAfter->notulen_id = $obj->id;
            $storyAfter->step = $step;
            $storyAfter->detail = $details[$key];
            // Cek apakah ada file yang diunggah untuk kunci $key
            if (isset($fotos[$key])) {
                // Simpan file di sini
                date_default_timezone_set('Asia/Jakarta');
                $file = $fotos[$key];
                $fileName = date('His') . $afterId . '.' .$file->extension();
                $imagePath = 'notulencbi6/story-after/';
                $file->move(public_path($imagePath), $fileName);
                $filePath = 'notulencbi6/story-after/' . $fileName;

                // Simpan nama file ke dalam objek Analisa4m1e
                $storyAfter->foto = $filePath;
            }   
       
            $storyAfter->save();
            
            // Tingkatkan id Story after untuk baris berikutnya
            $afterId++;
        }
        $storyAfter->save();
        

        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->l6 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
        $existingNotulen = NotulenCbi7::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            $this->storeorupdate_7($request);
    
            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_7($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',
            'suka' => 'required',
            'tingkatkan' => 'required',
            'pertimbangkan' => 'required',
            'tidak_mengerti' => 'required',
            'hypotesis' => 'required',
            'observation' => 'required',
            'learning' => 'required',
            'decision' => 'required',

        ];
           
        $request->validate($model);
    }
    public function storeorupdate_7(Request $request, $id = null) {
    
        $obj = $id === null ? new NotulenCbi7() : NotulenCbi7::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->nama_improve = $request->nama_improve;
        $obj->nama_persona = $request->nama_persona;
        $obj->tanggal_uji = $request->tanggal_uji;
        $obj->suka = $request->suka;
        $obj->tingkatkan = $request->tingkatkan;
        $obj->pertimbangkan = $request->pertimbangkan;
        $obj->tidak_mengerti = $request->tidak_mengerti;
        $obj->hypotesis = $request->hypotesis;
        $obj->observation = $request->observation;
        $obj->learning = $request->learning;
        $obj->decision = $request->decision;
        if (!empty($request->foto)){
                    // Dapatkan id terakhir dari record di tabel Iterasi
                    $lastIterasiId = IterasiCbi::latest()->value('id');
            
                    // Jika tidak ada id terakhir, atur id pertama ke 1
                    $iterasiId = $lastIterasiId ? $lastIterasiId + 1 : 1;
            
                    // Masukkan id iterasi ke dalam kolom iterasi pada NotulenDt7
                    $obj->iterasi = $iterasiId;
            
                    $obj->save();
                    $notulenId = $obj->id;
            
                    // Buat entri baru dalam tabel Iterasi
                    $iterasi = new IterasiCbi();
                    $iterasi->id = $iterasiId;
                    // Set nilai-nilai lainnya sesuai dengan kebutuhan
                    $iterasi->circle_id = $request->circle_id;
                    $iterasi->notulen_id = $notulenId;
                    if ($request->foto) {
                        date_default_timezone_set('Asia/Jakarta');
                        $imageName = date('dmYHis') . '.' .$request->foto->extension();
                        $imagePath = 'iterasicbi7/';
                        $request->foto->move(public_path($imagePath), $imageName);
                        $imgPath = 'iterasicbi7/' . $imageName;
                
                        $iterasi->foto = $imgPath;
                    }
            
                    // Dapatkan id terakhir dari record di tabel storyBefore dan storyAfter
                    $lastBeforeId = StoryBeforeCbi7::latest()->value('id');
                    $lastAfterId = StoryAfterCbi7::latest()->value('id');
                        
                    // Jika tidak ada id terakhir, atur id pertama ke 1
                    $beforeId = $lastBeforeId ? $lastBeforeId + 1 : 1;
                    $afterId = $lastAfterId ? $lastAfterId + 1 : 1;
            
                    $iterasi->story_before = $beforeId; // Contoh: $request->target adalah 10
                    $iterasi->story_after = $afterId; // Contoh: $request->target adalah 10
            
                    $iterasi->save();
            
                    // Buat entri baru dalam tabel StoryBeforeCbi7
                    $storyBefore = new StoryBeforeCbi7();
                    $storyBefore->id = $beforeId;
                    // Set nilai-nilai lainnya sesuai dengan kebutuhan
                    $storyBefore->circle_id = $request->circle_id;
                    $storyBefore->notulen_id = $iterasiId;
            
                    $storyBefore->step = $request->step_before; // Contoh: $request->target adalah 10
                    $storyBefore->detail = $request->detail_before; // Contoh: $request->target adalah 10
               
                    $steps = $request->step_before;
                    $details = $request->detail_before;
                    
                    // Simpan setiap baris input ke dalam tabel Story Before Dt 7
                    foreach ($steps as $key => $step) {
                        $storyBefore = new StoryBeforeCbi7();
                        $storyBefore->id = $beforeId;
                        $storyBefore->circle_id = $request->circle_id;
                        $storyBefore->notulen_id = $iterasiId;
                        $storyBefore->step = $step;
                        $storyBefore->detail = $details[$key];
                   
                        $storyBefore->save();
                        
                        // Tingkatkan id Story Before untuk baris berikutnya
                        $beforeId++;
                    }
                    $storyBefore->save();
            
                    // Buat entri baru dalam tabel story after
                    $storyAfter = new StoryAfterCbi7();
                    $storyAfter->id = $afterId;
                    // Set nilai-nilai lainnya sesuai dengan kebutuhan
                    $storyAfter->circle_id = $request->circle_id;
                    $storyAfter->notulen_id = $iterasiId;
            
                    $storyAfter->step = $request->step_after; // Contoh: $request->target adalah 10
                    $storyAfter->detail = $request->detail_after; // Contoh: $request->target adalah 10
               
                    $steps = $request->step_after;
                    $details = $request->detail_after;
                
                    // Simpan setiap baris input ke dalam tabel Story after
                    foreach ($steps as $key => $step) {
                        $storyAfter = new StoryAfterCbi7();
                        $storyAfter->id = $afterId;
                        $storyAfter->circle_id = $request->circle_id;
                        $storyAfter->notulen_id = $iterasiId;
                        $storyAfter->step = $step;
                        $storyAfter->detail = $details[$key];
                   
                        $storyAfter->save();
                        
                        // Tingkatkan id Story after untuk baris berikutnya
                        $afterId++;
                    }
                    $storyAfter->save();
        } else {
            $obj->iterasi = 'Tidak Mengisi';
            $obj->save();
        }
   

        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->l7 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
        $existingNotulen = NotulenCbi8::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            // $this->updateL1($request);
            $this->storeorupdate_8($request);
    
            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_8($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',
            'csi' => 'required',
            'cei' => 'required',
            'nps' => 'required',
            'safety' => 'required',
            'quality' => 'required',
            'cost' => 'required',
            'moral' => 'required',
            'delivery' => 'required',
            'environment' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate_8(Request $request, $id = null) {
    
        $obj = $id === null ? new NotulenCbi8() : NotulenCbi8::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->csi = $request->csi;
        $obj->cei = $request->cei;
        $obj->nps = $request->nps;
        $obj->safety = $request->safety;
        $obj->quality = $request->quality;
        $obj->cost = $request->cost;
        $obj->delivery = $request->delivery;
        $obj->moral = $request->moral;
        $obj->environment = $request->environment;
        
        $obj->save();
                 
        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->l8 = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
        $existingNotulen = NotulenCbi9::where('circle_id', $request->circle_id)->exists();
        
        if ($existingNotulen) {
            throw new \Exception('Anda sudah melakukan absen, dan tidak dapat dilakukan lagi.');
        }
            // $this->updateL1($request);
            $this->storeorupdate_9($request);
    
            return redirect()->route('absensiCbi')
                ->with('success', 'Berhasil menambahkan absen');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan absen. Error: ' . $e->getMessage());
        }
    }
    public function doValidate_9($request) {
        $model = [
            'circle_id' => 'required|exists:circles_dt_cbi,id',
            'problem' => 'required',
            'solusi' => 'required',
            'hasil' => 'required',
            'benefit' => 'required',
            'manfaat' => 'required',
        ];
           
        $request->validate($model);
    }
    public function storeorupdate_9(Request $request, $id = null) {
    
        $obj = $id === null ? new NotulenCbi9() : NotulenCbi9::find($id);
        $obj->circle_id = $request->circle_id;
        $obj->problem = $request->problem;
        $obj->solusi = $request->solusi;
        $obj->hasil = $request->hasil;
        $obj->benefit = $request->benefit;
        $obj->manfaat = $request->manfaat;
        $obj->file = $request->file;
        
        if ($request->file) {
            date_default_timezone_set('Asia/Jakarta');
            $fileName = date('dmYHis') . '.' .$request->file->extension();
            $filePath = 'notulenCbi9/';
            $request->file->move(public_path($filePath), $fileName);
            $imgPath = 'notulenCbi9/' . $fileName;
    
            $obj->file = $imgPath;
        }

    

        $obj->save();

        // Perbarui status pada tabel Circle menjadi 1
        $circle = CircleDt::find($request->circle_id);
        $circle->nqi = 1;
        $circle->save();
    
            // Mendapatkan array memberId dari permintaan POST
        $memberIds = $request->input('memberId', []);

        // Mengubah nilai l1 untuk setiap member yang dicek
        foreach ($memberIds as $memberId) {
            $isChecked = 1;
            $member = MemberDt::find($memberId);
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
