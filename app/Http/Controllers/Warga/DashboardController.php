<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PesananPengangkutan;
use App\Models\RiwayatKoin;
use App\Models\RiwayatStatusPesanan;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Saldo koin warga
        $saldoKoin = $user->saldo_koin;
        $namaUser = $user->nama;

        // Pesanan aktif (status diproses) - untuk tracker "Pesanan Sedang Diproses"
        $pesananAktif = PesananPengangkutan::where('warga_id', $user->id)
            ->where('status', 'diproses')
            ->with('riwayatStatus')
            ->latest()
            ->first();

        // Pesanan hold_kapasitas - untuk banner "Pembayaran Tambahan"
        $pesananHoldKapasitas = PesananPengangkutan::where('warga_id', $user->id)
            ->where('status', 'hold_kapasitas')
            ->latest()
            ->first();

        // Pesanan gagal_pickup - untuk banner "Gagal Pickup"
        $pesananGagalPickup = PesananPengangkutan::where('warga_id', $user->id)
            ->where('status', 'gagal_pickup')
            ->latest()
            ->first();

        // Riwayat koin untuk modal
        $riwayatKoin = RiwayatKoin::where('warga_id', $user->id)
            ->latest()
            ->take(20)
            ->get();

        // Pengaturan Sistem
        $pengaturan = \App\Models\PengaturanSistem::first();

        return view('warga.dashboard', compact(
            'saldoKoin',
            'namaUser',
            'pesananAktif',
            'pesananHoldKapasitas',
            'pesananGagalPickup',
            'riwayatKoin',
            'pengaturan'
        ));
    }

    public function bayarSelisih(Request $request, $id)
    {
        $user = Auth::user();
        
        $pesanan = PesananPengangkutan::where('id', $id)
            ->where('warga_id', $user->id)
            ->where('status', 'hold_kapasitas')
            ->firstOrFail();

        // Update payment status
        $pesanan->status_pembayaran = 'paid';
        
        // Return back to menunggu status
        $pesanan->status = 'menunggu';
        
        // Reschedule to next working day
        $nextDate = Carbon::today()->addWeekday();
        $pesanan->tanggal_penjemputan = $nextDate;
        $pesanan->nama_hari_penjemputan = $nextDate->translatedFormat('l');
        
        $pesanan->save();

        // Add history
        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan->id,
            'status' => 'menunggu',
            'keterangan' => 'Pembayaran selisih sebesar Rp' . number_format($pesanan->selisih_harga, 0, ',', '.') . ' berhasil. Jadwal penjemputan diundur ke ' . $nextDate->translatedFormat('l, d M Y') . '.',
            'created_at' => now(),
        ]);

        // Send Notification
        NotificationService::send(
            $user->id,
            'Pembayaran Selisih Berhasil',
            "Pembayaran selisih untuk pesanan #{$pesanan->id} telah diterima. Jadwal penjemputan Anda diundur ke " . $nextDate->translatedFormat('l, d M Y') . ".",
            'success'
        );

        return redirect()->route('warga.dashboard')->with('success', 'Pembayaran berhasil. Jadwal pengangkutan telah diperbarui.');
    }
}
