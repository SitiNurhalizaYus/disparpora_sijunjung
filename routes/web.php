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
    
    Route::get('/profil{slug}', [App\Http\Controllers\Client\ProfilController::class, 'detail']);

    Route::get('/berita', [App\Http\Controllers\Client\BeritaController::class, 'index']);
    Route::get('/berita/{id_berita}', [App\Http\Controllers\Client\BeritaController::class, 'detail']);
    Route::get('/berita/{id_berita}', [App\Http\Controllers\Client\BeritaController::class, 'detailWithCategory']);
    
    Route::get('/artikel', [App\Http\Controllers\Client\ArtikelController::class, 'index']);
    Route::get('/artikel/{id_berita}', [App\Http\Controllers\Client\ArtikelController::class, 'detail']);
    Route::get('/artikel/{id_berita}', [App\Http\Controllers\Client\ArtikelController::class, 'detailWithCategory']);
    
    Route::get('/contact', [App\Http\Controllers\Client\ContactController::class, 'index']);
    Route::post('/contact/submit', [App\Http\Controllers\Client\ContactController::class, 'submit']);

     Route::get('/document', [\App\Http\Controllers\Client\DocumentController::class, 'index'])->name('client.document.index');
     Route::get('/lokawisata', [\App\Http\Controllers\Client\InfoTempatController::class, 'index'])->name('client.lokawisata.index');

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
     // Route untuk mengupdate profil
    Route::post('/admin/profile/{id}', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Resource routes
    Route::resource('poster', App\Http\Controllers\Admin\PosterController::class);
    Route::resource('bignumber', App\Http\Controllers\Admin\BigNumberController::class);
    Route::resource('team', App\Http\Controllers\Admin\TeamController::class);
    Route::resource('mitra', App\Http\Controllers\Admin\MitraController::class);
    Route::resource('profil', App\Http\Controllers\Admin\ProfilController::class);
    Route::resource('berita', App\Http\Controllers\Admin\BeritaController::class);
    Route::resource('artikel', App\Http\Controllers\Admin\ArtikelController::class);
    Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('document', App\Http\Controllers\Admin\DocumentController::class);
    Route::resource('galeri', App\Http\Controllers\Admin\DocumentController::class);
    Route::resource('lokawisata', App\Http\Controllers\Admin\InfoTempatController::class);
    Route::resource('agenda', App\Http\Controllers\Admin\AgendaController::class);
    Route::resource('setting', App\Http\Controllers\Admin\SettingController::class);
    Route::resource('user', App\Http\Controllers\Admin\UserController::class);
    Route::resource('messege', App\Http\Controllers\Admin\MessageController::class);

});