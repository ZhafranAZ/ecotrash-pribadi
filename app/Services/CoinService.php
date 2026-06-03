<?php

namespace App\Services;

use App\Models\RiwayatKoin;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoinService
{
    /**
     * Menambahkan koin ke saldo warga.
     *
     * @param int         $wargaId     ID user warga
     * @param int         $jumlah      Nominal koin yang ditambahkan
     * @param string      $sumber      Sumber koin: 'pesanan', 'laporan_liar', 'penukaran', 'sistem'
     * @param string|null $referensiId ID referensi (pesanan/laporan terkait)
     * @return RiwayatKoin Record riwayat yang dibuat
     */
    public function addCoins(int $wargaId, int $jumlah, string $sumber, ?string $referensiId = null): RiwayatKoin
    {
        return DB::transaction(function () use ($wargaId, $jumlah, $sumber, $referensiId) {
            // Increment saldo_koin di tabel users
            User::where('id', $wargaId)->increment('saldo_koin', $jumlah);

            // Insert record riwayat_koin
            return RiwayatKoin::create([
                'warga_id'        => $wargaId,
                'tipe_transaksi'  => 'masuk',
                'jumlah'          => $jumlah,
                'sumber'          => $sumber,
                'referensi_id'    => $referensiId,
                'expired_at'      => now()->addMonths(6),
                'is_processed'    => false,
            ]);
        });
    }

    /**
     * Mengurangi koin dari saldo warga.
     *
     * @param int         $wargaId     ID user warga
     * @param int         $jumlah      Nominal koin yang dikurangi
     * @param string      $sumber      Sumber pengurangan: 'pesanan', 'laporan_liar', 'penukaran', 'sistem'
     * @param string|null $referensiId ID referensi (pesanan/laporan terkait)
     * @return RiwayatKoin Record riwayat yang dibuat
     *
     * @throws \Exception Jika saldo koin tidak mencukupi
     */
    public function deductCoins(int $wargaId, int $jumlah, string $sumber, ?string $referensiId = null): RiwayatKoin
    {
        return DB::transaction(function () use ($wargaId, $jumlah, $sumber, $referensiId) {
            // Ambil user dengan pessimistic lock untuk mencegah race condition
            $user = User::lockForUpdate()->findOrFail($wargaId);

            // Validasi saldo mencukupi
            if ($user->saldo_koin < $jumlah) {
                throw new \Exception("Saldo koin tidak mencukupi. Saldo saat ini: {$user->saldo_koin}, dibutuhkan: {$jumlah}");
            }

            // Decrement saldo_koin
            $user->decrement('saldo_koin', $jumlah);

            // Insert record riwayat_koin
            return RiwayatKoin::create([
                'warga_id'        => $wargaId,
                'tipe_transaksi'  => 'keluar',
                'jumlah'          => $jumlah,
                'sumber'          => $sumber,
                'referensi_id'    => $referensiId,
                'is_processed'    => true, // keluar langsung dianggap processed
            ]);
        });
    }

    /**
     * Memproses koin yang sudah melewati masa berlaku (expired).
     * Menggunakan pendekatan FIFO — hanya memproses record 'masuk'
     * yang is_processed = false dan expired_at sudah lewat.
     *
     * @return int Jumlah record yang di-expire
     */
    public function expireCoins(): int
    {
        $expiredRecords = RiwayatKoin::where('tipe_transaksi', 'masuk')
            ->where('is_processed', false)
            ->where('expired_at', '<=', now())
            ->orderBy('expired_at', 'asc') // FIFO: yang paling lama dulu
            ->get();

        $totalProcessed = 0;

        // Kelompokkan per warga untuk efisiensi transaksi
        $groupedByWarga = $expiredRecords->groupBy('warga_id');

        foreach ($groupedByWarga as $wargaId => $records) {
            DB::transaction(function () use ($wargaId, $records, &$totalProcessed) {
                $user = User::lockForUpdate()->find($wargaId);

                if (!$user) {
                    return;
                }

                foreach ($records as $record) {
                    // Hitung jumlah yang benar-benar bisa dipotong (saldo minimum 0)
                    $jumlahExpire = min($record->jumlah, $user->saldo_koin);

                    if ($jumlahExpire > 0) {
                        // Kurangi saldo warga
                        $user->decrement('saldo_koin', $jumlahExpire);
                        $user->refresh();

                        // Buat record expired
                        RiwayatKoin::create([
                            'warga_id'        => $wargaId,
                            'tipe_transaksi'  => 'expired',
                            'jumlah'          => $jumlahExpire,
                            'sumber'          => 'sistem',
                            'referensi_id'    => (string) $record->id,
                            'is_processed'    => true,
                        ]);
                    }

                    // Tandai record asal sebagai sudah diproses
                    $record->update(['is_processed' => true]);
                    $totalProcessed++;
                }
            });
        }

        Log::info("CoinService: Berhasil memproses {$totalProcessed} record koin expired.");

        return $totalProcessed;
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
