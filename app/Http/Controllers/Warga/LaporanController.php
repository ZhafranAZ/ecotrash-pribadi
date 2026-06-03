<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StoreLaporanRequest;
use App\Models\LaporanSampahLiar;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Tampilkan form pembuatan laporan sampah liar.
     */
    public function create()
    {
        return view('warga.lapor.create');
    }

    /**
     * Simpan laporan baru ke database.
     */
    public function store(StoreLaporanRequest $request)
    {
        // Upload foto ke storage/app/public/laporan_warga
        $fotoPath = $request->file('foto')->store('laporan_warga', 'public');

        // Insert ke database
        $laporan = LaporanSampahLiar::create([
            'warga_id'            => Auth::id(),
            'lat'                 => $request->lat,
            'lng'                 => $request->lng,
            'deskripsi'           => $request->deskripsi,
            'foto_laporan_warga'  => $fotoPath,
            'status'              => 'menunggu',
        ]);

        // Redirect ke halaman berhasil dengan data laporan via session flash
        return redirect()->route('warga.lapor.berhasil')->with('laporan', $laporan);
    }

    /**
     * Tampilkan halaman berhasil setelah laporan terkirim.
     */
    public function berhasil()
    {
        return view('warga.lapor.berhasil');
    }
}
