<h1>Halo, {{ $user->name }}!</h1>

<p>Terima kasih telah mendaftar di sistem kami. Silakan klik tautan di bawah ini untuk memverifikasi alamat email Anda:</p>

<a href="{{ $verificationUrl }}">Verifikasi Email</a>

<p>Tautan ini akan kadaluwarsa dalam 60 menit.</p>

<p>Jika Anda tidak merasa melakukan registrasi, silakan abaikan email ini.</p>
