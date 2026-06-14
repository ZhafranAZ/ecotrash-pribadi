<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSistem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /**
     * Update pricing and coin configuration.
     */
    public function updateHarga(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'konversi_koin_rupiah' => ['required', 'integer', 'min:0'],
            'harga_kategori_kecil' => ['required', 'integer', 'min:0'],
            'harga_kategori_sedang' => ['required', 'integer', 'min:0'],
            'harga_kategori_besar' => ['required', 'integer', 'min:0'],
            'bonus_koin_kecil' => ['required', 'integer', 'min:0'],
            'bonus_koin_sedang' => ['required', 'integer', 'min:0'],
            'bonus_koin_besar' => ['required', 'integer', 'min:0'],
        ]);

        $pengaturan = PengaturanSistem::first() ?? new PengaturanSistem();
        $pengaturan->fill($validated)->save();

        return redirect()->back()
            ->with('success', 'Pengaturan harga & koin berhasil diperbarui.')
            ->with('active_tab', 'harga');
    }

    /**
     * Update schedule and quota configuration.
     */
    public function updateJadwal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hari_operasional' => ['required', 'array'],
            'hari_operasional.*' => ['string', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'batas_waktu_pesan' => ['required', 'string'],
            'kuota_pesanan_harian' => ['required', 'integer', 'min:1'],
        ]);

        $pengaturan = PengaturanSistem::first() ?? new PengaturanSistem();
        $pengaturan->fill($validated)->save();

        return redirect()->back()
            ->with('success', 'Pengaturan jadwal & kuota berhasil diperbarui.')
            ->with('active_tab', 'jadwal');
    }
}
