<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PesananPengangkutan extends Model
{
    use HasFactory;

    protected $table = 'pesanan_pengangkutan';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'warga_id',
        'komplek_id',
        'nama_alamat_snapshot',
        'blok_nomor_rumah',
        'detail_patokan_snapshot',
        'kategori_sampah',
        'tanggal_penjemputan',
        'nama_hari_penjemputan',
        'catatan_warga',
        'koin_digunakan',
        'koin_didapat',
        'harga_awal',
        'total_harga_akhir',
        'selisih_harga',
        'status',
        'status_pembayaran',
        'metode_pembayaran',
        'payment_reference',
        'petugas_id',
        'ukuran_aktual_laporan_petugas',
        'alasan_kendala',
        'foto_kendala',
        'foto_bukti_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_penjemputan' => 'date',
            'koin_digunakan' => 'integer',
            'koin_didapat' => 'integer',
            'harga_awal' => 'integer',
            'total_harga_akhir' => 'integer',
            'selisih_harga' => 'integer',
        ];
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'warga_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function komplek(): BelongsTo
    {
        return $this->belongsTo(Komplek::class);
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatusPesanan::class, 'pesanan_id');
    }
}
