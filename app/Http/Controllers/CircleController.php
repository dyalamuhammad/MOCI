<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\CircleDt;
use App\Models\Comment;
use App\Models\Member;
use App\Models\MemberDt;
use App\Models\Notulen1;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use function Laravel\Prompts\confirm;

class CircleController extends Controller
{

    public function store(Request $request)
    {
        try {
            // Validasi data yang dikirim dari formulir
            $request->validate([
                'name' => 'required|string|max:255',
                'npk_leader' => [
                    'required',
                    'string',
                    'max:255',
                    // Menambahkan aturan validasi khusus untuk memeriksa apakah npk leader sudah ada di tabel circle
                    function ($attribute, $value, $fail) {
                        // Cari circle dengan leader yang sama
                        $existingCircle = Circle::where('npk_leader', $value)->first();
                        // @dd($value);
                      
                        if ($existingCircle) {
                            // Jika ada circle dengan leader yang sama, periksa juga periode circle tersebut
                            $activePeriode = Periode::where('status', 1)->first();
                            
                            if ($activePeriode && $activePeriode->periode == $existingCircle->periode) {
                                // Jika periode circle tidak sama dengan periode yang aktif sekarang
                                $fail('Nama leader sudah ada di dalam circle lain untuk periode yang berbeda.');
                            }
                        }
                    },
                ],
                'npkMembers.*' => 'required|string|max:255',
                'npkMembers' => [
                    'required',
                    'array',
                    'min:3',
                    function ($attribute, $value, $fail) {
                        $activePeriode = Periode::where('status', 1)->first();

                        if ($activePeriode) {
                            foreach ($value as $npkMember) {
                                $npkExists = User::where('npk', $npkMember)->exists();
                                if (!$npkExists) {
                                    $fail("Anggota dengan NPK : {$npkMember} tidak ditemukan.");
                                    return;
                                }

                                $existingMember = Member::where('npk_anggota', $npkMember)
                                    ->whereHas('circle', function ($query) use ($activePeriode) {
                                        $query->where('periode', $activePeriode->periode);
                                    })
                                    ->first();

                                if ($existingMember) {
                                    $fail("Anggota dengan NPK : {$npkMember} sudah ada di dalam circle lain untuk periode yang sama.");
                                }
                            }
                        }
                    },
                ],
                 
                'npkMembers.min' => 'Anggota minimal harus 3 orang.',
            ]);

            // Simpan data circle ke dalam database
            $circle = new Circle();
            $circle->periode = $request->periode;
            $circle->npk_leader = $request->npk_leader;
            $circle->name = $request->name;
            $circle->leader = $request->leader;
            $circle->save();

           

        
    
            if ($request->has('npkMembers')) {
                foreach ($request->npkMembers as $memberNpk) {
                    $circle->npkMembers()->create([
                        'npk_anggota' => $memberNpk , 
                        'l1' => '0',
                        'l2' => '0',
                        'l3' => '0',
                        'l4' => '0',
                        'l5' => '0',
                        'l6' => '0',
                        'l7' => '0',
                        'l8' => '0',
                        'nqi' => '0',
                    ]);
                }
            }


            // Redirect ke halaman tertentu setelah penyimpanan berhasil
            return redirect()->route('home')->with('success', 'Circle successfully created.');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Failed to create circle. Error: ' . $e->getMessage());
        }
    }
    public function storeDt(Request $request)
    {
        try {
            // Validasi data yang dikirim dari formulir
            $request->validate([
                'name' => 'required|string|max:255',
                'npk_leader' => [
                    'required',
                    'string',
                    'max:255',
                    // Menambahkan aturan validasi khusus untuk memeriksa apakah npk leader sudah ada di tabel circle
                    function ($attribute, $value, $fail) {
                        // Cari circle dengan leader yang sama
                        $existingCircle = CircleDt::where('npk_leader', $value)->first();
                        
                        if ($existingCircle) {
                            // Jika ada circle dengan leader yang sama, periksa juga periode circle tersebut
                            $activePeriode = Periode::where('status', 1)->first();
                            
                            if ($activePeriode && $activePeriode->periode == $existingCircle->periode) {
                                // Jika periode circle tidak sama dengan periode yang aktif sekarang
                                $fail('Nama leader sudah ada di dalam circle lain untuk periode yang sama.');
                            }
                        }
                    },
                ],
                'npkMembers.*' => 'required|string|max:255',
                'npkMembers' => [
                    'required',
                    'array',
                    'min:3',
                    function ($attribute, $value, $fail) {
                        $activePeriode = Periode::where('status', 1)->first();

                        if ($activePeriode) {
                            foreach ($value as $npkMember) {
                                $npkExists = User::where('npk', $npkMember)->exists();
                                if (!$npkExists) {
                                    $fail("Anggota dengan NPK : {$npkMember} tidak ditemukan.");
                                    return;
                                }

                                $existingMember = MemberDt::where('npk_anggota', $npkMember)
                                    ->whereHas('circle', function ($query) use ($activePeriode) {
                                        $query->where('periode', $activePeriode->periode);
                                    })
                                    ->first();

                                if ($existingMember) {
                                    $fail("Anggota dengan NPK : {$npkMember} sudah ada di dalam circle lain untuk periode yang sama.");
                                }
                            }
                        }
                    },
                ],
                 
                'npkMembers.min' => 'Anggota minimal harus 3 orang.',
            ]);

            // Simpan data circle ke dalam database
            $circleDt = new CircleDt();
            $circleDt->periode = $request->periode;
            $circleDt->npk_leader = $request->npk_leader;
            $circleDt->name = $request->name;
            $circleDt->leader = $request->leader;
            $circleDt->category = $request->category;
            $circleDt->save();

        
    
            if ($request->has('npkMembers')) {
                foreach ($request->npkMembers as $memberNpk) {
                    MemberDt::create([
                        'circle_id' => $circleDt->id,
                        'npk_anggota' => $memberNpk , 
                        'l1' => '0',
                        'l2' => '0',
                        'l3' => '0',
                        'l4' => '0',
                        'l5' => '0',
                        'l6' => '0',
                        'l7' => '0',
                        'l8' => '0',
                        'nqi' => '0',
                    ]);
                }
            }


            // Redirect ke halaman tertentu setelah penyimpanan berhasil
            return redirect()->route('home')->with('success', 'Circle successfully created.');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Failed to create circle. Error: ' . $e->getMessage());
        }
    }

