<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserLevel;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required'
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Autentikasi user
            $credentials = $request->only('username', 'password');
            $token = auth()->guard('api')->attempt($credentials);

            // Jika token valid (berarti login berhasil)
            if ($token) {
                // Update last_login untuk user yang berhasil login
                $user = User::find(auth()->guard('api')->user()->id_user);
                $user->last_login = now();
                $user->save();

                // Ambil user_level_name dari relasi UserLevel
                $user->user_level_name = UserLevel::find($user->level_id)->name;

                // Data response
                $data = [
                    'user' => $user,
                    'token' => $token
                ];
                return new ApiResource(true, 200, 'Login successful.', $data, []);
            } else {
                // Login gagal, kirim response gagal
                return new ApiResource(false, 403, 'Login failed, incorrect username or password.', [], []);
            }
        } catch (\Exception $error) {
            // Menangani kesalahan dan mengirim pesan error
            return new ApiResource(false, 400, 'Internal server error: ' . $error->getMessage(), [], []);
        }
    }
}
