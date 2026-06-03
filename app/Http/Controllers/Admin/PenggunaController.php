<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePetugasRequest;
use App\Models\Komplek;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    /**
     * Display the user management page with warga list (paginated) and petugas list.
     */
    public function index(): View
    {
        $wargaList = User::where('role', 'warga')
            ->withCount([
                'pesananSebagaiWarga as pesanan_selesai_count' => function ($query) {
                    $query->where('status', 'selesai');
                },
                'laporanSebagaiWarga as laporan_count'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $petugasList = User::where('role', 'petugas')
            ->with('petugasKomplek')
            ->orderBy('created_at', 'desc')
            ->get();

        $kompleks = Komplek::all();

        return view('admin.pengguna.index', compact('wargaList', 'petugasList', 'kompleks'));
    }

    /**
     * Store a new petugas account.
     */
    public function storePetugas(StorePetugasRequest $request): RedirectResponse
    {
        $petugas = User::create([
            'nama'              => $request->nama,
            'email'             => $request->email,
            'password'          => $request->password, // Auto-hashed via User model cast
            'role'              => 'petugas',
            'status_kehadiran'  => 'aktif',
            'saldo_koin'        => 0,
        ]);

        // Attach komplek areas if provided
        if ($request->has('komplek_ids')) {
            $petugas->petugasKomplek()->attach($request->komplek_ids);
        }

        return redirect()->back()->with('success', 'Akun petugas berhasil dibuat.');
    }

    /**
     * Update an existing petugas account (nama, email, password, area tugas, status).
     */
    public function updatePetugas(Request $request, $id): RedirectResponse
    {
        $petugas = User::where('id', $id)
            ->where('role', 'petugas')
            ->firstOrFail();

        $validated = $request->validate([
            'nama'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $petugas->id],
        ]);

        $petugas->update($validated);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate(['password' => ['string', 'min:8']]);
            $petugas->update(['password' => $request->password]);
        }

        // Sync area tugas (komplek)
        $petugas->petugasKomplek()->sync($request->komplek_ids ?? []);

        // Reset status berhalangan if requested
        if ($request->has('reset_status')) {
            $petugas->update([
                'status_kehadiran'   => 'aktif',
                'alasan_berhalangan' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Delete a petugas account.
     */
    public function destroyPetugas($id): RedirectResponse
    {
        $petugas = User::where('id', $id)
            ->where('role', 'petugas')
            ->firstOrFail();

        // Detach pivot relationships first
        $petugas->petugasKomplek()->detach();

        $petugas->delete();

        return redirect()->back()->with('success', 'Akun petugas berhasil dihapus.');
    }
}
