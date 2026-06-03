<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatStatusPesanan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status_pesanan';

    const UPDATED_AT = null;

    protected $fillable = [
        'pesanan_id',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(PesananPengangkutan::class, 'pesanan_id');
    }
}
