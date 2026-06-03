<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\UpdateProfilRequest;
use App\Http\Requests\Warga\StoreAlamatRequest;
use App\Models\AlamatWarga;
use App\Models\Komplek;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Display the warga profile page with addresses and komplek list.
     */
    public function index(): View
    {
        $user = Auth::user();
        $alamatList = $user->alamatWarga()->with('komplek')->get();
        $kompleks = Komplek::all();

        // Pre-map address data for Alpine.js (avoid inline closure in Blade @json)
        $addressesJson = $alamatList->map(function ($a) {
            return [
                'id' => $a->id,
                'title' => $a->nama_alamat,
                'komplek' => $a->komplek->nama_komplek ?? '',
                'komplek_id' => $a->komplek_id,
                'detail' => $a->blok_nomor_rumah . ($a->detail_patokan ? ', ' . $a->detail_patokan : ''),
                'blok_nomor_rumah' => $a->blok_nomor_rumah,
                'detail_patokan' => $a->detail_patokan ?? '',
            ];
        });

        $primaryAddressId = $alamatList->where('is_utama', true)->first()?->id;

        return view('warga.profil.index', compact('user', 'alamatList', 'kompleks', 'addressesJson', 'primaryAddressId'));
    }

    /**
     * Update warga profile (nama & no_telepon).
     */
    public function updateProfile(UpdateProfilRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->update($request->validated());

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Store a new address for the logged-in warga.
     * First address is automatically set as primary (is_utama = true).
     */
    public function storeAlamat(StoreAlamatRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $isFirst = !$user->alamatWarga()->exists();

        AlamatWarga::create([
            'warga_id'        => $user->id,
            'komplek_id'      => $request->komplek_id,
            'nama_alamat'     => $request->nama_alamat,
            'blok_nomor_rumah'=> $request->blok_nomor_rumah,
            'detail_patokan'  => $request->detail_patokan,
            'is_utama'        => $isFirst,
        ]);

        return redirect()->back()->with('success', 'Alamat baru berhasil ditambahkan.');
    }

    /**
     * Update an existing address (must belong to the logged-in warga).
     */
    public function updateAlamat(Request $request, $id): RedirectResponse
    {
        $alamat = AlamatWarga::where('id', $id)
            ->where('warga_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'komplek_id'       => ['required', 'exists:komplek,id'],
            'nama_alamat'      => ['required', 'string', 'max:255'],
            'blok_nomor_rumah' => ['required', 'string', 'max:255'],
            'detail_patokan'   => ['nullable', 'string', 'max:1000'],
        ]);

        $alamat->update($validated);

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    }

    /**
     * Set an address as the primary address (is_utama).
     * Uses DB::transaction for atomicity.
     */
    public function setAlamatUtama($id): RedirectResponse
    {
        $userId = Auth::id();

        // Verify the address belongs to the logged-in warga
        $alamat = AlamatWarga::where('id', $id)
            ->where('warga_id', $userId)
            ->firstOrFail();

        DB::transaction(function () use ($userId, $id) {
            // 1. Unset all addresses for this warga
            AlamatWarga::where('warga_id', $userId)
                ->update(['is_utama' => false]);

            // 2. Set the selected address as primary
            AlamatWarga::where('id', $id)
                ->update(['is_utama' => true]);
        });

        return redirect()->back()->with('success', 'Alamat utama berhasil diubah.');
    }

    /**
     * Delete an address (must belong to the logged-in warga).
     * Prevents deleting the last remaining address.
     */
    public function destroyAlamat($id): RedirectResponse
    {
        $userId = Auth::id();

        $alamat = AlamatWarga::where('id', $id)
            ->where('warga_id', $userId)
            ->firstOrFail();

        // Prevent deleting if this is the only address
        $addressCount = AlamatWarga::where('warga_id', $userId)->count();
        if ($addressCount <= 1) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus alamat terakhir. Anda harus memiliki minimal 1 alamat.');
        }

        // If deleting the primary address, reassign primary to another
        if ($alamat->is_utama) {
            $alamat->delete();
            $nextAddress = AlamatWarga::where('warga_id', $userId)->first();
            if ($nextAddress) {
                $nextAddress->update(['is_utama' => true]);
            }
        } else {
            $alamat->delete();
        }

        return redirect()->back()->with('success', 'Alamat berhasil dihapus.');
    }
}
