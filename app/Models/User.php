<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama', 'email', 'no_telepon', 'password', 'role',
        'saldo_koin', 'foto_profil', 'status_kehadiran', 'alasan_berhalangan',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'saldo_koin' => 'integer',
        ];
    }

    // === Role Helpers ===
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isWarga(): bool { return $this->role === 'warga'; }
    public function isPetugas(): bool { return $this->role === 'petugas'; }

    public function hasSetupAddress(): bool
    {
        return $this->alamatWarga()->exists();
    }

    // === Relationships ===
    public function alamatWarga(): HasMany
    {
        return $this->hasMany(AlamatWarga::class, 'warga_id');
    }

    public function petugasKomplek(): BelongsToMany
    {
        return $this->belongsToMany(Komplek::class, 'petugas_komplek', 'petugas_id', 'komplek_id')
                    ->withPivot('created_at');
    }

    public function pesananSebagaiWarga(): HasMany
    {
        return $this->hasMany(PesananPengangkutan::class, 'warga_id');
    }

    public function pesananSebagaiPetugas(): HasMany
    {
        return $this->hasMany(PesananPengangkutan::class, 'petugas_id');
    }

    public function laporanSebagaiWarga(): HasMany
    {
        return $this->hasMany(LaporanSampahLiar::class, 'warga_id');
    }

    public function laporanSebagaiPetugas(): HasMany
    {
        return $this->hasMany(LaporanSampahLiar::class, 'petugas_id');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    public function bookmarkArtikel(): BelongsToMany
    {
        return $this->belongsToMany(ArtikelEdukasi::class, 'bookmark_artikel', 'warga_id', 'artikel_id')
                    ->withPivot('created_at');
    }

    public function riwayatKoin(): HasMany
    {
        return $this->hasMany(RiwayatKoin::class, 'warga_id');
    }
}
