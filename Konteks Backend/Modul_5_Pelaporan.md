# Konteks AI: Modul 5 (Pelaporan Sampah Liar - Warga & Admin)

*Gunakan dokumen ini sebagai konteks (prompt) utama saat memerintahkan AI untuk membangun backend Modul 5.*

---

## 1. Tujuan Modul (*Objective*)
Tujuan modul ini adalah membangun fungsionalitas sistem *Ticketing* pelaporan sampah liar. AI bertugas membuat logika backend agar Warga dapat mengirim laporan (dengan koordinat peta dan foto), serta Admin dapat melakukan verifikasi (Menyetujui, Menolak, atau Menandai Duplikat) laporan tersebut.

## 2. Keterkaitan Frontend (*View & Client-Side*)
* `resources/views/warga/lapor/create.blade.php` (Terdapat peta interaktif `Leaflet.js` dan form pelaporan).
* `resources/views/warga/lapor/berhasil.blade.php` (Halaman sukses).
* `resources/views/admin/laporan/index.blade.php` (Tabel daftar laporan dan Modal persetujuan/penolakan).
* **Catatan Modifikasi AI:** Pada `create.blade.php`, AI harus memodifikasi Javascript Leaflet agar mengekstrak koordinat pusat peta (`map.getCenter()`) sebelum *submit*, dan menyimpannya ke dalam `<input type="hidden" name="lat">` dan `lng`. Submit dapat dilakukan via *HTML Form* biasa.

## 3. Fokus Database (*Schema Reference*)
* Tabel `laporan_sampah_liar` (Kolom: `id`, `warga_id`, `lat`, `lng`, `deskripsi`, `foto_laporan_warga`, `status`, `koin_reward`, `petugas_id`, `alasan_penolakan`).
* Tabel `users` (Relasi `warga_id` dan `petugas_id`, serta pemberian reward ke `saldo_koin`).
* Tabel `notifikasi` (Untuk mengirimkan alert ke user saat status berubah).

## 4. Alur Fungsional (*Business Logic Flow*)
* **Warga - Kirim Laporan:**
  1. Terima input file gambar, deskripsi, lat, dan lng.
  2. Upload gambar ke *storage* (`public/laporan_warga`).
  3. Insert ke database `laporan_sampah_liar` dengan `status = 'menunggu'`.
* **Admin - Setujui Laporan:**
  1. Menerima request `petugas_id` dan `koin_reward`.
  2. Ubah `status = 'disetujui'`.
  3. Masukkan `petugas_id` untuk menugaskan petugas lapangan.
  4. Tambahkan nilai `koin_reward` dengan memanggil `App\Services\CoinService::addCoins()` (buat servicenya jika belum ada) agar tercatat otomatis ke tabel `riwayat_koin` tipe 'masuk'.
  5. **Notifikasi:** Panggil `NotificationService::send()` untuk Warga ("Laporan Disetujui! Anda mendapatkan koin." tipe `'success'`) dan Petugas ("Ada tugas pembersihan baru" tipe `'info'`).
* **Admin - Tolak Laporan:**
  1. Menerima request `alasan_penolakan`.
  2. Ubah `status = 'ditolak'`.
  3. Simpan teks alasan tersebut ke database agar warga mengerti mengapa laporannya ditolak.
  4. **Notifikasi:** Panggil `NotificationService::send()` untuk Warga ("Laporan Ditolak: [alasan]" tipe `'error'`).
* **Admin - Tandai Duplikat (Merge):**
  1. Ubah status laporan yang dipilih menjadi `ditolak` dengan *hardcode* alasan "Laporan Duplikat/Sudah dilaporkan oleh warga lain".

## 5. Daftar Route & Controller (*Routing Map*)
* **Warga:**
  * Buat `App\Http\Controllers\Warga\LaporanController`.
  * Route: `POST /warga/lapor` -> Method `store`.
* **Admin:**
  * Buat `App\Http\Controllers\Admin\LaporanLiarController`.
  * Route: `GET /admin/laporan` -> Method `index`.
  * Route: `POST /admin/laporan/{id}/approve` -> Method `approve`.
  * Route: `POST /admin/laporan/{id}/reject` -> Method `reject`.

## 6. Aturan Validasi Data (*Form Request Validation*)
* **Warga (Store):** `lat` (required, numeric), `lng` (required, numeric), `deskripsi` (required, string, min:10), `foto` (required, image, max:2048).
* **Admin (Approve):** `petugas_id` (required, exists:users,id), `koin_reward` (required, integer, min:0).
* **Admin (Reject):** `alasan_penolakan` (required, string, min:5).

## 7. Penanganan Error & Kasus Khusus (*Edge Cases*)
* Saat Admin menyetujui laporan dan menambahkan koin ke Warga, gunakan `DB::beginTransaction()` untuk mencegah `status` laporan berubah menjadi 'disetujui' jika penambahan koin gagal.
* Filter tabel di halaman Admin harus berjalan lancar (Filter status `pending`, `approved`, `rejected`). AI dapat mengandalkan *Query String* `?status=...` untuk filter sederhana.

## 8. Struktur Kembalian (*Response Format*)
* Untuk Warga: `redirect()->route('warga.lapor.berhasil')` setelah sukses submit.
* Untuk Admin: Kembalikan `RedirectResponse` `->back()->with('success', 'Pesan notifikasi')`. AI disarankan menggunakan session flash standar Laravel.
