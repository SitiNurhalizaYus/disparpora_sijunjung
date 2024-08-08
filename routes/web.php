<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/blog', [App\Http\Controllers\Client\BlogController::class, 'index']);
    Route::get('/blog/detail/{id}', [App\Http\Controllers\Client\BlogController::class, 'detail']);
    Route::get('/faq', [App\Http\Controllers\Client\FaqController::class, 'index']);
    Route::get('/contact', [App\Http\Controllers\Client\ContactController::class, 'index']);
    Route::post('/contact/submit', [App\Http\Controllers\Client\ContactController::class, 'submit']);
    Route::get('/page/{id}', [App\Http\Controllers\Client\PageController::class, 'detail']);
    Route::get('/profil/{slug}', [App\Http\Controllers\Client\ProfilController::class, 'detail'])->name('profil');
    Route::get('/informasi', [App\Http\Controllers\Client\InformasiController::class, 'index'])->name('informasi.index');
    Route::get('/informasi/{slug}', [App\Http\Controllers\Client\InformasiController::class, 'detail'])->name('informasi.detail');
    Route::post('/comments', [App\Http\Controllers\Client\CommentController::class, 'store'])->name('comments.store');
});

Route::group(['prefix' => 'admin', 'middleware' => [\App\Http\Middleware\AutoCreateLogs::class]], function() {
    Route::get('/',[App\Http\Controllers\Admin\AuthController::class, 'index']);

    Route::get('login',[App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('auth',[App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('auth/login',[App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('auth/action_login',[App\Http\Controllers\Admin\AuthController::class, 'action_login']);
    Route::get('auth/logout',[App\Http\Controllers\Admin\AuthController::class, 'logout']);
    Route::get('auth/forgot',[App\Http\Controllers\Admin\AuthController::class, 'forgot']);
    Route::get('auth/error',[App\Http\Controllers\Admin\AuthController::class, 'error'])->name('admin.error');

    Route::get('akun',[App\Http\Controllers\Admin\AkunController::class, 'index']);
    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('slider', App\Http\Controllers\Admin\SliderController::class);
    Route::resource('bignumber', App\Http\Controllers\Admin\BigNumberController::class);
    Route::resource('team', App\Http\Controllers\Admin\TeamController::class);
    Route::resource('partner', App\Http\Controllers\Admin\PartnerController::class);
    Route::resource('testimony', App\Http\Controllers\Admin\TestimonyController::class);
    Route::resource('pages', App\Http\Controllers\Admin\PagesController::class);
    Route::resource('feature', App\Http\Controllers\Admin\FeatureController::class);
    Route::resource('pricing', App\Http\Controllers\Admin\PricingController::class);
    Route::resource('blog', App\Http\Controllers\Admin\BlogController::class);
    Route::resource('faq', App\Http\Controllers\Admin\FaqController::class);
    Route::resource('review', App\Http\Controllers\Admin\ReviewController::class);
    Route::resource('setting', App\Http\Controllers\Admin\SettingController::class);
    Route::resource('user', App\Http\Controllers\Admin\UserController::class);
});
