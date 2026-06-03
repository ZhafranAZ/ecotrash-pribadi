<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Petugas\UpdateStatusRequest;
use App\Http\Requests\Petugas\ReportKendalaRequest;
use App\Models\PesananPengangkutan;
use App\Models\PengaturanSistem;
use App\Models\RiwayatStatusPesanan;
use App\Services\CoinService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TugasController extends Controller
{
    /**
     * Beranda Petugas — daftar komplek yang ditugaskan beserta jumlah pesanan.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Ambil komplek yang ditugaskan ke petugas ini, beserta jumlah pesanan hari ini
        $kompleks = $user->petugasKomplek()
            ->withCount(['pesanan' => function ($query) {
                $query->where('tanggal_penjemputan', today())
                      ->whereIn('status', ['menunggu', 'diproses']);
            }])
            ->get();

        return view('petugas.beranda', compact('kompleks', 'user'));
    }

    /**
     * Daftar pesanan warga di suatu komplek.
     */
    public function showKomplekWarga(int $komplekId): View
    {
        $user = auth()->user();

        // Pastikan petugas ditugaskan di komplek ini
        $komplek = $user->petugasKomplek()->where('komplek.id', $komplekId)->firstOrFail();

        // Ambil pesanan hari ini di komplek ini
        $pesanans = PesananPengangkutan::where('komplek_id', $komplekId)
            ->where('tanggal_penjemputan', today())
            ->whereIn('status', ['menunggu', 'diproses'])
            ->with('warga')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('petugas.komplek.warga', compact('komplek', 'pesanans'));
    }

    /**
     * Detail tugas / pesanan.
     */
    public function showDetail(string $type, string $id): View
    {
        $user = auth()->user();

        $pesanan = PesananPengangkutan::with(['warga', 'komplek'])->findOrFail($id);

        // Pastikan petugas ditugaskan di komplek pesanan ini
        $this->authorizeKomplek($user, $pesanan->komplek_id);

        return view('petugas.tugas.detail', compact('pesanan', 'type'));
    }

    /**
     * Update status pesanan (diproses / selesai) — JSON Response untuk Axios.
     */
    public function updateStatus(UpdateStatusRequest $request, string $id): JsonResponse
    {
        $user = auth()->user();
        $pesanan = PesananPengangkutan::findOrFail($id);

        // Pastikan petugas ditugaskan di komplek pesanan ini
        $this->authorizeKomplek($user, $pesanan->komplek_id);

        $statusBaru = $request->input('status');
        $statusLama = $pesanan->status;
        $uploadedFilePath = null;

        DB::beginTransaction();

        try {
            if ($statusBaru === 'diproses') {
                $pesanan->update([
                    'status'     => 'diproses',
                    'petugas_id' => $user->id,
                ]);

                // Catat riwayat status
                RiwayatStatusPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'status'     => 'diproses',
                    'keterangan' => 'Petugas memulai proses pengangkutan.',
                ]);

                // Notifikasi ke warga
                NotificationService::send(
                    $pesanan->warga_id,
                    'Pesanan Sedang Diproses',
                    'Petugas sedang menuju ke lokasimu.',
                    'info'
                );
            }

            if ($statusBaru === 'selesai') {
                // Upload foto bukti
                $uploadedFilePath = $request->file('foto_bukti')->store('buktipesanan', 'public');

                // Kalkulasi koin dari pengaturan sistem
                $pengaturan = PengaturanSistem::first();
                $kolomBonus = 'bonus_koin_' . $pesanan->kategori_sampah;
                $jumlahKoin = $pengaturan->{$kolomBonus} ?? 0;

                $pesanan->update([
                    'status'            => 'selesai',
                    'foto_bukti_selesai' => $uploadedFilePath,
                    'koin_didapat'      => $jumlahKoin,
                ]);

                // Tambah koin ke warga
                CoinService::addCoins($pesanan->warga_id, $jumlahKoin, $pesanan->id);

                // Catat riwayat status
                RiwayatStatusPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'status'     => 'selesai',
                    'keterangan' => 'Pesanan selesai. Koin bonus: ' . $jumlahKoin,
                ]);

                // Notifikasi ke warga
                NotificationService::send(
                    $pesanan->warga_id,
                    'Pesanan Selesai',
                    'Sampah telah diangkut! Anda mendapat ' . $jumlahKoin . ' koin bonus.',
                    'success'
                );
            }

            DB::commit();

            return response()->json([
                'message' => $statusBaru === 'diproses'
                    ? 'Pesanan sedang diproses.'
                    : 'Pesanan berhasil diselesaikan.',
                'status' => $statusBaru,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sudah terupload jika ada
            if ($uploadedFilePath && Storage::disk('public')->exists($uploadedFilePath)) {
                Storage::disk('public')->delete($uploadedFilePath);
            }

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui status.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lapor kendala (terkunci / beda_ukuran) — JSON Response untuk Axios.
     */
    public function reportKendala(ReportKendalaRequest $request, string $id): JsonResponse
    {
        $user = auth()->user();
        $pesanan = PesananPengangkutan::findOrFail($id);

        // Pastikan petugas ditugaskan di komplek pesanan ini
        $this->authorizeKomplek($user, $pesanan->komplek_id);

        $tipeKendala = $request->input('tipe_kendala');
        $uploadedFilePath = null;

        DB::beginTransaction();

        try {
            // Upload foto kendala jika ada
            if ($request->hasFile('foto_kendala')) {
                $uploadedFilePath = $request->file('foto_kendala')->store('fotokendala', 'public');
            }

            if ($tipeKendala === 'terkunci') {
                // Hitung hari kerja berikutnya
                $hariMap = [
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu',
                    'Sunday' => 'Minggu',
                ];

                $pengaturan = PengaturanSistem::first();
                $hariOperasional = $pengaturan->hari_operasional ?? ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

                $tanggalBaru = now()->addDay();
                while (!in_array($hariMap[$tanggalBaru->format('l')] ?? '', $hariOperasional)) {
                    $tanggalBaru->addDay();
                }
                
                $namaHariBaru = $hariMap[$tanggalBaru->format('l')];

                $pesanan->update([
                    'status'                => 'menunggu',
                    'tanggal_penjemputan'   => $tanggalBaru->toDateString(),
                    'nama_hari_penjemputan' => $namaHariBaru,
                    'petugas_id'            => null,
                    'alasan_kendala'        => $request->input('alasan', 'Pagar Tertutup'),
                    'foto_kendala'          => $uploadedFilePath,
                ]);

                // Catat riwayat status
                RiwayatStatusPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'status'     => 'menunggu',
                    'keterangan' => 'Gagal pickup: Pagar tertutup. Otomatis dijadwalkan ulang ke ' . $tanggalBaru->format('d/m/Y') . '.',
                ]);

                // Notifikasi ke warga
                NotificationService::send(
                    $pesanan->warga_id,
                    'Penjadwalan Ulang',
                    'Pagar Anda terkunci saat petugas datang. Penjemputan otomatis dijadwalkan ulang ke ' . $namaHariBaru . ', ' . $tanggalBaru->format('d/m/Y') . '.',
                    'warning'
                );
            }

            if ($tipeKendala === 'beda_ukuran') {
                $pesanan->update([
                    'status'                        => 'hold_kapasitas',
                    'ukuran_aktual_laporan_petugas' => $request->input('ukuran_aktual'),
                    'foto_kendala'                  => $uploadedFilePath,
                    'alasan_kendala'                => $request->input('alasan', 'Ukuran sampah tidak sesuai pesanan'),
                ]);

                // Catat riwayat status
                RiwayatStatusPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'status'     => 'hold_kapasitas',
                    'keterangan' => 'Hold kapasitas: Ukuran aktual ' . $request->input('ukuran_aktual') . '.',
                ]);

                // Notifikasi ke warga (tipe warning untuk trigger banner)
                NotificationService::send(
                    $pesanan->warga_id,
                    'Pembayaran Tambahan Diperlukan',
                    'Ukuran sampah Anda ternyata lebih besar dari yang dipesan. Diperlukan pembayaran tambahan.',
                    'warning'
                );
            }

            DB::commit();

            return response()->json([
                'message' => $tipeKendala === 'terkunci'
                    ? 'Pesanan berhasil dijadwalkan ulang.'
                    : 'Laporan beda ukuran berhasil dikirim.',
                'status' => $pesanan->fresh()->status,
                'new_date' => isset($tanggalBaru) ? $tanggalBaru->format('d/m/Y') : null,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sudah terupload jika ada
            if ($uploadedFilePath && Storage::disk('public')->exists($uploadedFilePath)) {
                Storage::disk('public')->delete($uploadedFilePath);
            }

            return response()->json([
                'message' => 'Terjadi kesalahan saat melaporkan kendala.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validasi bahwa petugas ditugaskan di komplek tertentu.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function authorizeKomplek($user, int $komplekId): void
    {
        $isAssigned = $user->petugasKomplek()->where('komplek.id', $komplekId)->exists();

        if (!$isAssigned) {
            abort(403, 'Anda tidak ditugaskan di area komplek ini.');
        }
    }
}
