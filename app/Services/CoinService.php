<?php

namespace App\Services;

use App\Models\User;
use App\Models\RiwayatKoin;

class CoinService
{
    /**
     * Tambahkan koin ke saldo warga dan catat riwayatnya.
     *
     * @param int    $wargaId     ID user warga
     * @param int    $jumlah      Jumlah koin yang ditambahkan
     * @param string $referensiId ID pesanan sebagai referensi
     */
    public static function addCoins(int $wargaId, int $jumlah, string $referensiId): void
    {
        // Tambah saldo_koin di tabel users
        User::where('id', $wargaId)->increment('saldo_koin', $jumlah);

        // Catat ke riwayat_koin
        RiwayatKoin::create([
            'warga_id'       => $wargaId,
            'tipe_transaksi' => 'masuk',
            'jumlah'         => $jumlah,
            'sumber'         => 'pesanan',
            'referensi_id'   => $referensiId,
        ]);
    }
}
