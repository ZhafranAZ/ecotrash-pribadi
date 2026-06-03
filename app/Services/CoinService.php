<?php

namespace App\Services;

use App\Models\RiwayatKoin;
use App\Models\User;

class CoinService
{
    /**
     * Tambahkan koin ke saldo warga dan catat di riwayat_koin.
     */
    public function addCoins(User $user, int $amount, string $sumber, ?string $referensiId = null): RiwayatKoin
    {
        // Tambah saldo_koin di tabel users
        $user->increment('saldo_koin', $amount);

        // Catat di riwayat_koin
        return RiwayatKoin::create([
            'warga_id'        => $user->id,
            'tipe_transaksi'  => 'masuk',
            'jumlah'          => $amount,
            'sumber'          => $sumber,
            'referensi_id'    => $referensiId,
            'expired_at'      => now()->addMonths(6),
        ]);
    }
}
