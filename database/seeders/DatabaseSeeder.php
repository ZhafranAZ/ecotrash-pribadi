<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Komplek;
use App\Models\AlamatWarga;
use App\Models\PengaturanSistem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create 2 Komplek
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
            'nama' => 'Ahmad Petugas',
            'email' => 'petugas@ecotrash.id',
            'no_telepon' => '081200000003',
            'password' => 'password',
            'role' => 'petugas',
            'status_kehadiran' => 'aktif',
            'saldo_koin' => 0,
        ]);

        // 3. Create 1 Alamat for Warga (is_utama=true)
        AlamatWarga::create([
            'warga_id' => $warga->id,
            'komplek_id' => $komplek1->id,
            'nama_alamat' => 'Rumah Utama',
            'blok_nomor_rumah' => 'Blok B4 No. 12',
            'detail_patokan' => 'Pagar hitam, depan taman bermain',
            'is_utama' => true,
        ]);

        // 4. Assign Petugas to Komplek (pivot)
        $petugas->petugasKomplek()->attach([$komplek1->id, $komplek2->id]);

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
    }
}
