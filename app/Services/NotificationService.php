<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\User;

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
    public static function send(mixed $user, string $judul, string $pesan, string $tipe = 'info'): Notifikasi
    {
        $userId = $user instanceof User ? $user->id : $user;

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
