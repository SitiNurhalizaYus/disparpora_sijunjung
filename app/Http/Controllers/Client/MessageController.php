<?php 
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validasi form input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|email', // Pastikan email valid
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cek apakah email sudah terdaftar sebelumnya
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Membuat password random dengan kombinasi 8 huruf dan angka
            $randomPassword = Str::random(8);

            // Logika untuk mendapatkan username default 'umum1', 'umum2', dst.
            $lastUser = DB::table('users')
                ->where('username', 'like', 'umum%')
                ->orderBy('username', 'desc')
                ->first();

            if ($lastUser) {
                // Ambil angka terakhir dari username (misalnya 'umum12') dan increment
                $lastNumber = (int)str_replace('umum', '', $lastUser->username);
                $newUsername = 'umum' . ($lastNumber + 1);
            } else {
                // Jika belum ada username dengan 'umum', mulai dengan 'umum1'
                $newUsername = 'umum1';
            }

            // Membuat user baru
            $user = User::create([
                'name' => $request->name,
                'username' => $newUsername, // Assign username default
                'email' => $request->email,
                'password' => Hash::make($randomPassword), // Hash password acak
            ]);

            // Mengirim email verifikasi ke pengguna baru
            $user->sendEmailVerificationNotification();

            return response()->json([
                'message' => 'Silakan verifikasi email Anda. Setelah verifikasi, Anda dapat mengirim pesan.'
            ], 200);
        } else if (!$user->hasVerifiedEmail()) {
            // Jika user sudah ada tetapi belum verifikasi, kirim ulang email verifikasi
            $user->sendEmailVerificationNotification();
            return response()->json([
                'message' => 'Email belum diverifikasi. Silakan cek email Anda untuk verifikasi.'
            ], 403);
        }

        // Jika email sudah diverifikasi, simpan pesan ke tabel Message
        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'file' => $request->file('file')->store('messages') ?? null, // Simpan file jika ada
        ]);

        return response()->json(['message' => 'Pesan berhasil terkirim.'], 200);
    }
}
