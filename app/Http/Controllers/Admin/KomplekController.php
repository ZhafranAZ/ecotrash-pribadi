<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKomplekRequest;
use App\Models\AlamatWarga;
use App\Models\Komplek;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KomplekController extends Controller
{
    /**
     * Display the settings page with komplek list.
     */
    public function index(): View
    {
        $kompleks = Komplek::orderBy('created_at', 'desc')->get();

        return view('admin.pengaturan.index', compact('kompleks'));
    }

    /**
     * Store a new komplek.
     */
    public function store(StoreKomplekRequest $request): RedirectResponse
    {
        Komplek::create($request->validated());

        return redirect()->back()->with('success', 'Komplek baru berhasil ditambahkan.');
    }

    /**
     * Update an existing komplek.
     */
    public function update(StoreKomplekRequest $request, $id): RedirectResponse
    {
        $komplek = Komplek::findOrFail($id);
        $komplek->update($request->validated());

        return redirect()->back()->with('success', 'Data komplek berhasil diperbarui.');
    }

    /**
     * Delete a komplek.
     * Checks if any alamat_warga still uses this komplek before allowing deletion.
     */
    public function destroy($id): RedirectResponse
    {
        $komplek = Komplek::findOrFail($id);

        // Check if any alamat_warga still references this komplek
        $isUsed = AlamatWarga::where('komplek_id', $id)->exists();

        if ($isUsed) {
            return redirect()->back()->with('error', 'Komplek tidak dapat dihapus karena masih digunakan oleh Warga.');
        }

        try {
            $komplek->delete();
            return redirect()->back()->with('success', 'Komplek berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus komplek.');
        }
    }
}
