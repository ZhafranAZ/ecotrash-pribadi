# Konteks AI: Modul 6 (Tindak Lanjut Sampah Liar & Sistem Koin Terpusat)

*Gunakan dokumen ini sebagai konteks (prompt) utama saat memerintahkan AI untuk membangun backend Modul 6.*

---

## 1. Tujuan Modul (*Objective*)
Tujuan modul ini terbagi dua:
1. Membangun fungsionalitas bagi Petugas untuk mengeksekusi tugas pembersihan sampah liar di lapangan.
2. Membangun **Sistem Koin Terpusat** (berupa `Service Class` dan *Cron Job*) yang akan mengelola penambahan, pengurangan, serta masa kedaluwarsa koin Warga.

## 2. Keterkaitan Frontend (*View & Client-Side*)
* `resources/views/petugas/laporan/detail.blade.php`: Halaman ini menggunakan *Alpine.js* untuk *state management* status laporan (`menunggu`, `sedang_dibersihkan`, `selesai`, `ditunda`).
* **Catatan Modifikasi AI:** AI harus merubah *button action* Alpine di halaman tersebut menjadi request *AJAX (Axios)* atau *Form Submit* biasa agar perubahan status tercatat ke *Backend*. Ada fitur kamera (upload file foto) dan Modal untuk penundaan (dengan pilihan alasan via select).

## 3. Fokus Database (*Schema Reference*)
* Tabel `laporan_sampah_liar`: Mengubah `status`, mengisi `foto_bukti_selesai_petugas`, atau `alasan_ditunda`.
* Tabel `riwayat_koin` (Tabel Baru): Untuk mencatat *log* koin masuk, keluar, dan expired, serta melacak `expired_at` (berlaku 6 bulan).
* Tabel `notifikasi`: Untuk mengirim pesan ke Warga.

## 4. Alur Fungsional (*Business Logic Flow*)
### A. Alur Petugas Lapangan
1. **Mulai Pembersihan:** 
   * Petugas menekan "Mulai Pembersihan".
   * Update database: `status = 'sedang_dibersihkan'`.
2. **Tunda Pembersihan:**
   * Jika ada kendala (alat berat kurang, hujan, dsb), Petugas mengisi opsi di Modal Tunda.
   * Update database: `status = 'ditunda'`, simpan input ke kolom `alasan_ditunda`.
   * **Notifikasi:** Panggil `NotificationService::send()` ke Warga: "Pembersihan tertunda. Alasan: [alasan]" dengan tipe `'warning'`.
3. **Selesai Pembersihan:**
   * Petugas mengunggah *Foto Hasil Pembersihan*.
   * Update database: `status = 'selesai'`, simpan file ke `public/laporan_selesai`.
   * **Sistem Koin:** Panggil `CoinService` untuk memberikan `koin_reward` ke Warga.
   * **Notifikasi:** Panggil `NotificationService::send()` ke Warga: "Tumpukan sampah telah dibersihkan! Anda mendapat [X] koin bonus." dengan tipe `'success'`.

### B. Sistem Koin Terpusat (`App\Services\CoinService`)
AI harus membuat sebuah *Service Class* agar manipulasi koin aman dari eksploitasi, dibungkus dalam `DB::transaction()`.
1. `addCoins(warga_id, jumlah, sumber, referensi_id)`: 
   * Menambah `saldo_koin` di tabel `users`.
   * Insert ke `riwayat_koin` dengan tipe `masuk`. Set `expired_at = now()->addMonths(6)`.
2. `deductCoins(warga_id, jumlah, sumber, referensi_id)`:
   * Mengurangi `saldo_koin` warga (Pastikan saldo tidak minus!).
   * Insert ke `riwayat_koin` dengan tipe `keluar`.
3. **Cron Job Koin Expired:**
   * Buat *Console Command* Laravel (cth: `php artisan koin:expire`).
   * Command ini dijalankan tiap tengah malam (`daily()`) di `Kernel.php` atau `routes/console.php`.
   * **Logika Sederhana:** Cari data `riwayat_koin` tipe `masuk` yang `expired_at`-nya sudah lewat hari ini, dan catat nominal koin yang hangus sebagai `expired` di `riwayat_koin`, lalu potong `saldo_koin` warga sejumlah nominal tersebut. *(Pastikan AI membuat logic pencegahan agar koin yang sudah terpakai tidak dipotong dua kali, atau gunakan pendekatan FIFO yang simpel).*

## 5. Daftar Route & Controller (*Routing Map*)
* Buat `App\Http\Controllers\Petugas\TindakLanjutController`.
* Route: `POST /petugas/laporan/{id}/mulai` -> Method `mulai`.
* Route: `POST /petugas/laporan/{id}/tunda` -> Method `tunda`.
* Route: `POST /petugas/laporan/{id}/selesai` -> Method `selesai`.

## 6. Aturan Validasi Data (*Form Request Validation*)
* **Tunda:** `alasan_utama` (required, string), `catatan_tambahan` (nullable, string). (*AI bisa menggabungkan keduanya menjadi satu string ke `alasan_ditunda`*).
* **Selesai:** `foto_hasil` (required, image, max:2048).

## 7. Penanganan Error & Kasus Khusus (*Edge Cases*)
* Petugas **hanya boleh** mengubah status laporan yang di-*assign* kepadanya (`petugas_id == auth()->id()`).
* Mencegah *Double Submit*: Warga tidak boleh mendapat koin dua kali jika Petugas tak sengaja memanggil rute `selesai` secara berulang (periksa `if($laporan->status == 'selesai') return error`).
