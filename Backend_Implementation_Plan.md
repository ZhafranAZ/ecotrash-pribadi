# Rencana Pembagian Tugas Backend & Database (8 Modul)

Berdasarkan diskusi kita, karena tim terdiri dari **7 orang**, alur kerjanya akan dibagi menjadi **8 bagian**. 

Pendekatannya adalah: **Modul 1 (Utama)** akan dikerjakan di awal sebagai fondasi (membuat *database schema* utuh dan *login*). Setelah Modul 1 selesai dan digabungkan ke kode utama, barulah 7 anggota tim lainnya (Modul 2 hingga 8) mulai bekerja secara paralel secara mandiri di bagian masing-masing, karena tampilan (Frontend/Blade) sudah siap 100%.

---

## 🏗️ Pembagian 8 Modul Backend

### 🥇 FASE 1: Fondasi Wajib (Selesai Paling Awal)

#### **Modul 1: Setup Core Database & Autentikasi** (Oleh 1 Orang Utama)
*Modul ini wajib selesai lebih dulu. Setelah selesai, seluruh file di-push ke GitHub agar anggota tim lain bisa melakukan `git pull` dan mendapatkan struktur database + fitur login yang sama.*
* **Fokus Database:** Membuat **SELURUH** file Migration (tabel) berdasarkan `Database_Schema.md` agar struktur DB terbentuk sempurna.
* **Tugas Implementasi:**
  * Setup Laravel Breeze/Jetstream untuk *Login/Register*.
  * Membuat Middleware pemisah akses: `role=warga`, `role=petugas`, `role=admin`.
  * Membuat *Seeder* awal (Akun dummy untuk Warga, Admin, Petugas, serta data `komplek` dan `pengaturan_sistem` agar fitur lain bisa diuji).

---

### 🚀 FASE 2: Pengembangan Paralel (Untuk 7 Orang)

Setelah Modul 1 selesai, 7 orang berikut bisa bekerja berbarengan (*Parallel Development*) di laptop masing-masing.

#### **Modul 2: Profil Warga & Manajemen Akun** (Anggota 1)
*Fokus pada data personal dan Master Data pengguna.*
* **(Warga)**: Edit Profil pengguna (Nama, No Telepon).
* **(Warga)**: CRUD Alamat Warga (Tambah alamat rumah, ubah detail, dan tandai alamat utama).
* **(Admin)**: Halaman kelola data Warga, CRUD Komplek, dan pembuatan/edit Akun Petugas.

#### **Modul 3: Pemesanan Pengangkutan - Sisi Warga** (Anggota 2)
*Fokus pada form pembuatan order (keranjang belanja/checkout).*
* **(Warga)**: Logic form pemesanan (mengambil alamat utama, kalkulasi harga berdasarkan kategori ukuran dari pengaturan sistem).
* **(Warga)**: Kalkulasi potongan diskon menggunakan *Koin* warga (maks 50%).
* **(Warga)**: Simulasi pembayaran lunas dan validasi batas kuota/cut-off time pesanan harian. `Insert` data ke tabel `pesanan_pengangkutan`.

#### **Modul 4: Operasional Pengangkutan - Sisi Petugas & Admin** (Anggota 3)
*Fokus pada tindak lanjut pesanan yang sudah dibuat di Modul 3.*
* **(Petugas)**: Menampilkan list/daftar tugas penjemputan sampah hari ini.
* **(Petugas)**: Update status dari "Diproses" ke "Selesai", beserta validasi upload foto bukti.
* **(Petugas)**: Logic pelaporan jika ada kendala (pagar tutup, beda ukuran sampah).
* **(Admin)**: Menampilkan tabel daftar pesanan warga.

#### **Modul 5: Pelaporan Sampah Liar - Warga & Admin** (Anggota 4)
*Fokus pada tahap awal sistem Ticketing.*
* **(Warga)**: Logic form lapor sampah liar (Menangkap titik Longitude/Latitude Leaflet.js, upload foto kondisi).
* **(Admin)**: Menampilkan daftar laporan masuk. Logic untuk "Menyetujui" (beri koin ke warga & oper tugas ke Petugas) atau "Menolak" laporan.

#### **Modul 6: Tindak Lanjut Sampah Liar - Sisi Petugas** (Anggota 5)
*Fokus pada tahap penyelesaian Ticketing laporan dari Modul 5.*
* **(Petugas)**: Menampilkan daftar tugas area sampah liar yang harus dibersihkan.
* **(Petugas)**: Logic update status selesai dengan upload foto bukti pembersihan (Update status di tabel `laporan_sampah_liar`).
* **(Sistem Koin Terpusat)**: Anggota ini juga menangani sistem koin (Fungsi menambah koin Warga saat tugas selesai, mengurangi koin saat transaksi, dan *Cron Job* expired 6 bulan).

#### **Modul 7: Edukasi Lingkungan & Bookmark** (Anggota 6)
*Fokus pada Sistem Manajemen Konten (CMS).*
* **(Admin)**: CRUD (Create, Read, Update, Delete) Artikel Edukasi, upload gambar thumbnail, pakai text-editor.
* **(Warga)**: Query menampilkan daftar artikel, filter pencarian berdasarkan kata kunci.
* **(Warga)**: Logic untuk menyimpan (Bookmark) dan menghapus bookmark artikel, relasi ke pivot `bookmark_artikel`.

#### **Modul 8: Observabilitas, Dasbor Peta & Notifikasi** (Anggota 7)
*Fokus pada penyajian data dan trigger.*
* **(Warga)**: API/Logic untuk menampilkan marker/titik-titik TPS dan Tumpukan Sampah Liar pada Peta Interaktif (Leaflet.js).
* **(Admin)**: Logic untuk menghitung grafik analitik (Chart.js), misalnya total laporan masuk bulan ini, atau total pengangkutan yang diubah menjadi format JSON untuk diserap Frontend.
* **(Sistem Notif)**: Menyuntikkan notifikasi ke tabel `notifikasi` saat status pesanan/laporan berubah.

---

## 🌿 Panduan Singkat Alur Kerja Git (Untuk Pemula)

Karena tim "bisa pakai Git namun bukan ahli", ikuti 3 aturan emas ini agar kode tidak rusak (*conflict*):

1. **JANGAN PERNAH** langsung `commit` dan `push` ke branch `main`.
2. Setiap kali Modul 1 selesai melakukan *Setup Core* (Fase 1), semua anggota wajib melakukan:
   `git pull origin main` (untuk menyamakan kondisi file di laptop masing-masing).
3. Setelah itu, setiap anggota membuat "cabang" (*branch*) baru sesuai modulnya.
   Misal Anggota 3 mengetik: `git checkout -b modul-4-petugas`.
4. Anggota bekerja di *branch* masing-masing (membuat *controller*, *routing* khusus seperti `routes/petugas.php`, dll).
5. Ketika sudah selesai, _Push_ ke GitHub dengan nama branch tersebut, dan gabungkan (*Merge*) lewat tombol **Pull Request** di web GitHub. Jika ada peringatan *Conflict*, minta bantuan anggota utama untuk memperbaikinya perlahan (jangan ditimpa paksa).
