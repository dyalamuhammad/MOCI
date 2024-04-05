<?php

namespace App\Http\Middleware;

use App\Models\Langkah;
use App\Models\Periode;
use Closure;
use Carbon\Carbon;

class CheckSchedule
{
    public function handle($request, Closure $next)
{
    $langkah = Langkah::join('periodes', 'langkah.periode_id', '=', 'periodes.id')
        ->where('periodes.status', 1)
        ->select('langkah.mulai', 'langkah.sampai')
        ->first();

    if (!$langkah) {
        return redirect()->back()->with('error', 'Tidak ada data langkah yang ditemukan.');
    }

    $now = now()->toDateString();
    if ($now < $langkah->mulai) {
        return redirect()->back()->with('error', 'Halaman tidak dapat diakses karena jadwal belum dimulai.');
    }

    return $next($request);
}


}
