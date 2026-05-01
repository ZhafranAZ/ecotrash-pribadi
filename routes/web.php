<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Auth logic will be wired here
    return back()->withErrors(['email' => 'Fitur login belum dikonfigurasi.']);
})->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    // Registration logic will be wired here
    return redirect()->route('setup-address');
})->name('register.post');

Route::get('/setup-address', function () {
    return view('auth.setup-address');
})->name('setup-address');

Route::post('/setup-address', function () {
    // Address setup logic will be wired here
    return redirect()->route('home');
})->name('setup-address.post');

// --- Warga Routes (Mockups) ---
Route::prefix('warga')->name('warga.')->group(function () {
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

// --- Admin Routes (Mockups) ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    })->name('laporan.index');

    Route::get('/operasional', function () {
        return view('admin.operasional.index');
    })->name('operasional.index');

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

// --- Petugas Routes (Mockups) ---
Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/beranda', function () {
        return view('petugas.beranda');
    })->name('beranda');

    Route::get('/komplek/{id}/warga', function ($id) {
        return view('petugas.komplek.warga', ['id' => $id]);
    })->name('komplek.warga');

    Route::get('/laporan/{id}', function ($id) {
        return view('petugas.laporan.detail', ['id' => $id]);
    })->name('laporan.detail');

    Route::get('/tugas/{type}/{id}', function ($type, $id) {
        return view('petugas.tugas.detail');
    })->name('tugas.detail');

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
