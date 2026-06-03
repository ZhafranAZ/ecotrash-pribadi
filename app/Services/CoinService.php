<?php

namespace App\Services;

use App\Models\RiwayatKoin;
use App\Models\User;

class CoinService
{
    /**
     * Potong saldo koin dari user Warga dan catat ke riwayat_koin.
     *
     * Catatan: Method ini TIDAK melakukan validasi apakah saldo cukup.
     * Validasi menjadi tanggung jawab pemanggil (Controller).
     *
     * @param User   $user        Instance user Warga yang sedang login
     * @param int    $amount      Jumlah koin yang dipotong
     * @param string $description Keterangan sumber pemotongan, misal "Diskon pesanan #123"
     */
    public static function deductCoins(User $user, int $amount, string $description): void
    {
        // 1. Kurangi saldo koin user
        $user->saldo_koin -= $amount;
        $user->save();

        // 2. Catat riwayat koin keluar
        RiwayatKoin::create([
            'warga_id'       => $user->id,
            'tipe_transaksi' => 'keluar',
            'jumlah'         => $amount,
            'sumber'         => 'penukaran',
            'referensi_id'   => $description,
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
