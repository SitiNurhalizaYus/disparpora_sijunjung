<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Memeriksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('login'); // Arahkan ke halaman login jika belum login
        }

        // Memeriksa apakah role pengguna sesuai dengan yang diberikan
        if (Auth::user()->role != $role) {
            return redirect('/unauthorized'); // Arahkan ke halaman unauthorized jika role tidak sesuai
        }

        return $next($request); // Lanjutkan jika role sesuai
    }
}

