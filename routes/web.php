<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KepsekController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| PUBLIC (tanpa login)
|--------------------------------------------------------------------------
*/

Route::get('/', [SiswaController::class, 'siswaDashboard'])->name('siswa.dashboard');


Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:siswa'])->group(function () {

    Route::post('/siswa/aspirasi', [SiswaController::class, 'storeAspirasi'])
        ->name('aspirasi.store');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {

    Route::get('/', [AdminController::class, 'dashboard']);

    Route::get('/siswa', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');

    Route::get('/kategori', [AdminController::class, 'kategori'])->name('kategori.dashboard');
    Route::post('/kategori', [AdminController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/kategori/{id}', [AdminController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('kategori.destroy');
    
    Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna.dashboard');
    Route::post('/pengguna', [AdminController::class, 'storePengguna'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [AdminController::class, 'updatePengguna'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [AdminController::class, 'destroyPengguna'])->name('pengguna.destroy');

    Route::get('/aspirasi', [AdminController::class, 'aspirasi'])->name('admin.aspirasi');
     Route::get('/aspirasi/{id}', [AdminController::class, 'showAspirasi'])
        ->name('admin.aspirasi.show');

    Route::put('/aspirasi/{id}', [AdminController::class, 'updateAspirasi'])
        ->name('admin.aspirasi.update');

    Route::delete('/aspirasi/{id}', [AdminController::class, 'destroyAspirasi'])
        ->name('admin.aspirasi.destroy');

    Route::post('/aspirasi/{id}/feedback', [AdminController::class, 'feedback'])
    ->name('admin.aspirasi.feedback');

    Route::get('/feedback', [AdminController::class, 'feedbackList'])
    ->name('admin.feedback');

    Route::get('/history', [AdminController::class,'history'])
    ->name('admin.history');

    Route::get('/laporan', [AdminController::class, 'laporan']);
    Route::get('/laporan/pdf', [AdminController::class, 'laporanPdf'])
    ->name('admin.laporan.pdf');

});


/*
|--------------------------------------------------------------------------
| KEPSEK
|--------------------------------------------------------------------------
*/

Route::prefix('kepsek')->middleware(['auth','role:kepsek'])->group(function () {
    Route::get('/', [KepsekController::class, 'dashboard'])->name('kepsek.dashboard');
    Route::get('/laporan', [KepsekController::class, 'laporan'])->name('kepsek.laporan');
    Route::get('/laporan/pdf', [KepsekController::class, 'laporanPdf'])->name('kepsek.laporan.pdf'); // 🔥
});




