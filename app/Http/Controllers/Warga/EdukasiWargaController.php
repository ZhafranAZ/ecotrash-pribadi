<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\ArtikelEdukasi;
use Illuminate\Http\Request;

class EdukasiWargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        $artikels = ArtikelEdukasi::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('konten_html', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->latest()
            ->paginate(6);

        // Ambil list ID artikel yang di-bookmark oleh user aktif
        $bookmarkedIds = auth()->user()
            ->bookmarkArtikel()
            ->pluck('artikel_id')
            ->toArray();

        return view('warga.edukasi.index', compact('artikels', 'bookmarkedIds'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $artikel = ArtikelEdukasi::findOrFail($id);
        
        $isBookmarked = auth()->user()
            ->bookmarkArtikel()
            ->where('artikel_id', $id)
            ->exists();

        return view('warga.edukasi.show', compact('artikel', 'isBookmarked'));
    }

    /**
     * Display the bookmarked articles for the active user.
     */
    public function tersimpan()
    {
        $artikels = auth()->user()
            ->bookmarkArtikel()
            ->latest('bookmark_artikel.created_at')
            ->paginate(6);

        return view('warga.edukasi.tersimpan', compact('artikels'));
    }

    /**
     * Toggle the bookmark status of an article.
     */
    public function toggleBookmark(string $id)
    {
        $artikel = ArtikelEdukasi::findOrFail($id);
        $user = auth()->user();

        // Cek apakah sudah di-bookmark
        $exists = $user->bookmarkArtikel()->where('artikel_id', $id)->exists();

        if ($exists) {
            $user->bookmarkArtikel()->detach($id);
            $status = 'unbookmarked';
            $message = 'Dihapus dari Tersimpan';
        } else {
            $user->bookmarkArtikel()->attach($id, ['created_at' => now()]);
            $status = 'bookmarked';
            $message = 'Artikel disimpan ke koleksi!';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
}
