<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagementMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna telah login dan memiliki jabatan 'superadmin'
        // Periksa apakah pengguna telah login
    if (Auth::check()) {
        // Periksa apakah jabatan pengguna adalah salah satu dari 'DH', 'SPV', 'FRM', atau 'TL'
        $allowedRoles = ['DH', 'SPV', 'FRM', 'TL', 'Superadmin', 'MNG', 'AMNG'];
        if (in_array(Auth::user()->jabatan, $allowedRoles)) {
            return $next($request);
        }
    }

        // Jika tidak, arahkan pengguna kembali atau berikan respons lain sesuai kebutuhan aplikasi Anda
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
