<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UploadController;

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

Route::middleware([\App\Http\Middleware\AutoCreateLogs::class])->group(function () {
    Route::get('/', [App\Http\Controllers\Client\BerandaController::class, 'index']);
    Route::get('/beranda', [App\Http\Controllers\Client\BerandaController::class, 'index']);

    Route::get('/feature', [App\Http\Controllers\Client\FeatureController::class, 'index']);
    Route::get('/pricing', [App\Http\Controllers\Client\PricingController::class, 'index']);
    // Route::get('/blog', [App\Http\Controllers\Client\BlogController::class, 'index']);
    // Route::get('/blog/detail/{id}', [App\Http\Controllers\Client\BlogController::class, 'detail']);
    Route::get('/faq', [App\Http\Controllers\Client\FaqController::class, 'index']);
    Route::get('/contact', [App\Http\Controllers\Client\ContactController::class, 'index']);
    Route::post('/contact/submit', [App\Http\Controllers\Client\ContactController::class, 'submit']);
    // Route::get('/page/{id}', [App\Http\Controllers\Client\PageController::class, 'detail']);

    Route::get('/profil/{slug}', [App\Http\Controllers\Client\ProfilController::class, 'detail'])->name('profil');
    Route::get('/berita', [App\Http\Controllers\Client\BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/{slug}', [App\Http\Controllers\Client\BeritaController::class, 'detail'])->name('berita.detail');
    Route::get('/berita/label/{kategoriId}/{labelId}', [\App\Http\Controllers\Client\BeritaController::class, 'showByLabel'])->name('berita.label');
    Route::get('/berita/arsip/{year}/{month}', [\App\Http\Controllers\Client\BeritaController::class, 'showByArsip'])->name('berita.arsip');


});

Route::group(['prefix' => 'admin', 'middleware' => [\App\Http\Middleware\AutoCreateLogs::class]], function() {
    // Authentication routes
    Route::get('/', [App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('auth', [App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('auth/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('auth/action_login', [App\Http\Controllers\Admin\AuthController::class, 'action_login']);
    Route::get('auth/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout']);
    Route::get('auth/forgot', [App\Http\Controllers\Admin\AuthController::class, 'forgot']);
    Route::get('auth/error', [App\Http\Controllers\Admin\AuthController::class, 'error'])->name('admin.error');

    // Admin dashboard and profile
    Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'index']);
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Resource routes
    Route::resource('slider', App\Http\Controllers\Admin\SliderController::class);
    Route::resource('bignumber', App\Http\Controllers\Admin\BigNumberController::class);
    Route::resource('team', App\Http\Controllers\Admin\TeamController::class);
    Route::resource('partner', App\Http\Controllers\Admin\PartnerController::class);
    Route::resource('setting', App\Http\Controllers\Admin\SettingController::class);
    Route::resource('user', App\Http\Controllers\Admin\UserController::class);

    // Rute untuk menampilkan daftar konten berdasarkan tipe (profil, berita, artikel)
    Route::get('/content/{type}', [App\Http\Controllers\Admin\ContentController::class, 'index'])->name('admin.content.index');

    // Rute untuk menampilkan form tambah konten berdasarkan tipe
    Route::get('/content/{type}/create', [App\Http\Controllers\Admin\ContentController::class, 'create'])->name('admin.content.create');

    // Rute untuk menyimpan konten baru berdasarkan tipe
    Route::post('/content/{type}', [App\Http\Controllers\Admin\ContentController::class, 'store'])->name('admin.content.store');

    // Rute untuk menampilkan detail konten berdasarkan tipe dan id
    Route::get('/content/{type}/{id}', [App\Http\Controllers\Admin\ContentController::class, 'show'])->name('admin.content.show');

    // Rute untuk menampilkan form edit konten berdasarkan tipe dan id
    Route::get('/content/{type}/{id}/edit', [App\Http\Controllers\Admin\ContentController::class, 'edit'])->name('admin.content.edit');

    // Rute untuk memperbarui konten berdasarkan tipe dan id
    Route::put('/content/{type}/{id}', [App\Http\Controllers\Admin\ContentController::class, 'update'])->name('admin.content.update');

    // Rute untuk menghapus konten berdasarkan tipe dan id
    Route::delete('/content/{type}/{id}', [App\Http\Controllers\Admin\ContentController::class, 'destroy'])->name('admin.content.destroy');

});