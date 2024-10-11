<?php

use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Rute untuk memproses verifikasi email
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1']) // Menggunakan middleware 'signed' dan 'throttle'
    ->name('verification.verify');

// // Rute untuk mengirim ulang tautan verifikasi
// Route::post('/email/resend', [VerificationController::class, 'resend'])
//     ->middleware(['auth', 'throttle:6,1'])
//     ->name('verification.resend');

// Route::get('/email/verify', function () {
//     return view('client.auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Client\EmailVerificationController::class, 'verify'])
//     ->middleware(['signed','throttle:6,1'])
//     ->name('verification.verify');

// Route::post('/email/resend', [App\Http\Controllers\Client\EmailVerificationController::class, 'resend'])
//     ->middleware(['auth', 'throttle:6,1'])
//     ->name('verification.resend');

// Route::get('/email/verify-message', [App\Http\Controllers\Client\MessageController::class, 'verifyMessage'])->name('message.verify');
// Rute untuk menyimpan pesan
// Route::post('/message/store', [App\Http\Controllers\Client\MessageController::class, 'sendMessage'])->name('message.store');


// Rute untuk email verifikasi
Route::get('/email-verified', function () {
    return view('emails.email_verified');
})->name('email.verified');

// Rute untuk halaman pesan (message.index)
Route::get('/message', function () {
    return view('client.message.index');
})->name('message.index');

Auth::routes(['verify' => true]);

Route::middleware([\App\Http\Middleware\AutoCreateLogs::class])->group(function () {
    Route::get('/', [App\Http\Controllers\Client\BerandaController::class, 'index']);
    Route::get('/beranda', [App\Http\Controllers\Client\BerandaController::class, 'index']);

    Route::get('/message', [App\Http\Controllers\Client\HubungikamiController::class, 'index'])->name('client.message.index');
    Route::post('/message/submit', [App\Http\Controllers\Client\HubungikamiController::class, 'submit']);

    Route::get('/profil/{slug}', [App\Http\Controllers\Client\ProfilController::class, 'detail'])->name('client.profil.detail');

    Route::get('/berita', [App\Http\Controllers\Client\BeritaController::class, 'index'])->name('client.berita.index');
    Route::get('/berita/{slug}', [App\Http\Controllers\Client\BeritaController::class, 'detail'])->name('client.berita.detail');

    Route::get('/artikel', [App\Http\Controllers\Client\ArtikelController::class, 'index'])->name('client.artikel.index');
    Route::get('/artikel/{slug}', [App\Http\Controllers\Client\ArtikelController::class, 'detail'])->name('client.artikel.detail');

    Route::get('/agenda', [App\Http\Controllers\Client\AgendaController::class, 'index'])->name('client.agenda.index');
    Route::get('/ppid/statistik', [App\Http\Controllers\Client\StatistikController::class, 'index'])->name('client.statistik');

    Route::get('/document', [App\Http\Controllers\Client\DocumentController::class, 'index'])->name('client.document.index');

    Route::get('/lokawisata', [App\Http\Controllers\Client\InfoTempatController::class, 'index'])->name('client.lokawisata.index');
    Route::get('/lokawisata/{id}', [App\Http\Controllers\Client\InfoTempatController::class, 'detail'])->name('client.lokawisata.detail');
    Route::get('/virtual_tour', [App\Http\Controllers\Client\VirtualTourController::class, 'index'])->name('client.virtual_tour.index');
    Route::get('/virtual_tour/{id}', [App\Http\Controllers\Client\VirtualTourController::class, 'detail'])->name('client.virtual_tour.detail');
});

Route::group(['prefix' => 'admin', 'middleware' => [\App\Http\Middleware\AutoCreateLogs::class]], function () {
    // Authentication routes
    Route::get('/', [App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('auth', [App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('auth/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('auth/action_login', [App\Http\Controllers\Admin\AuthController::class, 'action_login']);
    Route::get('auth/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
    Route::get('auth/forgot', [App\Http\Controllers\Admin\AuthController::class, 'forgot']);
    Route::get('auth/error', [App\Http\Controllers\Admin\AuthController::class, 'error'])->name('admin.error');

    // Admin dashboard and profile
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index']);
    // Route untuk mengupdate profil
    Route::post('/profile/{id_user}', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Resource routes
    Route::resource('posters', App\Http\Controllers\Admin\PosterController::class);
    Route::resource('bignumbers', App\Http\Controllers\Admin\BigNumberController::class);
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);
    Route::resource('mitras', App\Http\Controllers\Admin\MitraController::class);
    Route::resource('profils', App\Http\Controllers\Admin\ProfilController::class);
    Route::resource('beritas', App\Http\Controllers\Admin\BeritaController::class);
    Route::resource('artikels', App\Http\Controllers\Admin\ArtikelController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('documents', App\Http\Controllers\Admin\DocumentController::class);
    Route::resource('galeries', App\Http\Controllers\Admin\DocumentController::class);
    Route::resource('agendas', App\Http\Controllers\Admin\AgendaController::class);
    Route::resource('lokawisatas', App\Http\Controllers\Admin\InfoTempatController::class);
    Route::resource('messages', App\Http\Controllers\Admin\MessageController::class);
    Route::resource('settings', App\Http\Controllers\Admin\SettingController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('survey', App\Http\Controllers\Admin\SurveyController::class);
   

});
