<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatKoin extends Model
{
    use HasFactory;

    protected $table = 'riwayat_koin';

    protected $fillable = [
        'warga_id',
        'tipe_transaksi',
        'jumlah',
        'sumber',
        'referensi_id',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime',
            'jumlah' => 'integer',
        ];
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'warga_id');
    }
}
