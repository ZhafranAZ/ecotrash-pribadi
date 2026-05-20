<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komplek extends Model
{
    use HasFactory;

    protected $table = 'komplek';

    protected $fillable = [
        'nama_komplek',
        'lat',
        'lng',
    ];

    protected function casts(): array
    {
        return [
            'lat' => 'decimal:7',
            'lng' => 'decimal:7',
        ];
    }

    public function alamatWarga(): HasMany
    {
        return $this->hasMany(AlamatWarga::class);
    }

    public function petugasUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'petugas_komplek', 'komplek_id', 'petugas_id')
                    ->withPivot('created_at');
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(PesananPengangkutan::class);
    }

    public function laporanSampahLiar(): HasMany
    {
        return $this->hasMany(LaporanSampahLiar::class);
    }
}
