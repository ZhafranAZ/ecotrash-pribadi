<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_sistem';

    protected $fillable = [
        'konversi_koin_rupiah',
        'harga_kategori_kecil',
        'harga_kategori_sedang',
        'harga_kategori_besar',
        'bonus_koin_kecil',
        'bonus_koin_sedang',
        'bonus_koin_besar',
        'batas_waktu_pesan',
        'kuota_pesanan_harian',
        'hari_operasional',
    ];

    protected function casts(): array
    {
        return [
            'hari_operasional' => 'array',
            'konversi_koin_rupiah' => 'integer',
            'harga_kategori_kecil' => 'integer',
            'harga_kategori_sedang' => 'integer',
            'harga_kategori_besar' => 'integer',
            'bonus_koin_kecil' => 'integer',
            'bonus_koin_sedang' => 'integer',
            'bonus_koin_besar' => 'integer',
            'kuota_pesanan_harian' => 'integer',
        ];
    }
}
