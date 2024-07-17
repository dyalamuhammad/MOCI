<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna telah login dan memiliki jabatan 'superadmin'
        if (Auth::check() && Auth::user()->jabatan === 'Superadmin') {
            return $next($request);
        }

        // Jika tidak, arahkan pengguna kembali atau berikan respons lain sesuai kebutuhan aplikasi Anda
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
