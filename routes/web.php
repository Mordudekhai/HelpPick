<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KriteriaController;

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
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Alternatif
    |--------------------------------------------------------------------------
    */
    Route::resource('/alternatif', AlternatifController::class);

    /*
    |--------------------------------------------------------------------------
    | Kriteria (DITAMBAHKAN - TANPA MENGGANGGU SISTEM)
    |--------------------------------------------------------------------------
    */
    Route::resource('/kriteria', KriteriaController::class);

    /*
    |--------------------------------------------------------------------------
    | Penilaian
    |--------------------------------------------------------------------------
    */
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');

});

/*
|--------------------------------------------------------------------------
| SAW (OPTIONAL / DEBUG)
|--------------------------------------------------------------------------
*/
Route::get('/hasil', [SawController::class, 'index'])->name('hasil.index');