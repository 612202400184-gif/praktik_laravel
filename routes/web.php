<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect halaman depan ke daftar pegawai
Route::get('/', function () {
    return redirect('/pegawai');
});

// Route Autentikasi (Login, Logout, dll)
Auth::routes();

// Semua route di bawah ini harus Login (Auth)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/pegawai/cetak-pdf', [PegawaiController::class, 'cetakPdf'])->name('pegawai.cetak_pdf');

    // 1. AKSES SEMUA ROLE (Admin, Operator, Viewer)
    // Hanya boleh melihat daftar data
    Route::middleware(['role:admin,operator,viewer'])->group(function () {
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    });

    // 2. AKSES ADMIN & OPERATOR (Create & Edit)
    // Bisa menambah dan mengubah data, tapi tidak bisa menghapus
    Route::middleware(['role:admin,operator'])->group(function () {
        Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    });

    // 3. AKSES KHUSUS ADMIN (Delete)
    // Hanya Admin yang memiliki otoritas menghapus data
    Route::middleware(['role:admin'])->group(function () {
        Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    });
});