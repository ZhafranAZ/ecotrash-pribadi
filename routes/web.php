<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Petugas\TugasController;
use App\Http\Controllers\Admin\OperasionalController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// --- Guest Auth Routes ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.post');
});

// --- Authenticated Routes ---
Route::middleware('auth')->group(function () {
    Route::get('/setup-address', [RegisteredUserController::class, 'showSetupAddress'])->name('setup-address');
    Route::post('/setup-address', [RegisteredUserController::class, 'storeAddress'])->name('setup-address.post');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// --- Warga Routes ---
Route::prefix('warga')->name('warga.')->middleware(['auth', 'role:warga', 'address.setup'])->group(function () {
    Route::get('/dashboard', function () {
        return view('warga.dashboard');
    })->name('dashboard');

    Route::get('/aktivitas', function () {
        return view('warga.aktivitas.index');
    })->name('aktivitas.index');

    Route::get('/edukasi', function () {
        return view('warga.edukasi.index');
    })->name('edukasi.index');

    Route::get('/edukasi/tersimpan', function () {
        return view('warga.edukasi.tersimpan');
    })->name('edukasi.tersimpan');

    Route::get('/edukasi/{id}', function ($id) {
        return view('warga.edukasi.show', compact('id'));
    })->name('edukasi.show');

    Route::get('/profil', function () {
        return view('warga.profil.index');
    })->name('profil.index');

    // Pesan
    Route::get('/pesan/create', function () {
        return view('warga.pesan.create');
    })->name('pesan.create');

    Route::get('/pesan/berhasil', function () {
        return view('warga.pesan.berhasil');
    })->name('pesan.berhasil');

    // Lapor
    Route::get('/lapor/create', function () {
        return view('warga.lapor.create');
    })->name('lapor.create');

    Route::get('/lapor/berhasil', function () {
        return view('warga.lapor.berhasil');
    })->name('lapor.berhasil');

    Route::get('/bantuan', function () {
        return view('warga.bantuan');
    })->name('bantuan');
});

Route::get('/home', function () {
    return redirect()->route('warga.dashboard');
})->name('home');

// --- Admin Routes ---
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    })->name('laporan.index');

    Route::get('/operasional', [OperasionalController::class, 'index'])->name('operasional.index');
    Route::post('/operasional/assign-petugas', [OperasionalController::class, 'assignPetugas'])->name('operasional.assignPetugas');

    Route::get('/pengguna', function () {
        return view('admin.pengguna.index');
    })->name('pengguna.index');

    Route::get('/edukasi', function () {
        return view('admin.edukasi.index');
    })->name('edukasi.index');

    Route::get('/edukasi/create', function () {
        return view('admin.edukasi.create');
    })->name('edukasi.create');

    Route::get('/pengaturan', function () {
        return view('admin.pengaturan.index');
    })->name('pengaturan.index');

    Route::get('/profil', function () {
        return view('admin.profil.index');
    })->name('profil.index');

    Route::get('/notifikasi', function () {
        return view('admin.notifikasi.index');
    })->name('notifikasi.index');
});

// --- Petugas Routes ---
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/beranda', [TugasController::class, 'index'])->name('beranda');

    Route::get('/komplek/{id}/warga', [TugasController::class, 'showKomplekWarga'])->name('komplek.warga');

    Route::get('/laporan/{id}', function ($id) {
        return view('petugas.laporan.detail', ['id' => $id]);
    })->name('laporan.detail');

    Route::get('/tugas/{type}/{id}', [TugasController::class, 'showDetail'])->name('tugas.detail');

    // API routes untuk Axios (update status & lapor kendala)
    Route::post('/tugas/{id}/status', [TugasController::class, 'updateStatus'])->name('tugas.updateStatus');
    Route::post('/tugas/{id}/kendala', [TugasController::class, 'reportKendala'])->name('tugas.reportKendala');

    Route::get('/riwayat', function () {
        return view('petugas.riwayat');
    })->name('riwayat');

    Route::get('/riwayat/{id}', function ($id) {
        return view('petugas.riwayat-detail', ['id' => $id]);
    })->name('riwayat.detail');

    Route::get('/profil', function () {
        return view('petugas.profil');
    })->name('profil');
});
