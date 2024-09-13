<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminOrEditor
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user(); // Ambil user yang login

        if ($user && ($user->user_level_id == 1 || $user->user_level_id == 2)) {
            return $next($request); // Jika admin atau editor, lanjutkan request
        }

        // Jika bukan admin atau editor, kembalikan ke halaman error atau halaman lain
        return redirect()->route('admin.error')->with('message', 'Access Denied.');
    }
}
