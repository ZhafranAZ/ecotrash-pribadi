<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Komplek;
use App\Models\AlamatWarga;
use App\Models\PengaturanSistem;
use App\Models\PesananPengangkutan;
use App\Models\RiwayatStatusPesanan;
use App\Models\LaporanSampahLiar;
use App\Models\Notifikasi;
use App\Models\RiwayatKoin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. Create 2 Komplek
        // =============================================
        $komplek1 = Komplek::create([
            'nama_komplek' => 'Green Valley Residence',
            'lat' => -6.9175000,
            'lng' => 107.6191000,
        ]);

        $komplek2 = Komplek::create([
            'nama_komplek' => 'Permata Hijau Permai',
            'lat' => -6.9250000,
            'lng' => 107.6350000,
        ]);

        // =============================================
        // 2. Create 3 Users (password: 'password' for all)
        // =============================================
        $admin = User::create([
            'nama' => 'Admin EcoTrash',
            'email' => 'admin@ecotrash.id',
            'no_telepon' => '081200000001',
            'password' => 'password',
            'role' => 'admin',
            'saldo_koin' => 0,
        ]);

        $warga = User::create([
            'nama' => 'Budi Santoso',
            'email' => 'warga@ecotrash.id',
            'no_telepon' => '081200000002',
            'password' => 'password',
            'role' => 'warga',
            'saldo_koin' => 450,
        ]);

        $petugas = User::create([
            'nama' => 'Ahmad Petugas',
            'email' => 'petugas@ecotrash.id',
            'no_telepon' => '081200000003',
            'password' => 'password',
            'role' => 'petugas',
            'status_kehadiran' => 'aktif',
            'saldo_koin' => 0,
        ]);

        // =============================================
        // 3. Create 1 Alamat for Warga (is_utama=true)
        // =============================================
        AlamatWarga::create([
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'nama_alamat' => 'Rumah Utama',
            'blok_nomor_rumah' => 'Blok B4 No. 12',
            'detail_patokan' => 'Pagar hitam, depan taman bermain',
            'is_utama' => true,
        ]);

        // =============================================
        // 4. Assign Petugas to Komplek (pivot)
        // =============================================
        $petugas->petugasKomplek()->attach([$komplek1->id, $komplek2->id]);

        // =============================================
        // 5. Create default PengaturanSistem
        // =============================================
        PengaturanSistem::create([
            'konversi_koin_rupiah' => 500,
            'harga_kategori_kecil' => 15000,
            'harga_kategori_sedang' => 25000,
            'harga_kategori_besar' => 40000,
            'bonus_koin_kecil' => 5,
            'bonus_koin_sedang' => 10,
            'bonus_koin_besar' => 15,
            'batas_waktu_pesan' => '17:00',
            'kuota_pesanan_harian' => 50,
            'hari_operasional' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
        ]);

        // =============================================
        // 6. Dummy Pesanan Pengangkutan (3 pesanan, variasi status)
        // =============================================
        $pesanan1Id = 'INV-' . now()->format('dmy') . '-001';
        $pesanan1 = PesananPengangkutan::create([
            'id' => $pesanan1Id,
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'nama_alamat_snapshot' => 'Rumah Utama',
            'blok_nomor_rumah' => 'Blok B4 No. 12',
            'detail_patokan_snapshot' => 'Pagar hitam, depan taman bermain',
            'kategori_sampah' => 'besar',
            'tanggal_penjemputan' => today(),
            'nama_hari_penjemputan' => today()->translatedFormat('l'),
            'catatan_warga' => 'Tolong angkut semua kardus di depan pagar.',
            'koin_digunakan' => 50,
            'koin_didapat' => 0,
            'harga_awal' => 40000,
            'total_harga_akhir' => 35000,
            'selisih_harga' => 0,
            'status' => 'diproses',
            'status_pembayaran' => 'paid',
            'metode_pembayaran' => 'qris',
            'petugas_id' => $petugas->id,
            'created_at' => now()->subHours(2),
        ]);

        // Riwayat status pesanan 1
        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan1Id,
            'status' => 'menunggu',
            'keterangan' => 'Pesanan telah dikonfirmasi dan menunggu penugasan petugas.',
            'created_at' => now()->subHours(2),
        ]);
        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan1Id,
            'status' => 'diproses',
            'keterangan' => 'Petugas Ahmad sedang menuju lokasi Anda.',
            'created_at' => now()->subMinutes(30),
        ]);

        // Pesanan 2: Selesai (beberapa hari lalu)
        $pesanan2Id = 'INV-' . now()->subDays(5)->format('dmy') . '-001';
        $pesanan2 = PesananPengangkutan::create([
            'id' => $pesanan2Id,
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'nama_alamat_snapshot' => 'Rumah Utama',
            'blok_nomor_rumah' => 'Blok B4 No. 12',
            'detail_patokan_snapshot' => 'Pagar hitam, depan taman bermain',
            'kategori_sampah' => 'kecil',
            'tanggal_penjemputan' => today()->subDays(5),
            'nama_hari_penjemputan' => today()->subDays(5)->translatedFormat('l'),
            'catatan_warga' => null,
            'koin_digunakan' => 0,
            'koin_didapat' => 5,
            'harga_awal' => 15000,
            'total_harga_akhir' => 15000,
            'selisih_harga' => 0,
            'status' => 'selesai',
            'status_pembayaran' => 'paid',
            'metode_pembayaran' => 'transfer_bank',
            'petugas_id' => $petugas->id,
            'foto_bukti_selesai' => null,
            'created_at' => now()->subDays(5),
        ]);

        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan2Id,
            'status' => 'menunggu',
            'keterangan' => 'Pesanan telah dikonfirmasi.',
            'created_at' => now()->subDays(5),
        ]);
        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan2Id,
            'status' => 'diproses',
            'keterangan' => 'Petugas Ahmad sedang menuju lokasi.',
            'created_at' => now()->subDays(5)->addHours(1),
        ]);
        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan2Id,
            'status' => 'selesai',
            'keterangan' => 'Pengangkutan selesai. Koin +5 telah ditambahkan.',
            'created_at' => now()->subDays(5)->addHours(2),
        ]);

        // Pesanan 3: Menunggu (hari ini juga, untuk stat admin)
        $pesanan3Id = 'INV-' . now()->format('dmy') . '-002';
        PesananPengangkutan::create([
            'id' => $pesanan3Id,
            'warga_id' => $warga->id,
            'komplek_id' => $komplek2->id,
            'nama_alamat_snapshot' => 'Rumah Utama',
            'blok_nomor_rumah' => 'Blok B4 No. 12',
            'detail_patokan_snapshot' => 'Pagar hitam',
            'kategori_sampah' => 'sedang',
            'tanggal_penjemputan' => today()->addDays(1),
            'nama_hari_penjemputan' => today()->addDays(1)->translatedFormat('l'),
            'catatan_warga' => null,
            'koin_digunakan' => 0,
            'koin_didapat' => 0,
            'harga_awal' => 25000,
            'total_harga_akhir' => 25000,
            'selisih_harga' => 0,
            'status' => 'menunggu',
            'status_pembayaran' => 'paid',
            'metode_pembayaran' => 'qris',
            'created_at' => now()->subHours(1),
        ]);

        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan3Id,
            'status' => 'menunggu',
            'keterangan' => 'Pesanan telah dikonfirmasi dan menunggu penugasan petugas.',
            'created_at' => now()->subHours(1),
        ]);

        // Pesanan 4: Hold Kapasitas (untuk test banner "Pembayaran Tambahan")
        $pesanan4Id = 'INV-' . now()->format('dmy') . '-003';
        PesananPengangkutan::create([
            'id' => $pesanan4Id,
            'warga_id' => $warga->id,
            'komplek_id' => $komplek2->id,
            'nama_alamat_snapshot' => 'Rumah Utama',
            'blok_nomor_rumah' => 'Blok B4 No. 12',
            'detail_patokan_snapshot' => 'Pagar hitam',
            'kategori_sampah' => 'kecil',
            'tanggal_penjemputan' => today()->subDays(1),
            'nama_hari_penjemputan' => today()->subDays(1)->translatedFormat('l'),
            'catatan_warga' => null,
            'koin_digunakan' => 0,
            'koin_didapat' => 0,
            'harga_awal' => 15000,
            'total_harga_akhir' => 30000,
            'selisih_harga' => 15000,
            'status' => 'hold_kapasitas',
            'status_pembayaran' => 'unpaid',
            'metode_pembayaran' => 'qris',
            'petugas_id' => $petugas->id,
            'alasan_kendala' => 'Ukuran sampah aktual lebih besar dari pesanan (kecil -> sedang)',
            'created_at' => now()->subHours(3),
        ]);

        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan4Id,
            'status' => 'menunggu',
            'keterangan' => 'Pesanan telah dikonfirmasi.',
            'created_at' => now()->subHours(3),
        ]);
        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan4Id,
            'status' => 'diproses',
            'keterangan' => 'Petugas sedang menuju lokasi.',
            'created_at' => now()->subHours(3)->addMinutes(30),
        ]);
        RiwayatStatusPesanan::create([
            'pesanan_id' => $pesanan4Id,
            'status' => 'hold_kapasitas',
            'keterangan' => 'Sampah aktual lebih besar. Menunggu pembayaran selisih Rp15.000.',
            'created_at' => now()->subHours(2),
        ]);

        // =============================================
        // 7. Dummy Laporan Sampah Liar (2 laporan)
        // =============================================
        LaporanSampahLiar::create([
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'lat' => -6.918,
            'lng' => 107.615,
            'alamat_lokasi' => 'Lahan Kosong Blok C, Jl. Mawar Merah No. 12',
            'deskripsi' => 'Sampah plastik menumpuk dan bau menyengat di lahan kosong pinggir jalan. Sudah ada sekitar 3 hari tidak diangkut.',
            'foto_laporan_warga' => 'laporan/placeholder.jpg',
            'status' => 'menunggu',
            'koin_reward' => 0,
            'created_at' => now()->subDays(2),
        ]);

        LaporanSampahLiar::create([
            'warga_id' => $warga->id,
            'komplek_id' => $komplek2->id,
            'lat' => -6.920,
            'lng' => 107.608,
            'alamat_lokasi' => 'Pinggir Sungai Dekat RT 05',
            'deskripsi' => 'Tumpukan sampah rumah tangga di pinggir sungai, menghalangi aliran air. Perlu segera ditangani.',
            'foto_laporan_warga' => 'laporan/placeholder2.jpg',
            'status' => 'disetujui',
            'petugas_id' => $petugas->id,
            'koin_reward' => 10,
            'created_at' => now()->subDays(7),
        ]);

        // =============================================
        // 8. Dummy Notifikasi untuk Warga
        // =============================================
        Notifikasi::create([
            'user_id' => $warga->id,
            'judul' => 'Pesanan Sedang Diproses',
            'pesan' => 'Pesanan #' . $pesanan1Id . ' sedang dalam proses pengangkutan. Petugas Ahmad sedang menuju lokasi Anda.',
            'tipe' => 'info',
            'is_read' => false,
            'created_at' => now()->subMinutes(30),
        ]);

        Notifikasi::create([
            'user_id' => $warga->id,
            'judul' => 'Pesanan Selesai!',
            'pesan' => 'Pesanan #' . $pesanan2Id . ' telah selesai. Koin sebesar 5 telah ditambahkan ke saldo Anda.',
            'tipe' => 'success',
            'is_read' => false,
            'created_at' => now()->subDays(5),
        ]);

        Notifikasi::create([
            'user_id' => $warga->id,
            'judul' => 'Laporan Diterima',
            'pesan' => 'Laporan sampah liar di Lahan Kosong Blok C sedang ditinjau oleh admin.',
            'tipe' => 'info',
            'is_read' => true,
            'created_at' => now()->subDays(2),
        ]);

        Notifikasi::create([
            'user_id' => $warga->id,
            'judul' => 'Laporan Disetujui!',
            'pesan' => 'Laporan sampah liar di Pinggir Sungai Dekat RT 05 telah disetujui. Koin reward +10 telah ditambahkan.',
            'tipe' => 'success',
            'is_read' => true,
            'created_at' => now()->subDays(6),
        ]);

        Notifikasi::create([
            'user_id' => $warga->id,
            'judul' => 'Selamat Datang di EcoTrash!',
            'pesan' => 'Lengkapi profil Anda dan mulai bantu ciptakan lingkungan yang lebih bersih.',
            'tipe' => 'info',
            'is_read' => true,
            'created_at' => now()->subDays(14),
        ]);

        // =============================================
        // 9. Dummy Notifikasi untuk Admin
        // =============================================
        Notifikasi::create([
            'user_id' => $admin->id,
            'judul' => 'Pesanan Baru Masuk',
            'pesan' => 'Budi Santoso membuat pesanan pengangkutan baru — Komplek Green Valley Residence.',
            'tipe' => 'info',
            'is_read' => false,
            'created_at' => now()->subMinutes(10),
        ]);

        Notifikasi::create([
            'user_id' => $admin->id,
            'judul' => 'Laporan Baru Menunggu Verifikasi',
            'pesan' => 'Budi Santoso melaporkan tumpukan sampah di Lahan Kosong Blok C. Perlu ditinjau.',
            'tipe' => 'warning',
            'is_read' => false,
            'created_at' => now()->subDays(2),
        ]);

        Notifikasi::create([
            'user_id' => $admin->id,
            'judul' => 'Tugas Petugas Selesai',
            'pesan' => 'Ahmad Petugas menyelesaikan 1 tugas pengangkutan hari ini.',
            'tipe' => 'success',
            'is_read' => true,
            'created_at' => now()->subDays(5),
        ]);

        // =============================================
        // 10. Dummy Riwayat Koin untuk Warga
        // =============================================
        RiwayatKoin::create([
            'warga_id' => $warga->id,
            'tipe_transaksi' => 'masuk',
            'jumlah' => 350,
            'sumber' => 'sistem',
            'referensi_id' => null,
            'expired_at' => now()->addMonths(6),
            'created_at' => now()->subDays(30),
        ]);

        RiwayatKoin::create([
            'warga_id' => $warga->id,
            'tipe_transaksi' => 'masuk',
            'jumlah' => 100,
            'sumber' => 'pesanan',
            'referensi_id' => $pesanan2Id,
            'expired_at' => now()->addMonths(6),
            'created_at' => now()->subDays(20),
        ]);

        RiwayatKoin::create([
            'warga_id' => $warga->id,
            'tipe_transaksi' => 'keluar',
            'jumlah' => 50,
            'sumber' => 'penukaran',
            'referensi_id' => $pesanan1Id,
            'expired_at' => null,
            'created_at' => now()->subDays(10),
        ]);

        RiwayatKoin::create([
            'warga_id' => $warga->id,
            'tipe_transaksi' => 'masuk',
            'jumlah' => 5,
            'sumber' => 'pesanan',
            'referensi_id' => $pesanan2Id,
            'expired_at' => now()->addMonths(6),
            'created_at' => now()->subDays(5),
        ]);

        RiwayatKoin::create([
            'warga_id' => $warga->id,
            'tipe_transaksi' => 'masuk',
            'jumlah' => 10,
            'sumber' => 'laporan_liar',
            'referensi_id' => '2',
            'expired_at' => now()->addMonths(6),
            'created_at' => now()->subDays(6),
        ]);

        RiwayatKoin::create([
            'warga_id' => $warga->id,
            'tipe_transaksi' => 'masuk',
            'jumlah' => 50,
            'sumber' => 'sistem',
            'referensi_id' => null,
            'expired_at' => now()->addMonths(6),
            'created_at' => now()->subDays(35),
        ]);
    }
}
