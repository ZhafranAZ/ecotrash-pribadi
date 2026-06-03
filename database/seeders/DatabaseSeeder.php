<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Komplek;
use App\Models\AlamatWarga;
use App\Models\PengaturanSistem;
use App\Models\PesananPengangkutan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create 2 Komplek
        $komplek1 = Komplek::create([
            'nama_komplek' => 'Perumahan Asri Indah',
            'lat' => -6.9175000,
            'lng' => 107.6191000,
        ]);

        $komplek2 = Komplek::create([
            'nama_komplek' => 'Komp. Permata Hijau',
            'lat' => -6.9250000,
            'lng' => 107.6350000,
        ]);

        // 2. Create 3 Users (password: 'password' for all)
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
            'saldo_koin' => 500,
        ]);

        $petugas = User::create([
            'nama' => 'Ahmad Sobari',
            'email' => 'petugas@ecotrash.id',
            'no_telepon' => '081200000003',
            'password' => 'password',
            'role' => 'petugas',
            'status_kehadiran' => 'aktif',
            'saldo_koin' => 0,
        ]);

        $petugas2 = User::create([
            'nama' => 'Jajang Suryana',
            'email' => 'petugas2@ecotrash.id',
            'no_telepon' => '081200000004',
            'password' => 'password',
            'role' => 'petugas',
            'status_kehadiran' => 'aktif',
            'saldo_koin' => 0,
        ]);

        // 3. Create Alamat for Warga
        AlamatWarga::create([
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'nama_alamat' => 'Rumah',
            'blok_nomor_rumah' => 'Blok C2 No. 15',
            'detail_patokan' => 'RT 04 RW 02, Kec. Sukajadi',
            'is_utama' => true,
        ]);

        AlamatWarga::create([
            'warga_id' => $warga->id,
            'komplek_id' => $komplek2->id,
            'nama_alamat' => 'Kantor',
            'blok_nomor_rumah' => 'Gedung X Lt. 4',
            'detail_patokan' => 'Sudirman, Jakarta',
            'is_utama' => false,
        ]);

        // 4. Assign Petugas to Komplek (pivot)
        // Dikosongkan untuk testing fitur "Assign Petugas" dari Admin
        // $petugas->petugasKomplek()->attach([$komplek1->id]);
        // $petugas2->petugasKomplek()->attach([$komplek2->id]);

        // 5. Create default PengaturanSistem
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

        // 6. Create Dummy Pesanan Pengangkutan
        // Skenario 1: Menunggu di Perumahan Asri Indah (2 pesanan)
        PesananPengangkutan::create([
            'id' => 'INV-' . now()->format('Ymd') . '-001',
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'nama_alamat_snapshot' => 'Rumah',
            'blok_nomor_rumah' => 'Blok C2 No. 15',
            'detail_patokan_snapshot' => 'RT 04 RW 02, Kec. Sukajadi',
            'kategori_sampah' => 'kecil',
            'tanggal_penjemputan' => today(),
            'nama_hari_penjemputan' => 'Rabu', // contoh hari
            'catatan_warga' => 'Tolong ambil di depan pagar ya',
            'status' => 'menunggu',
            'status_pembayaran' => 'paid',
            'metode_pembayaran' => 'qris',
            'harga_awal' => 15000,
            'total_harga_akhir' => 15000,
            'koin_didapat' => 0,
        ]);

        PesananPengangkutan::create([
            'id' => 'INV-' . now()->format('Ymd') . '-002',
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'nama_alamat_snapshot' => 'Rumah',
            'blok_nomor_rumah' => 'Blok C2 No. 15',
            'detail_patokan_snapshot' => 'RT 04 RW 02, Kec. Sukajadi',
            'kategori_sampah' => 'sedang',
            'tanggal_penjemputan' => today(),
            'nama_hari_penjemputan' => 'Rabu',
            'status' => 'menunggu',
            'status_pembayaran' => 'paid',
            'metode_pembayaran' => 'transfer_bank',
            'harga_awal' => 25000,
            'total_harga_akhir' => 25000,
            'koin_didapat' => 0,
        ]);

        // Skenario 2: Menunggu di Komp. Permata Hijau (belum ada petugas)
        PesananPengangkutan::create([
            'id' => 'INV-' . now()->format('Ymd') . '-003',
            'warga_id' => $warga->id,
            'komplek_id' => $komplek2->id,
            'nama_alamat_snapshot' => 'Kantor',
            'blok_nomor_rumah' => 'Gedung X Lt. 4',
            'detail_patokan_snapshot' => 'Sudirman, Jakarta',
            'kategori_sampah' => 'besar',
            'tanggal_penjemputan' => today(),
            'nama_hari_penjemputan' => now()->translatedFormat('l'),
            'status' => 'menunggu',
            'status_pembayaran' => 'paid',
            'metode_pembayaran' => 'qris',
            'harga_awal' => 40000,
            'total_harga_akhir' => 40000,
            'koin_didapat' => 0,
        ]);

        // Skenario 3: Menunggu di Perumahan Asri Indah (belum ada petugas)
        PesananPengangkutan::create([
            'id' => 'INV-' . now()->format('Ymd') . '-004',
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'nama_alamat_snapshot' => 'Rumah',
            'blok_nomor_rumah' => 'Blok C2 No. 15',
            'detail_patokan_snapshot' => 'RT 04 RW 02, Kec. Sukajadi',
            'kategori_sampah' => 'kecil',
            'tanggal_penjemputan' => today(),
            'nama_hari_penjemputan' => 'Rabu',
            'status' => 'menunggu',
            'status_pembayaran' => 'paid',
            'metode_pembayaran' => 'transfer_bank',
            'harga_awal' => 15000,
            'total_harga_akhir' => 15000,
            'koin_didapat' => 0,
        ]);
    }
}
