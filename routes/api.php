<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Route::middleware([\App\Http\Middleware\AutoCreateLogs::class])->group(function () {
    Route::post('login', App\Http\Controllers\Api\LoginController::class);

    Route::apiResource('big_number', App\Http\Controllers\Api\BigNumberController::class);
    Route::apiResource('blog', App\Http\Controllers\Api\BlogController::class);
    Route::apiResource('faq', App\Http\Controllers\Api\FaqController::class);
    Route::apiResource('feature', App\Http\Controllers\Api\FeatureController::class);
    Route::apiResource('review', App\Http\Controllers\Api\ReviewController::class);
    Route::apiResource('page', App\Http\Controllers\Api\PageController::class);

    Route::apiResource('kategori', App\Http\Controllers\Api\KategoriController::class);//api untuk kategori
    Route::apiResource('konten', App\Http\Controllers\Api\KontenController::class);//api untuk postingan
    Route::apiResource('label', App\Http\Controllers\Api\LabelController::class);//api untuk label
    Route::apiResource('arsip', App\Http\Controllers\Api\ArsipController::class);//api untuk arsip
    Route::apiResource('comment', App\Http\Controllers\Api\CommentController::class);//api untuk comment
    Route::apiResource('event', App\Http\Controllers\Api\EventController::class);//api untuk event
    Route::apiResource('pesan', App\Http\Controllers\Api\PesanController::class);//api untuk pesan
    
    Route::apiResource('agent', App\Http\Controllers\Api\AgentController::class);//api untuk agent
    Route::apiResource('info_tempat', App\Http\Controllers\Api\TempatController::class);//api untuk tempat

    Route::apiResource('upload', App\Http\Controllers\Api\UploadController::class);
    Route::apiResource('user', App\Http\Controllers\Api\UserController::class);
    Route::apiResource('role', App\Http\Controllers\Api\RoleController::class);
    Route::apiResource('setting', App\Http\Controllers\Api\SettingController::class);

    Route::apiResource('partner', App\Http\Controllers\Api\PartnerController::class);
    Route::apiResource('pricing', App\Http\Controllers\Api\PricingController::class);
    Route::apiResource('slider', App\Http\Controllers\Api\SliderController::class);
    Route::apiResource('team', App\Http\Controllers\Api\TeamController::class);
    Route::apiResource('testimony', App\Http\Controllers\Api\TestimonyController::class);

    // Rute untuk mendapatkan all data
    Route::get('/user_all', [App\Http\Controllers\Api\UserController::class, 'getAllData']);
    Route::get('/konten_all', [App\Http\Controllers\Api\KontenController::class, 'getAllData']);
    // Rute untuk mendapatkan data kategori dropdown dari tabel berelasi
    Route::get('/kategori_id', [App\Http\Controllers\Api\KontenController::class, 'getKategori']);

    Route::get('dashboard/top-page', [App\Http\Controllers\Api\DashboardController::class, 'topPage']);
    Route::get('dashboard/top-device', [App\Http\Controllers\Api\DashboardController::class, 'topDevice']);
    Route::get('dashboard/top-os', [App\Http\Controllers\Api\DashboardController::class, 'topOs']);
    Route::get('dashboard/top-browser', [App\Http\Controllers\Api\DashboardController::class, 'topBrowser']);
    Route::get('dashboard/top-country', [App\Http\Controllers\Api\DashboardController::class, 'topCountry']);
    Route::get('dashboard/top-city', [App\Http\Controllers\Api\DashboardController::class, 'topCity']);
    Route::get('dashboard/access-daily', [App\Http\Controllers\Api\DashboardController::class, 'accessDaily']);
    Route::get('dashboard/access-monthly', [App\Http\Controllers\Api\DashboardController::class, 'accessMonthly']);
// });

