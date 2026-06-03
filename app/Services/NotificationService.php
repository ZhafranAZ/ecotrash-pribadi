<?php

namespace App\Services;

use App\Models\Notifikasi;

class NotificationService
{
    /**
     * Kirim notifikasi ke user tertentu.
     *
     * @param int    $userId ID user penerima notifikasi
     * @param string $judul  Judul notifikasi, misal "Pesanan Baru"
     * @param string $pesan  Isi pesan notifikasi
     * @param string $tipe   Tipe notifikasi: 'info', 'warning', 'success', 'error'. Default: 'info'
     */
    public static function send(int $userId, string $judul, string $pesan, string $tipe = 'info'): void
    {
        Notifikasi::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'tipe'    => $tipe,
            'is_read' => false,
        ]);
    }
}
