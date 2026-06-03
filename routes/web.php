<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Warga\ProfilController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\KomplekController;
use App\Http\Controllers\Warga\PesananController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\AktivitasController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

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

    // --- Notifikasi (Global, semua role yang login) ---
    Route::post('/notifikasi/mark-all-as-read', [NotifikasiController::class, 'markAllAsRead'])
        ->name('notifikasi.markAllRead');
});

// --- Warga Routes ---
Route::prefix('warga')->name('warga.')->middleware(['auth', 'role:warga', 'address.setup'])->group(function () {
    Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
    Route::post('/pesanan/{id}/bayar-selisih', [WargaDashboardController::class, 'bayarSelisih'])->name('pesanan.bayar_selisih');

    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');

    Route::get('/edukasi', [App\Http\Controllers\Warga\EdukasiWargaController::class, 'index'])->name('edukasi.index');
    Route::get('/edukasi/tersimpan', [App\Http\Controllers\Warga\EdukasiWargaController::class, 'tersimpan'])->name('edukasi.tersimpan');
    Route::get('/edukasi/{id}', [App\Http\Controllers\Warga\EdukasiWargaController::class, 'show'])->name('edukasi.show');
    Route::post('/edukasi/{id}/bookmark', [App\Http\Controllers\Warga\EdukasiWargaController::class, 'toggleBookmark'])->name('edukasi.bookmark');

    // Profil & Alamat (MODUL 2)
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/update', [ProfilController::class, 'updateProfile'])->name('profil.update');
    Route::post('/profil/alamat', [ProfilController::class, 'storeAlamat'])->name('profil.alamat.store');
    Route::put('/profil/alamat/{id}', [ProfilController::class, 'updateAlamat'])->name('profil.alamat.update');
    Route::put('/profil/alamat/{id}/utama', [ProfilController::class, 'setAlamatUtama'])->name('profil.alamat.utama');
    Route::delete('/profil/alamat/{id}', [ProfilController::class, 'destroyAlamat'])->name('profil.alamat.destroy');

    // Pesan
    Route::get('/pesan/create', [PesananController::class, 'create'])->name('pesan.create');
    Route::post('/pesan/checkout', [PesananController::class, 'store'])->name('pesan.checkout');
    Route::get('/pesan/berhasil/{id}', [PesananController::class, 'success'])->name('pesan.berhasil');

    // Lapor
    Route::get('/lapor/create', [LaporanController::class, 'create'])->name('lapor.create');
    Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');
    Route::get('/lapor/berhasil', [LaporanController::class, 'berhasil'])->name('lapor.berhasil');

    Route::get('/bantuan', function () {
        return view('warga.bantuan');
    })->name('bantuan');
});

Route::get('/home', function () {
    return redirect()->route('warga.dashboard');
})->name('home');

// --- Admin Routes ---
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/laporan', [LaporanLiarController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/{id}/approve', [LaporanLiarController::class, 'approve'])->name('laporan.approve');
    Route::post('/laporan/{id}/reject', [LaporanLiarController::class, 'reject'])->name('laporan.reject');
    Route::post('/laporan/{id}/duplicate', [LaporanLiarController::class, 'markDuplicate'])->name('laporan.duplicate');

    Route::get('/operasional', [OperasionalController::class, 'index'])->name('operasional.index');
    Route::post('/operasional/assign-petugas', [OperasionalController::class, 'assignPetugas'])->name('operasional.assignPetugas');

    // Pengguna (MODUL 2)
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna/petugas', [PenggunaController::class, 'storePetugas'])->name('pengguna.petugas.store');
    Route::put('/pengguna/petugas/{id}', [PenggunaController::class, 'updatePetugas'])->name('pengguna.petugas.update');
    Route::delete('/pengguna/petugas/{id}', [PenggunaController::class, 'destroyPetugas'])->name('pengguna.petugas.destroy');

    Route::resource('edukasi', App\Http\Controllers\Admin\EdukasiController::class);

    // Pengaturan Komplek (MODUL 2)
    Route::get('/pengaturan', [KomplekController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/komplek', [KomplekController::class, 'store'])->name('pengaturan.komplek.store');
    Route::put('/pengaturan/komplek/{id}', [KomplekController::class, 'update'])->name('pengaturan.komplek.update');
    Route::delete('/pengaturan/komplek/{id}', [KomplekController::class, 'destroy'])->name('pengaturan.komplek.destroy');

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
