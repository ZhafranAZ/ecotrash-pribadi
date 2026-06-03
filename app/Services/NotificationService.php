<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\User;

class NotificationService
{
    /**
     * Kirim notifikasi ke user (simpan ke tabel notifikasi).
     */
    public function send(User $user, string $judul, string $pesan, string $tipe = 'info'): Notifikasi
    {
        return Notifikasi::create([
            'user_id'  => $user->id,
            'judul'    => $judul,
            'pesan'    => $pesan,
            'tipe'     => $tipe,
            'is_read'  => false,
        ]);
    }
}
