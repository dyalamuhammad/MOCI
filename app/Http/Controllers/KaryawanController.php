<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function getKaryawanByNPK($npk)
    {
        $karyawan = User::where('npk', $npk)->first();
        return response()->json($karyawan);
    }
}
