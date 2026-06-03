<?php

namespace App\Services;

use App\Models\Notifikasi;

class NotificationService
{
    /**
     * Kirim notifikasi ke user tertentu.
     *
     * @param int    $userId ID user penerima
     * @param string $judul  Judul notifikasi
     * @param string $pesan  Isi pesan notifikasi
     * @param string $tipe   Tipe notifikasi: 'info', 'warning', 'success', 'error'
     */
    public static function send(int $userId, string $judul, string $pesan, string $tipe = 'info'): void
    {
        Notifikasi::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'tipe'    => $tipe,
        ]);
    }
}
