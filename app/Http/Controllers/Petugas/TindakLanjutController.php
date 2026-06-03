<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Petugas\TundaLaporanRequest;
use App\Http\Requests\Petugas\SelesaiLaporanRequest;
use App\Models\LaporanSampahLiar;
use App\Services\CoinService;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TindakLanjutController extends Controller
{
    public function __construct(
        protected CoinService $coinService,
        protected NotificationService $notificationService,
    ) {}

    /**
     * Tampilkan halaman detail laporan untuk petugas.
     */
    public function show(string $id)
    {
        $laporan = LaporanSampahLiar::with(['warga', 'komplek'])->findOrFail($id);

        // Pastikan laporan di-assign ke petugas yang login
        if ($laporan->petugas_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        return view('petugas.laporan.detail', compact('laporan'));
    }

    /**
     * Mulai proses pembersihan.
     * Mengubah status laporan menjadi 'sedang_dibersihkan'.
     */
    public function mulai(string $id): JsonResponse
    {
        $laporan = LaporanSampahLiar::findOrFail($id);

        // Validasi ownership
        if ($laporan->petugas_id !== Auth::id()) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses ke laporan ini.',
            ], 403);
        }

        // Validasi status saat ini (hanya bisa mulai dari disetujui atau ditunda)
        if (!in_array($laporan->status, ['disetujui', 'ditunda'])) {
            return response()->json([
                'message' => 'Laporan tidak dapat dimulai dari status saat ini: ' . $laporan->status,
            ], 422);
        }

        $laporan->update(['status' => 'sedang_dibersihkan']);

        return response()->json([
            'message' => 'Pembersihan berhasil dimulai.',
            'status'  => 'sedang_dibersihkan',
        ]);
    }

    /**
     * Tunda proses pembersihan.
     * Mengubah status menjadi 'ditunda' dan mencatat alasan.
     */
    public function tunda(TundaLaporanRequest $request, string $id): JsonResponse
    {
        $laporan = LaporanSampahLiar::findOrFail($id);

        // Validasi ownership
        if ($laporan->petugas_id !== Auth::id()) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses ke laporan ini.',
            ], 403);
        }

        // Validasi status saat ini (hanya bisa tunda dari sedang_dibersihkan)
        if ($laporan->status !== 'sedang_dibersihkan') {
            return response()->json([
                'message' => 'Laporan tidak dapat ditunda dari status saat ini: ' . $laporan->status,
            ], 422);
        }

        // Gabungkan alasan utama dan catatan tambahan
        $alasan = $request->alasan_utama;
        if ($request->filled('catatan_tambahan')) {
            $alasan .= ' - ' . $request->catatan_tambahan;
        }

        $laporan->update([
            'status'         => 'ditunda',
            'alasan_ditunda' => $alasan,
        ]);

        // Kirim notifikasi warning ke warga
        NotificationService::send(
            user: $laporan->warga_id,
            judul: 'Pembersihan Ditunda',
            pesan: "Pembersihan tumpukan sampah di laporan #{$laporan->id} tertunda. Alasan: {$alasan}",
            tipe: 'warning'
        );

        return response()->json([
            'message' => 'Laporan berhasil ditunda.',
            'status'  => 'ditunda',
        ]);
    }

    /**
     * Selesaikan proses pembersihan.
     * Upload foto bukti, berikan koin reward, dan kirim notifikasi.
     */
    public function selesai(SelesaiLaporanRequest $request, string $id): JsonResponse
    {
        $laporan = LaporanSampahLiar::findOrFail($id);

        // Validasi ownership
        if ($laporan->petugas_id !== Auth::id()) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses ke laporan ini.',
            ], 403);
        }

        // Cegah double submit
        if ($laporan->status === 'selesai') {
            return response()->json([
                'message' => 'Laporan ini sudah diselesaikan sebelumnya.',
            ], 422);
        }

        // Validasi status saat ini (hanya bisa selesai dari sedang_dibersihkan)
        if ($laporan->status !== 'sedang_dibersihkan') {
            return response()->json([
                'message' => 'Laporan tidak dapat diselesaikan dari status saat ini: ' . $laporan->status,
            ], 422);
        }

        // Upload foto hasil pembersihan
        $fotoPath = $request->file('foto_hasil')->store('laporan_selesai', 'public');

        // Update laporan
        $laporan->update([
            'status'                     => 'selesai',
            'foto_bukti_selesai_petugas' => $fotoPath,
        ]);

        // Berikan koin reward ke warga (jika ada)
        $koinReward = $laporan->koin_reward;
        if ($koinReward > 0) {
            $this->coinService->addCoins(
                wargaId: $laporan->warga_id,
                jumlah: $koinReward,
                sumber: 'laporan_liar',
                referensiId: (string) $laporan->id
            );
        }

        // Kirim notifikasi success ke warga
        $pesanNotif = "Tumpukan sampah di laporan #{$laporan->id} telah dibersihkan!";
        if ($koinReward > 0) {
            $pesanNotif .= " Anda mendapat {$koinReward} koin bonus.";
        }

        NotificationService::send(
            user: $laporan->warga_id,
            judul: 'Pembersihan Selesai',
            pesan: $pesanNotif,
            tipe: 'success'
        );

        return response()->json([
            'message'     => 'Laporan berhasil diselesaikan.',
            'status'      => 'selesai',
            'koin_reward' => $koinReward,
        ]);
    }

    /**
     * Tampilkan halaman beranda petugas dengan tugas-tugas aktif.
     */
    public function beranda()
    {
        $petugas = Auth::user();

        // Ambil laporan sampah liar yang di-assign ke petugas ini dengan status aktif
        $laporanLiar = LaporanSampahLiar::with(['warga', 'komplek'])
            ->where('petugas_id', $petugas->id)
            ->whereIn('status', ['disetujui', 'sedang_dibersihkan', 'ditunda'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil daftar komplek tugas hari ini
        $kompleks = $petugas->petugasKomplek;

        return view('petugas.beranda', compact('petugas', 'laporanLiar', 'kompleks'));
    }
}
