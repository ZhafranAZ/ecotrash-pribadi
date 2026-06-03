<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\AlamatWarga;
use App\Models\PengaturanSistem;
use App\Models\PesananPengangkutan;
use App\Models\RiwayatStatusPesanan;
use App\Services\CoinService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PesananController extends Controller
{
    /**
     * Menampilkan form pemesanan pengangkutan.
     * Mengambil data alamat, saldo koin, pengaturan harga, dan jadwal dari database.
     */
    public function create()
    {
        $user = Auth::user();
        $alamatList = $user->alamatWarga()->with('komplek')->get();
        $saldoKoin = $user->saldo_koin;
        $pengaturan = PengaturanSistem::first();

        // Hitung jadwal yang tersedia berdasarkan hari_operasional + minggu ini
        $hariMap = [
            'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3,
            'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 7,
        ];

        $startOfWeek = now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = now()->endOfWeek(Carbon::SUNDAY);

        $jadwalList = collect($pengaturan->hari_operasional)->map(function ($hari) use ($hariMap, $startOfWeek) {
            $tanggal = $startOfWeek->copy()->addDays($hariMap[$hari] - 1);
            return [
                'hari'    => $hari,                    // "Senin"
                'label'   => substr($hari, 0, 3),      // "Sen"
                'tanggal' => $tanggal->format('Y-m-d'), // "2026-06-02"
                'tgl'     => $tanggal->format('d'),     // "02"
            ];
        });

        $periodeLabel = $startOfWeek->format('d') . ' - ' . $endOfWeek->format('d M');

        return view('warga.pesan.create', compact(
            'alamatList', 'saldoKoin', 'pengaturan', 'jadwalList', 'periodeLabel'
        ));
    }

    /**
     * Proses checkout pesanan pengangkutan.
     * Menerima request Axios dari Alpine.js, memvalidasi, dan menyimpan pesanan.
     * Mengembalikan JSON response.
     */
    public function store(Request $request)
    {
        // Step 1 — Validasi Request
        $validated = $request->validate([
            'alamat_id' => ['required', 'exists:alamat_warga,id'],
            'kategori'  => ['required', 'string', 'in:Kecil,Sedang,Besar'],
            'jadwal'    => ['required', 'date'],
            'koin'      => ['nullable', 'integer', 'min:0'],
            'catatan'   => ['nullable', 'string'],
        ]);

        // Step 2 — Ambil harga dari pengaturan_sistem (server-side, JANGAN percaya frontend)
        $pengaturan = PengaturanSistem::first();
        $hargaAwal = match (strtolower($validated['kategori'])) {
            'kecil'  => $pengaturan->harga_kategori_kecil,
            'sedang' => $pengaturan->harga_kategori_sedang,
            'besar'  => $pengaturan->harga_kategori_besar,
        };

        // Step 3 — Validasi & Kalkulasi Koin
        $koinDigunakan = $validated['koin'] ?? 0;
        $user = Auth::user();

        if ($koinDigunakan > 0) {
            // Cek 1: Tidak boleh melebihi saldo koin warga
            if ($koinDigunakan > $user->saldo_koin) {
                abort(422, 'Penggunaan koin tidak valid');
            }

            // Cek 2: Potongan tidak boleh melebihi 50% harga dasar
            $nilaiPotongan = $koinDigunakan * $pengaturan->konversi_koin_rupiah;
            $maxPotongan = floor($hargaAwal * 0.5);
            if ($nilaiPotongan > $maxPotongan) {
                abort(422, 'Penggunaan koin tidak valid');
            }
        }

        $potongan = $koinDigunakan * $pengaturan->konversi_koin_rupiah;
        $totalHarga = $hargaAwal - $potongan;

        // Step 4 — Snapshot Alamat & Parse Tanggal
        $alamat = AlamatWarga::with('komplek')->findOrFail($validated['alamat_id']);

        $tanggalPenjemputan = Carbon::parse($validated['jadwal']);
        $hariIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',
        ];
        $namaHari = $hariIndo[$tanggalPenjemputan->format('l')];

        // Step 5 — Generate ID Pesanan (format: PJP-YYMMDD-XXXX)
        $today = now()->format('ymd');
        $count = PesananPengangkutan::where('id', 'like', "PJP-{$today}-%")->count() + 1;
        $pesananId = sprintf("PJP-%s-%04d", $today, $count);

        // Step 6 — DB Transaction
        DB::beginTransaction();
        try {
            // 6a. Insert pesanan
            $pesanan = PesananPengangkutan::create([
                'id'                      => $pesananId,
                'warga_id'                => $user->id,
                'komplek_id'              => $alamat->komplek_id,
                'nama_alamat_snapshot'    => $alamat->nama_alamat . ' (Komplek ' . $alamat->komplek->nama_komplek . ')',
                'blok_nomor_rumah'        => $alamat->blok_nomor_rumah,
                'detail_patokan_snapshot' => $alamat->detail_patokan,
                'kategori_sampah'         => strtolower($validated['kategori']),
                'tanggal_penjemputan'     => $tanggalPenjemputan->format('Y-m-d'),
                'nama_hari_penjemputan'   => $namaHari,
                'catatan_warga'           => $validated['catatan'] ?? null,
                'koin_digunakan'          => $koinDigunakan,
                'koin_didapat'            => match (strtolower($validated['kategori'])) {
                    'kecil'  => $pengaturan->bonus_koin_kecil,
                    'sedang' => $pengaturan->bonus_koin_sedang,
                    'besar'  => $pengaturan->bonus_koin_besar,
                },
                'harga_awal'              => $hargaAwal,
                'total_harga_akhir'       => $totalHarga,
                'selisih_harga'           => 0,
                'status'                  => 'menunggu',
                'status_pembayaran'       => 'paid',
                'metode_pembayaran'       => 'qris',
            ]);

            // 6b. Insert riwayat status pesanan
            RiwayatStatusPesanan::create([
                'pesanan_id' => $pesanan->id,
                'status'     => 'menunggu',
                'keterangan' => 'Pesanan baru berhasil dibuat dan telah lunas',
            ]);

            // 6c. Potong koin (jika dipakai)
            if ($koinDigunakan > 0) {
                app(CoinService::class)->deductCoins($user->id, $koinDigunakan, 'pesanan', $pesanan->id);
            }

            // 6d. Kirim notifikasi ke petugas (jika ada yang ter-assign ke komplek)
            $petugasIds = $alamat->komplek->petugasUsers->pluck('id');
            if ($petugasIds->isNotEmpty()) {
                foreach ($petugasIds as $petugasId) {
                    NotificationService::send(
                        $petugasId,
                        'Pesanan Pengangkutan Baru',
                        'Pesanan Pengangkutan Baru di area Anda',
                        'info'
                    );
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // Step 7 — Return JSON
        return response()->json([
            'status'       => 'success',
            'redirect_url' => route('warga.pesan.berhasil', $pesanan->id),
        ]);
    }

    /**
     * Menampilkan halaman resi/berhasil setelah checkout.
     */
    public function success(string $id)
    {
        $pesanan = PesananPengangkutan::findOrFail($id);

        return view('warga.pesan.berhasil', compact('pesanan'));
    }
}
