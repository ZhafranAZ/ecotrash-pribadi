<?php

namespace App\Services;

use App\Models\Notifikasi;

class NotificationService
{
    /**
     * Kirim notifikasi ke user tertentu.
     * Digunakan oleh modul lain (3, 4, 5, 6) sebagai "Tukang Pos" terpusat.
     *
     * @param int    $userId  ID user penerima notifikasi
     * @param string $judul   Judul notifikasi (cth: "Pesanan Selesai!")
     * @param string $pesan   Isi pesan notifikasi
     * @param string $tipe    Tipe notifikasi: 'info', 'warning', 'success', 'error'
     * @return Notifikasi
     */
    public static function send(int $userId, string $judul, string $pesan, string $tipe = 'info'): Notifikasi
    {
        return Notifikasi::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'tipe'    => $tipe,
            'is_read' => false,
        ]);
    }

    /**
     * Kirim notifikasi ke banyak user sekaligus.
     *
     * @param array  $userIds  Array ID user penerima
     * @param string $judul    Judul notifikasi
     * @param string $pesan    Isi pesan notifikasi
     * @param string $tipe     Tipe notifikasi
     * @return void
     */
    public static function sendToMany(array $userIds, string $judul, string $pesan, string $tipe = 'info'): void
    {
        $data = array_map(fn($userId) => [
            'user_id'    => $userId,
            'judul'      => $judul,
            'pesan'      => $pesan,
            'tipe'       => $tipe,
            'is_read'    => false,
            'created_at' => now(),
            'updated_at' => now(),
        ], $userIds);

        Notifikasi::insert($data);
    }
}
