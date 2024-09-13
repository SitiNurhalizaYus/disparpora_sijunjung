<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct() {}

    public function index()
    {
        // Periksa session dengan helper
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();

        if ($has_session) {
            $data = [];
            // Ambil data dari API atau database secara langsung, bukan dari session lama
            $data['setting'] = \App\Helpers\AppHelper::instance()->requestApiSetting();
            $data['menu'] = 'profile-list';

            // Pastikan session_data diperbarui setelah login atau perubahan profil
            $data['session_data'] = \App\Helpers\AppHelper::instance()->getSessionData();
            $data['session_token'] = \App\Helpers\AppHelper::instance()->getSessionToken();

            // Ambil kategori UserLevel yang unik
            $categories = UserLevel::all()->unique('name');
            $data['categories'] = $categories;

            // Pastikan session diperbarui dengan data baru
            session(['session_data' => $data['session_data']]);

            return view('admin.profile.index', $data);
        } else {
            // Jika session tidak valid, arahkan user ke halaman login
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }

    // Fungsi untuk memperbarui profil user
    public function updateProfile(Request $request)
    {
        $has_session = \App\Helpers\AppHelper::instance()->checkSession();

        if ($has_session) {
            // Validasi data yang masuk
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'level_id' => 'required|integer|exists:user_levels,id_level',
            ]);

            // Ambil user yang sedang login menggunakan auth atau session
            $user = User::find(auth()->user()->id_user);

            // Jika user ditemukan, lakukan update
            if ($user) {
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->level_id = $validated['level_id'];
                $user->save();

                // Perbarui session dengan data terbaru
                session(['session_data' => $user]);

                // Berikan notifikasi sukses
                return redirect()->route('admin.profile.update')->with('success', 'Profil berhasil diperbarui.');
            } else {
                return redirect()->route('admin.profile.update')->with('error', 'User not found.');
            }
        } else {
            session()->flash('message', 'Session expired.');
            return redirect()->route('admin.login');
        }
    }
}
