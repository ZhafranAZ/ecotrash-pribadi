<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PesananPengangkutan;
use App\Models\LaporanSampahLiar;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Riwayat Pesanan Pengangkutan milik warga, dengan relasi riwayat status untuk timeline tracking
        $pesanan = PesananPengangkutan::where('warga_id', $userId)
            ->with(['riwayatStatus' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->latest()
            ->get();

        // Riwayat Laporan Sampah Liar milik warga
        $laporan = LaporanSampahLiar::where('warga_id', $userId)
            ->latest()
            ->get();

        return view('warga.aktivitas.index', compact('pesanan', 'laporan'));
    }
}
