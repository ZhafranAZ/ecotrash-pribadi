# Blueprint Arsitektur Database EcoTrash

Dokumen ini memuat rancangan skema basis data (*Database Schema*) untuk proyek EcoTrash, didasarkan pada dokumen kebutuhan (PRD) dan spesifikasi antarmuka Warga, Admin, serta Petugas.

---

## 1. Entity Relationship Diagram (ERD)

Berikut adalah visualisasi relasi antar entitas utama menggunakan sintaks Mermaid.

```mermaid
erDiagram
    USERS ||--o{ ALAMAT_WARGA : memiliki
    USERS ||--o{ PESANAN : "membuat (warga)"
    USERS ||--o{ PESANAN : "menangani (petugas)"
    USERS ||--o{ LAPORAN : "melaporkan (warga)"
    USERS ||--o{ LAPORAN : "menyelesaikan (petugas)"
    USERS }o--o{ ARTIKEL : "bookmark (warga)"
    USERS ||--o{ NOTIFIKASI : "menerima"
    
    KOMPLEK ||--o{ ALAMAT_WARGA : "terletak di"
    KOMPLEK ||--o{ PESANAN : "lokasi pesanan"
    KOMPLEK ||--o{ LAPORAN : "lokasi laporan"
    KOMPLEK ||--o{ USERS : "area tugas (petugas)"

    PESANAN ||--o{ RIWAYAT_PESANAN : "memiliki track"

    ALAMAT_WARGA }|..|| USERS : "user_id"
    PESANAN }|..|| USERS : "warga_id / petugas_id"
    NOTIFIKASI }|..|| USERS : "user_id"
```

---

## 2. Spesifikasi Tabel dan Kolom

### 1. `users` (Tabel Induk Autentikasi Warga, Petugas, Admin)
Menyimpan semua akun pengguna dengan pemisahan akses menggunakan kolom `role`.
- `id` (Primary Key, BigInt)
- `nama` (String)
- `email` (String, Unique)
- `no_telepon` (String, Nullable) -> *Wajib diisi saat daftar warga, bisa diubah di pengaturan*
- `foto_profil` (String/URL, Nullable)
- `password` (String, Hashed)
- `role` (Enum: 'admin', 'warga', 'petugas')
- `saldo_koin` (Integer, Default: 0) -> *Hanya untuk warga*
- `status_kehadiran` (Enum: 'aktif', 'berhalangan') -> *Hanya untuk petugas*
- `alasan_berhalangan` (Text, Nullable) -> *Diisi jika petugas mengajukan status berhalangan*
- `created_at`, `updated_at` (Timestamp)

### 1a. `petugas_komplek` (Tabel Pivot Area Tugas)
Menyimpan relasi multi-area penugasan untuk role Petugas (1 Petugas bisa handle banyak komplek).
- `petugas_id` (Foreign Key -> `users.id`)
- `komplek_id` (Foreign Key -> `komplek.id`)
- `created_at` (Timestamp)

### 2. `komplek` (Master Data Komplek)
- `id` (Primary Key, BigInt)
- `nama_komplek` (String)
- `lat` (Decimal) -> *Koordinat Peta*
- `lng` (Decimal) -> *Koordinat Peta*
- `created_at`, `updated_at` (Timestamp)

### 3. `alamat_warga`
Satu warga bisa memiliki lebih dari satu alamat tersimpan.
- `id` (Primary Key, BigInt)
- `warga_id` (Foreign Key -> `users.id`)
- `komplek_id` (Foreign Key -> `komplek.id`)
- `nama_alamat` (String) -> *Cth: Rumah, Kantor*
- `blok_nomor_rumah` (String) -> *Alamat lengkap*
- `detail_patokan` (Text, Nullable) -> *Cth: Pagar Hitam, Depan Warung*
- `is_utama` (Boolean, Default: false)
- `created_at`, `updated_at` (Timestamp)

### 4. `pengaturan_sistem`
Tabel *single-row* atau *key-value* untuk menyimpan konfigurasi dari Admin.
- `id` (Primary Key, BigInt)
- `konversi_koin_rupiah` (Integer) -> *Berapa Rp untuk 1 koin*
- `harga_kategori_kecil` (Integer)
- `harga_kategori_sedang` (Integer)
- `harga_kategori_besar` (Integer)
- `bonus_koin_kecil` (Integer)
- `bonus_koin_sedang` (Integer)
- `bonus_koin_besar` (Integer)
- `batas_waktu_pesan` (Time) -> *Cut-off time pesanan harian*
- `kuota_pesanan_harian` (Integer)
- `hari_operasional` (JSON) -> *Contoh: ["Senin", "Selasa", "Kamis"]*
- `created_at`, `updated_at` (Timestamp)

