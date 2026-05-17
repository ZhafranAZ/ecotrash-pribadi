# Konteks AI: Modul 4 (Operasional Pengangkutan)

*Gunakan dokumen ini sebagai konteks (prompt) utama saat memerintahkan AI untuk membangun backend Modul 4.*

---

## 1. Tujuan Modul (*Objective*)
Tujuan modul ini adalah membangun fungsionalitas manajemen *Task* atau Pekerjaan. AI bertugas membuat *Controller* dan *Routing* agar:
1. Petugas dapat melihat daftar pesanan warga (tugas) di area komplek mereka, serta mengubah status tugas tersebut (menunggu -> diproses -> selesai/gagal) dengan kewajiban melampirkan foto bukti.
2. Admin dapat memonitor seluruh riwayat transaksi pesanan warga di *Dashboard* Operasional.

## 2. Keterkaitan Frontend (*View & Client-Side*)
* `resources/views/petugas/beranda.blade.php` (Menampilkan rekapitulasi tugas per komplek).
* `resources/views/petugas/tugas/detail.blade.php` (Aksi update status dan upload foto. Dikendalikan oleh Alpine.js `x-data`).
* `resources/views/admin/operasional/index.blade.php` (Tabel monitoring admin).
* **Peringatan:** Pada halaman detail tugas petugas, aksi *Update Status* dan *Lapor Kendala* sebaiknya dihubungkan menggunakan **Axios/Fetch** (API Request) agar animasi *state* dari Alpine.js (`status = 'selesai'`) berjalan mulus tanpa *reload* halaman secara kasar.

## 3. Fokus Database (*Schema Reference*)
* Tabel `pesanan_pengangkutan` (Tabel utama. Mengubah kolom: `status`, `foto_bukti_selesai`, `alasan_kendala`, `foto_kendala`, `ukuran_aktual_laporan_petugas`, `koin_didapat`).
* Tabel `pengaturan_sistem` (Untuk mengecek nilai `bonus_koin_kecil`, `bonus_koin_sedang`, `bonus_koin_besar`).
* Tabel `riwayat_status_pesanan` (Menambah log setiap ada perubahan status).
* Tabel `users` (Menambah `saldo_koin` Warga saat tugas selesai).
* Tabel `petugas_komplek` (Relasi untuk menampilkan tugas yang sesuai dengan area tugas si Petugas).

## 4. Alur Fungsional (*Business Logic Flow*)
* **Petugas - Mulai Tugas:** Saat tombol dipencet, sistem akan mengubah status di `pesanan_pengangkutan` menjadi `diproses`. Catat aktivitas ini ke `riwayat_status_pesanan`.
  * **Notifikasi:** Panggil `NotificationService::send()` ke Warga pemesan: "Petugas sedang menuju ke lokasimu" dengan tipe `'info'`.
* **Petugas - Selesaikan Tugas:** Wajib mengirimkan *File Gambar* (`foto_bukti_selesai`).
  1. Upload dan simpan gambar ke *storage* (`public/buktipesanan`).
  2. Ubah `status` pesanan menjadi `selesai`.
  3. **Kalkulasi Koin:** Ambil nilai bonus koin dari tabel `pengaturan_sistem` yang sesuai dengan `kategori_sampah` pada pesanan tersebut (misal: jika kategori 'kecil', ambil `bonus_koin_kecil`).
  4. Simpan nilai koin tersebut ke kolom `koin_didapat` pada tabel pesanan.
  5. **Tambahkan** nilai koin tersebut dengan memanggil `App\Services\CoinService::addCoins()` (buat servicenya jika belum ada) agar tercatat otomatis ke tabel `riwayat_koin` tipe 'masuk'.
  6. Catat aktivitas ini ke `riwayat_status_pesanan`.
  7. **Notifikasi:** Panggil `NotificationService::send()` ke Warga pemesan: "Sampah telah diangkut! Anda mendapat X koin bonus" dengan tipe `'success'`.
* **Petugas - Lapor Kendala:**
  * Jika pagar terkunci: Ubah status menjadi `gagal_pickup` dan simpan pesan ke `alasan_kendala`.
    * **Notifikasi (UI Khusus):** Kirim notifikasi bertipe **`'error'`** dengan pesan "Gagal Pickup: Pagar Tertutup" agar meng-trigger banner di Dashboard Warga.
  * Jika beda ukuran: Ubah status menjadi `hold_kapasitas`, simpan `foto_kendala`, dan catat `ukuran_aktual_laporan_petugas`.
    * **Notifikasi (UI Khusus):** Kirim notifikasi bertipe **`'warning'`** dengan pesan "Pembayaran Tambahan Diperlukan" agar meng-trigger banner di Dashboard Warga.
* **Admin - Monitoring:** Tampilkan data dari tabel `pesanan_pengangkutan` diurutkan dari terbaru, lengkapi dengan relasi (*Eager Loading*) ke model Warga, Petugas, dan Komplek.

## 5. Daftar Route & Controller (*Routing Map*)
* **Petugas:**
  * Buat `App\Http\Controllers\Petugas\TugasController`.
  * Route: `GET /petugas/beranda` -> Method `index`.
  * Route: `POST /petugas/tugas/{id}/status` -> Method `updateStatus` (API/Axios request).
  * Route: `POST /petugas/tugas/{id}/kendala` -> Method `reportKendala` (API/Axios request).
* **Admin:**
  * Buat `App\Http\Controllers\Admin\OperasionalController`.
  * Route: `GET /admin/operasional` -> Method `index`.

## 6. Aturan Validasi Data (*Form Request Validation*)
* **Update Status (Selesai):** `status` (required, in:diproses,selesai), `foto_bukti` (required_if:status,selesai | image | max:2048).
* **Lapor Kendala:** `tipe_kendala` (required, in:terkunci,beda_ukuran), `alasan` (string), `foto_kendala` (image | max:2048).

## 7. Penanganan Error & Kasus Khusus (*Edge Cases*)
* Saat *Upload* foto dan menyimpan ke database, gunakan blok `DB::beginTransaction()` dan `DB::commit()`. Jika penambahan koin ke tabel `users` gagal, pastikan seluruh perubahan (termasuk penyimpanan file secara sistem) digagalkan (*rollback*).
* Pastikan Petugas A tidak bisa mengubah status tugas milik area Petugas B (Berikan proteksi/validasi `komplek_id` vs `petugas_komplek`).

## 8. Struktur Kembalian (*Response Format*)
* Fungsi `updateStatus` dan `reportKendala` wajib mengembalikan `JSON Response` (misal: `return response()->json(['message' => 'Status berhasil diubah', 'status' => 'selesai']);`) agar dapat diolah oleh state Alpine.js di frontend.
* Untuk Admin, gunakan kembalian standard `View` (HTML).
