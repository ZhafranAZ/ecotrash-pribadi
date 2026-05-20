<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArtikelEdukasi extends Model
{
    use HasFactory;

    protected $table = 'artikel_edukasi';

    protected $fillable = [
        'judul',
        'kategori',
        'gambar_thumbnail',
        'konten_html',
        'penulis_admin_id',
    ];

    public function penulisAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_admin_id');
    }

    public function bookmarkUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmark_artikel', 'artikel_id', 'warga_id')
                    ->withPivot('created_at');
    }
}
