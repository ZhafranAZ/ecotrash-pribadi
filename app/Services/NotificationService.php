<?php

namespace App\Services;

use App\Models\Notifikasi;

class NotificationService
{
    /**
     * Kirim notifikasi ke user.
     *
     * @param int    $userId ID user penerima notifikasi
     * @param string $judul  Judul notifikasi
     * @param string $pesan  Isi pesan notifikasi
     * @param string $tipe   Tipe notifikasi: 'info', 'warning', 'success', 'error'
     * @return Notifikasi Record notifikasi yang dibuat
     */
    public function send(int $userId, string $judul, string $pesan, string $tipe = 'info'): Notifikasi
    {
        // Validasi tipe notifikasi
        $allowedTypes = ['info', 'warning', 'success', 'error'];
        if (!in_array($tipe, $allowedTypes)) {
            $tipe = 'info';
        }

        return Notifikasi::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'tipe'    => $tipe,
            'is_read' => false,
        ]);
    }
}