    public function approve($id)
    {
        $circle = Circle::findOrFail($id);
        

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l1 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return redirect()->route('monitorQcc')->with('success', 'Approve berhasil.');    
    }

    public function approveL2($id)
    {
        $circle = Circle::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l2 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorQcc');
    }

    public function approveL3($id)
    {
        $circle = Circle::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l3 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorQcc');
    }

    public function approveL4($id)
    {
        $circle = Circle::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l4 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorQcc');
    }

    public function approveL5($id)
    {
        $circle = Circle::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l5 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorQcc');
    }

    public function approveL6($id)
    {
        $circle = Circle::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l6 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorQcc');
    }

    public function approveL7($id)
    {
        $circle = Circle::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l7 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorQcc');
    }

    public function approveL8($id)
    {
        $circle = Circle::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l8 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorQcc');
    }

    public function approveL9($id)
    {
        $circle = Circle::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->nqi = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorQcc');
    }

    public function approveDt($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l1 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }

    public function approveDt2($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l2 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }

    public function approveDt3($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l3 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }

    public function approveDt4($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l4 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }
    public function approveDt5($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l5 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }
    public function approveDt6($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l6 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }
    public function approveDt7($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l7 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }
    public function approveDt8($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l8 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }
    public function approveDt9($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->nqi = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorDt');
    }
    public function approveCbi($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l1 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }

    public function approveCbi2($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l2 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }

    public function approveCbi3($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l3 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }

    public function approveCbi4($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l4 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }
    public function approveCbi5($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l5 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }
    public function approveCbi6($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l6 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }
    public function approveCbi7($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l7 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }
    public function approveCbi8($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->l8 = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }
    public function approveCbi9($id)
    {
        $circle = CircleDt::findOrFail($id);

        // Ubah nilai l1 menjadi 2 (atau nilai lain yang sesuai dengan kebutuhan Anda)
        $circle->nqi = 2; // Misalnya, setujui dengan mengubah nilai l1 menjadi 2

        // Simpan perubahan
        $circle->save();

        // Tambahkan respons atau tindakan tambahan jika diperlukan
        return Redirect::route('monitorCbi');
    }
  
}
