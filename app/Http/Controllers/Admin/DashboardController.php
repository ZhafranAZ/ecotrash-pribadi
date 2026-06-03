<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Komplek;
use App\Models\PesananPengangkutan;
use App\Models\LaporanSampahLiar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // === Stat Cards (di-cache 60 detik agar tidak query DB terus-menerus) ===
        $totalWarga = Cache::remember('admin.stats.totalWarga', 60, function () {
            return User::where('role', 'warga')->count();
        });

        $totalPetugas = Cache::remember('admin.stats.totalPetugas', 60, function () {
            return User::where('role', 'petugas')->count();
        });

        $pesananHariIni = Cache::remember('admin.stats.pesananHariIni.' . today()->toDateString(), 60, function () {
            return PesananPengangkutan::whereDate('created_at', today())->count();
        });

        $laporanMenunggu = Cache::remember('admin.stats.laporanMenunggu', 60, function () {
            return LaporanSampahLiar::where('status', 'menunggu')->count();
        });

        $koinBeredar = Cache::remember('admin.stats.koinBeredar', 60, function () {
            return User::where('role', 'warga')->sum('saldo_koin');
        });

        // === Map Markers (di-cache 60 detik) ===
        $mapMarkers = Cache::remember('admin.stats.mapMarkers', 60, function () {
            // TPS Komplek markers
            $komplek = Komplek::all()->map(fn($k) => [
                'lat'   => (float) $k->lat,
                'lng'   => (float) $k->lng,
                'type'  => 'tps',
                'title' => 'TPS ' . $k->nama_komplek,
            ]);

            // Laporan Liar markers (yang belum selesai/ditolak)
            $laporanAktif = LaporanSampahLiar::whereNotIn('status', ['selesai', 'ditolak'])
                ->get()
                ->map(fn($l) => [
                    'lat'   => (float) $l->lat,
                    'lng'   => (float) $l->lng,
                    'type'  => 'liar',
                    'title' => 'Laporan: ' . \Illuminate\Support\Str::limit($l->deskripsi, 40),
                ]);

            return $komplek->merge($laporanAktif)->values();
        });

        // === Chart Data ===
        $chartPesanan = $this->getChartPesanan30Hari();
        $chartLaporan = $this->getChartLaporan4Minggu();

        return view('admin.dashboard', compact(
            'totalWarga',
            'totalPetugas',
            'pesananHariIni',
            'laporanMenunggu',
            'koinBeredar',
            'mapMarkers',
            'chartPesanan',
            'chartLaporan',
        ));
    }

    /**
     * Hitung tren pesanan pengangkutan 30 hari terakhir.
     * Mengembalikan array ['labels' => [...], 'data' => [...]]
     */
    private function getChartPesanan30Hari(): array
    {
        $startDate = Carbon::today()->subDays(29);
        $endDate = Carbon::today();

        // Query count per hari
        $rawData = PesananPengangkutan::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupByRaw('DATE(created_at)')
            ->pluck('jumlah', 'tanggal');

        $labels = [];
        $data = [];

        // Loop 30 hari, isi 0 jika tidak ada data
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $key = $date->toDateString();
            $labels[] = $date->translatedFormat('d M');
            $data[] = $rawData->get($key, 0);
        }

        return ['labels' => $labels, 'data' => $data];
    }

    /**
     * Hitung laporan sampah liar per minggu (4 minggu terakhir).
     * Mengembalikan array ['labels' => [...], 'data' => [...]]
     */
    private function getChartLaporan4Minggu(): array
    {
        $labels = [];
        $data = [];

        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::today()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::today()->subWeeks($i)->endOfWeek();

            $labels[] = 'Minggu ' . (4 - $i);
            $data[] = LaporanSampahLiar::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