### 5. `pesanan_pengangkutan`
Tabel transaksi utama untuk layanan angkut sampah.
- `id` (Primary Key, UUID/String) -> *Bisa diformat sebagai resi, misal: INV-1234*
- `warga_id` (Foreign Key -> `users.id`)
- `komplek_id` (Foreign Key -> `komplek.id`)
- `nama_alamat_snapshot` (String) -> *Snapshot nama alamat (cth: Rumah Utama)*
- `blok_nomor_rumah` (String) -> *Snapshotted saat pesan, berjaga-jaga jika alamat warga dihapus*
- `detail_patokan_snapshot` (Text, Nullable) -> *Snapshot patokan alamat*
- `kategori_sampah` (Enum: 'kecil', 'sedang', 'besar')
- `tanggal_penjemputan` (Date)
- `nama_hari_penjemputan` (String)
- `catatan_warga` (Text, Nullable)
- `koin_digunakan` (Integer, Default: 0)
- `koin_didapat` (Integer, Default: 0) -> *Koin reward setelah selesai*
- `harga_awal` (Integer) -> *Harga saat pesanan dibuat*
- `total_harga_akhir` (Integer) -> *Harga setelah perubahan ukuran*
- `selisih_harga` (Integer, Default: 0) -> *Beda harga awal dan akhir*
- `status` (Enum: 'menunggu_pembayaran', 'menunggu_pembayaran_selisih', 'menunggu', 'diproses', 'selesai', 'dibatalkan', 'hold_kapasitas', 'gagal_pickup')
- `status_pembayaran` (Enum: 'unpaid', 'paid', 'failed')
- `metode_pembayaran` (Enum: 'qris', 'transfer_bank')
- `payment_reference` (String, Nullable) -> *Menyimpan ID transaksi dari Payment Gateway (misal QRIS)*
- `petugas_id` (Foreign Key -> `users.id`, Nullable) -> *Di-assign oleh admin setelah paid*
- `ukuran_aktual_laporan_petugas` (Enum: 'sedang', 'besar', Nullable) -> *Terisi jika ada kasus beda ukuran*
- `alasan_kendala` (Text, Nullable) -> *Catatan saat petugas menemui kendala (cth: pagar tertutup)*
- `foto_kendala` (String/URL, Nullable) -> *Foto bukti kendala*
- `foto_bukti_selesai` (String/URL, Nullable)
- `created_at`, `updated_at` (Timestamp)

### 6. `laporan_sampah_liar`
Tabel untuk penanganan sampah ilegal.
- `id` (Primary Key, BigInt)
- `warga_id` (Foreign Key -> `users.id`)
- `komplek_id` (Foreign Key -> `komplek.id`, Nullable) -> *Diisi otomatis oleh backend berdasarkan koordinat*
- `lat` (Decimal)
- `lng` (Decimal)
- `alamat_lokasi` (String, Nullable) -> *Teks alamat hasil konversi Reverse Geocoding*
- `deskripsi` (Text)
- `foto_laporan_warga` (String/URL)
- `status` (Enum: 'menunggu', 'disetujui', 'ditolak', 'sedang_dibersihkan', 'selesai')
- `koin_reward` (Integer, Default: 0) -> *Koin yang diberikan admin jika disetujui*
- `petugas_id` (Foreign Key -> `users.id`, Nullable) -> *Petugas yang menangani*
- `foto_bukti_selesai_petugas` (String/URL, Nullable)
- `created_at`, `updated_at` (Timestamp)

### 7. `artikel_edukasi`
- `id` (Primary Key, BigInt)
- `judul` (String)
- `kategori` (String)
- `gambar_thumbnail` (String/URL)
- `konten_html` (LongText)
- `penulis_admin_id` (Foreign Key -> `users.id`)
- `created_at`, `updated_at` (Timestamp)

### 8. `bookmark_artikel` (Tabel Pivot)
- `warga_id` (Foreign Key -> `users.id`)
- `artikel_id` (Foreign Key -> `artikel_edukasi.id`)
- `created_at` (Timestamp)

### 9. `notifikasi`
Tabel untuk menyimpan notifikasi persisten yang muncul di panel bel/lonceng Warga maupun Admin.
- `id` (Primary Key, BigInt)
- `user_id` (Foreign Key -> `users.id`)
- `reference_id` (BigInt, Nullable) -> *ID entitas terkait (misal ID pesanan atau laporan)*
- `reference_type` (String, Nullable) -> *Tipe referensi (misal: 'pesanan', 'laporan')*
- `judul` (String)
- `pesan` (Text)
- `tipe` (Enum: 'info', 'warning', 'success', 'error')
- `is_read` (Boolean, Default: false)
- `created_at` (Timestamp)

### 10. `riwayat_status_pesanan`
Tabel untuk merekam audit trail atau rekam jejak status pesanan pengangkutan, digunakan untuk fitur modal pelacakan/tracking waktu real-time.
- `id` (Primary Key, BigInt)
- `pesanan_id` (Foreign Key -> `pesanan_pengangkutan.id`)
- `status` (Enum: 'menunggu_pembayaran', 'menunggu_pembayaran_selisih', 'menunggu', 'diproses', 'selesai', 'dibatalkan', 'hold_kapasitas', 'gagal_pickup')
- `keterangan` (Text, Nullable) -> *Pesan tambahan (cth: "Pesanan telah dikonfirmasi dan menunggu penugasan petugas")*
- `created_at` (Timestamp)
