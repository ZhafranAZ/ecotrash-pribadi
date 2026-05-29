<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtikelEdukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EdukasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $artikels = ArtikelEdukasi::with('penulisAdmin')
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.edukasi.index', compact('artikels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.edukasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'konten_html' => 'required|string',
            'gambar_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['judul', 'kategori', 'konten_html']);
        $data['penulis_admin_id'] = auth()->id();

        if ($request->hasFile('gambar_thumbnail')) {
            $file = $request->file('gambar_thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke public/edukasi/thumbnail
            $destinationPath = public_path('edukasi/thumbnail');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['gambar_thumbnail'] = 'edukasi/thumbnail/' . $filename;
        }

        ArtikelEdukasi::create($data);

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Artikel berhasil diterbitkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $artikel = ArtikelEdukasi::findOrFail($id);
        return view('admin.edukasi.edit', compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $artikel = ArtikelEdukasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'konten_html' => 'required|string',
            'gambar_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['judul', 'kategori', 'konten_html']);

        if ($request->hasFile('gambar_thumbnail')) {
            $file = $request->file('gambar_thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke public/edukasi/thumbnail
            $destinationPath = public_path('edukasi/thumbnail');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $file->move($destinationPath, $filename);
            
            // Hapus gambar lama jika ada
            if ($artikel->gambar_thumbnail) {
                $oldPath = public_path($artikel->gambar_thumbnail);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $data['gambar_thumbnail'] = 'edukasi/thumbnail/' . $filename;
        }

        $artikel->update($data);

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artikel = ArtikelEdukasi::findOrFail($id);

        // Hapus file gambar thumbnail
        if ($artikel->gambar_thumbnail) {
            $imagePath = public_path($artikel->gambar_thumbnail);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $artikel->delete();

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}
