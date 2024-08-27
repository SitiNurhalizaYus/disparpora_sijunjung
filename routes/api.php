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

Route::get('login', App\Http\Controllers\Api\LoginController::class); 
Route::apiResource('big_number', App\Http\Controllers\Api\BigNumberController::class); 
Route::apiResource('content', App\Http\Controllers\Api\ContentController::class);
Route::apiResource('profil', App\Http\Controllers\Api\ProfilController::class);
Route::apiResource('berita', App\Http\Controllers\Api\BeritaController::class);
Route::apiResource('artikel', App\Http\Controllers\Api\ArtikelController::class);
Route::apiResource('document', App\Http\Controllers\Api\DocumentController::class); 

Route::apiResource('category', App\Http\Controllers\Api\CategoryController::class); 

Route::apiResource('event', App\Http\Controllers\Api\EventController::class); 
// Route::apiResource('pesan', App\Http\Controllers\Api\PesanController::class);//api untuk pesan

Route::apiResource('agent', App\Http\Controllers\Api\AgentController::class); //api untuk agent
// Route::apiResource('info_tempat', App\Http\Controllers\Api\TempatController::class);//api untuk tempat

Route::apiResource('upload', App\Http\Controllers\Api\UploadController::class);
Route::apiResource('user', App\Http\Controllers\Api\UserController::class);
Route::apiResource('user_level', App\Http\Controllers\Api\userLevelController::class);
Route::apiResource('setting', App\Http\Controllers\Api\SettingController::class);

Route::apiResource('mitra', App\Http\Controllers\Api\MitraController::class);
Route::apiResource('poster', App\Http\Controllers\Api\PosterController::class);
Route::apiResource('team', App\Http\Controllers\Api\TeamController::class);
Route::apiResource('testimony', App\Http\Controllers\Api\TestimonyController::class);

// Route::get('/categori_id', [App\Http\Controllers\Api\ContentController::class, 'getCategories']);

Route::get('dashboard/top-page', [App\Http\Controllers\Api\DashboardController::class, 'topPage']);
Route::get('dashboard/top-device', [App\Http\Controllers\Api\DashboardController::class, 'topDevice']);
Route::get('dashboard/top-os', [App\Http\Controllers\Api\DashboardController::class, 'topOs']);
Route::get('dashboard/top-browser', [App\Http\Controllers\Api\DashboardController::class, 'topBrowser']);
Route::get('dashboard/top-country', [App\Http\Controllers\Api\DashboardController::class, 'topCountry']);
Route::get('dashboard/top-city', [App\Http\Controllers\Api\DashboardController::class, 'topCity']);
Route::get('dashboard/access-daily', [App\Http\Controllers\Api\DashboardController::class, 'accessDaily']);
Route::get('dashboard/access-monthly', [App\Http\Controllers\Api\DashboardController::class, 'accessMonthly']);
// });
