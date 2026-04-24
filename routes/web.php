<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KriteriaParameterController;
use App\Http\Controllers\MappingController; 
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/
Route::get('/customer', [CustomerController::class, 'form'])->name('customer.form');
Route::post('/customer/hitung', [CustomerController::class, 'hitung'])->name('customer.hitung');

/*
|--------------------------------------------------------------------------
| AUTH ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard (🔥 FIX DI SINI)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Alternatif
    |--------------------------------------------------------------------------
    */
    Route::resource('/alternatif', AlternatifController::class);

    /*
    |--------------------------------------------------------------------------
    | Kriteria
    |--------------------------------------------------------------------------
    */
    Route::resource('/kriteria', KriteriaController::class);

    /*
    |--------------------------------------------------------------------------
    | PARAMETER KRITERIA
    |--------------------------------------------------------------------------
    */
    Route::get('/kriteria/{id}/parameter', [KriteriaParameterController::class, 'index'])
        ->name('kriteria.parameter');

    Route::post('/kriteria/{id}/parameter', [KriteriaParameterController::class, 'store'])
        ->name('kriteria.parameter.store');

    Route::delete('/kriteria-parameter/{id}', [KriteriaParameterController::class, 'destroy'])
        ->name('kriteria.parameter.delete');

    /*
    |--------------------------------------------------------------------------
    | 🔥 MAPPING PARAMETER → ALTERNATIF
    |--------------------------------------------------------------------------
    */
    Route::get('/mapping', [MappingController::class, 'index'])
        ->name('mapping.index');

    Route::post('/mapping', [MappingController::class, 'store'])
        ->name('mapping.store');

    /*
    |--------------------------------------------------------------------------
    | Penilaian (OPSIONAL)
    |--------------------------------------------------------------------------
    */
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
});

/*
|--------------------------------------------------------------------------
| SAW (OPTIONAL)
|--------------------------------------------------------------------------
*/
Route::get('/hasil', [SawController::class, 'index'])->name('hasil.index');