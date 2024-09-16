<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    /**
     * Handle the email verification process.
     */
    public function verify(EmailVerificationRequest $request)
    {
        // Check if the user's email is already verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/email-verified'); // Redirect to a page after verification
        }

        // Mark the email as verified
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redirect after verification is successful
        return redirect()->intended('/email-verified')->with('status', 'Email Anda sudah terverifikasi.');
    }

    /**
     * Resend the email verification link.
     */
    public function resend(Request $request)
    {
        // Check if the user's email is already verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/email-verified');
        }

        // Resend the verification link
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Tautan verifikasi baru telah dikirim.');
    }
}
