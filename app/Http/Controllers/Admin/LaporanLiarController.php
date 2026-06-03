<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveLaporanRequest;
use App\Http\Requests\Admin\RejectLaporanRequest;
use App\Models\LaporanSampahLiar;
use App\Models\User;
use App\Services\CoinService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanLiarController extends Controller
{
    protected CoinService $coinService;
    protected NotificationService $notificationService;

    public function __construct(CoinService $coinService, NotificationService $notificationService)
    {
        $this->coinService = $coinService;
        $this->notificationService = $notificationService;
    }

    /**
     * Tampilkan daftar laporan sampah liar dengan filter & search.
     */
    public function index(Request $request)
    {
        $query = LaporanSampahLiar::with(['warga', 'petugas'])->latest();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search berdasarkan ID atau nama pelapor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('warga', function ($q2) use ($search) {
                      $q2->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $laporans = $query->paginate(10)->withQueryString();

        // Map data laporan untuk JSON (digunakan di Leaflet/Alpine.js pada View)
        $laporanJsonData = collect($laporans->items())->map(function($l) {
            return [
                'id' => $l->id,
                'ticketId' => $l->created_at->format('Ymd') . '-' . str_pad($l->id, 2, '0', STR_PAD_LEFT),
                'pelapor' => $l->warga->nama ?? '-',
                'tanggal' => $l->created_at->translatedFormat('d M Y'),
                'lokasi' => $l->alamat_lokasi ?? ($l->lat . ', ' . $l->lng),
                'lat' => (float) $l->lat,
                'lng' => (float) $l->lng,
                'deskripsi' => $l->deskripsi,
                'foto' => $l->foto_laporan_warga ? asset('storage/' . $l->foto_laporan_warga) : null,
                'status' => $l->status,
                'petugas' => $l->petugas->nama ?? null,
                'alasanPenolakan' => $l->alasan_penolakan,
                'koinReward' => $l->koin_reward,
            ];
        });

        // Ambil daftar petugas aktif untuk dropdown di modal approve
        $petugasList = User::where('role', 'petugas')
            ->where('status_kehadiran', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('admin.laporan.index', compact('laporans', 'petugasList', 'laporanJsonData'));
    }

    /**
     * Setujui laporan: tugaskan petugas, beri koin reward, kirim notifikasi.
     */
    public function approve($id, ApproveLaporanRequest $request)
    {
        $laporan = LaporanSampahLiar::findOrFail($id);

        DB::beginTransaction();

        try {
            // Update status laporan
            $laporan->update([
                'status'      => 'disetujui',
                'petugas_id'  => $request->petugas_id,
                'koin_reward' => $request->koin_reward,
            ]);

            // Tambahkan koin reward ke warga pelapor
            if ($request->koin_reward > 0) {
                $this->coinService->addCoins(
                    $laporan->warga,
                    $request->koin_reward,
                    'laporan_liar',
                    (string) $laporan->id
                );
            }

            // Notifikasi ke Warga pelapor
            $this->notificationService->send(
                $laporan->warga,
                'Laporan Disetujui!',
                'Laporan sampah liar Anda telah disetujui. Anda mendapatkan ' . $request->koin_reward . ' koin sebagai reward.',
                'success'
            );

            // Notifikasi ke Petugas yang ditugaskan
            $petugas = User::findOrFail($request->petugas_id);
            $this->notificationService->send(
                $petugas,
                'Tugas Pembersihan Baru',
                'Ada tugas pembersihan sampah liar baru yang ditugaskan kepada Anda. Silakan cek detail laporan.',
                'info'
            );

            DB::commit();

            return redirect()->back()->with('success', 'Laporan berhasil disetujui dan petugas telah ditugaskan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui laporan: ' . $e->getMessage());
        }
    }

    /**
     * Tolak laporan: simpan alasan penolakan, kirim notifikasi ke warga.
     */
    public function reject($id, RejectLaporanRequest $request)
    {
        $laporan = LaporanSampahLiar::findOrFail($id);

        $laporan->update([
            'status'            => 'ditolak',
            'alasan_penolakan'  => $request->alasan_penolakan,
        ]);

        // Notifikasi ke Warga pelapor
        $this->notificationService->send(
            $laporan->warga,
            'Laporan Ditolak',
            'Laporan sampah liar Anda ditolak. Alasan: ' . $request->alasan_penolakan,
            'error'
        );

        return redirect()->back()->with('success', 'Laporan berhasil ditolak.');
    }

    /**
     * Tandai laporan sebagai duplikat (tolak dengan alasan hardcoded).
     */
    public function markDuplicate($id)
    {
        $laporan = LaporanSampahLiar::findOrFail($id);

        $laporan->update([
            'status'            => 'ditolak',
            'alasan_penolakan'  => 'Laporan Duplikat/Sudah dilaporkan oleh warga lain.',
        ]);

        // Notifikasi ke Warga pelapor
        $this->notificationService->send(
            $laporan->warga,
            'Laporan Ditolak',
            'Laporan sampah liar Anda ditandai sebagai duplikat. Laporan serupa sudah dilaporkan oleh warga lain.',
            'error'
        );

        return redirect()->back()->with('success', 'Laporan berhasil ditandai sebagai duplikat.');
    }
}
