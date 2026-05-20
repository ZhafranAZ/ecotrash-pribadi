<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlamatWarga extends Model
{
    use HasFactory;

    protected $table = 'alamat_warga';

    protected $fillable = [
        'warga_id',
        'komplek_id',
        'nama_alamat',
        'blok_nomor_rumah',
        'detail_patokan',
        'is_utama',
    ];

    protected function casts(): array
    {
        return [
            'is_utama' => 'boolean',
        ];
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'warga_id');
    }

    public function komplek(): BelongsTo
    {
        return $this->belongsTo(Komplek::class);
    }
}
