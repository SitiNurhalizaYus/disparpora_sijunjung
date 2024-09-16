<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('verification.notice')); // Mengarahkan setelah verifikasi
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('verification.verify'))->with('status', 'Email Anda sudah terverifikasi.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return view(route('verification.notice'))->with('status', 'Email Anda sudah terverifikasi.');
        }
    
        $request->user()->sendEmailVerificationNotification();
    
        return view(route('verification.resend'))->with('status', 'Tautan verifikasi baru telah dikirim.');
    }
}
