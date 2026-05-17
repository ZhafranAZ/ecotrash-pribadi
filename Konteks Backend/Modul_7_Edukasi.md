# Konteks AI: Modul 7 (Edukasi Lingkungan & Bookmark)

*Gunakan dokumen ini sebagai konteks (prompt) utama saat memerintahkan AI untuk membangun backend Modul 7.*

---

## 1. Tujuan Modul (*Objective*)
Tujuan modul ini adalah membangun sistem **CMS (Content Management System)** mini untuk Edukasi Lingkungan. 
* **Admin** dapat melakukan proses CRUD (Create, Read, Update, Delete) artikel beserta unggah gambar thumbnail dan penulisan teks berformat (HTML). 
* **Warga** dapat mencari, memfilter, membaca artikel, serta menyimpan artikel favorit mereka menggunakan fitur **Bookmark**.

## 2. Keterkaitan Frontend (*View & Client-Side*)
* **Warga:**
  * `resources/views/warga/edukasi/index.blade.php` (Menampilkan daftar artikel, fitur pencarian teks, dan filter kategori).
  * `resources/views/warga/edukasi/show.blade.php` (Halaman detail membaca artikel).
  * `resources/views/warga/edukasi/tersimpan.blade.php` (Menampilkan khusus artikel yang telah di-bookmark).
  * **Catatan Modifikasi AI (Warga):** Pada `index.blade.php` dan `show.blade.php`, AI harus menghubungkan fungsi interaksi tombol Bookmark (berlogo pita) agar mengirim *Request Axios/Fetch* ke Backend untuk mem-memicu *toggle* tanpa me-reload halaman.
* **Admin:**
  * `resources/views/admin/edukasi/index.blade.php` (Tabel artikel).
  * `resources/views/admin/edukasi/create.blade.php` & `edit.blade.php` (Form HTML standar yang menggunakan *text-editor* / WYSIWYG untuk konten artikel).

## 3. Fokus Database (*Schema Reference*)
* Tabel `artikel_edukasi` (Kolom utama: `id`, `judul`, `kategori`, `gambar_thumbnail`, `konten_html`, `penulis_admin_id`).
* Tabel Pivot `bookmark_artikel` (Menghubungkan `warga_id` pada tabel `users` dengan `artikel_id` pada tabel `artikel_edukasi`).

## 4. Alur Fungsional (*Business Logic Flow*)
### A. CMS Admin
1. **Buat & Edit Artikel:** Admin menginput `judul`, memilih `kategori`, dan mengunggah gambar `gambar_thumbnail` (simpan di `public/edukasi/thumbnail`). Teks dari text-editor disimpan apa adanya ke dalam `konten_html` (Izinkan *tags* dasar).
2. Tautkan `penulis_admin_id` dengan `auth()->id()` admin yang sedang login saat pertama kali dibuat.

### B. Portal Warga & Bookmark
1. **Daftar Artikel (Feed):**
   * Gunakan `Pagination`.
   * Terapkan fungsionalitas Filter: Jika URL memiliki parameter `?search=plastik`, *query* harus mencari `judul` atau `konten_html` yang relevan. Jika ada `?kategori=kompos`, saring berdasarkan kategori tersebut.
2. **Toggle Bookmark (AJAX):**
   * Saat menerima *Request*, cek tabel `bookmark_artikel`.
   * Jika Warga tersebut **sudah** mem-bookmark artikel itu, hapus datanya (*detach* / Unbookmark).
   * Jika **belum**, tambahkan datanya (*attach* / Bookmark).
   * Kembalikan JSON (cth: `['status' => 'bookmarked']` atau `['status' => 'unbookmarked']`) agar UI tombol bookmark bisa berubah warna secara interaktif di sisi klien.

## 5. Daftar Route & Controller (*Routing Map*)
* **Admin:**
  * Buat `App\Http\Controllers\Admin\EdukasiController`.
  * Gunakan Route Resource: `Route::resource('edukasi', EdukasiController::class);` di grup `/admin`.
* **Warga:**
  * Buat `App\Http\Controllers\Warga\EdukasiWargaController`.
  * Route: `GET /warga/edukasi` -> Method `index`.
  * Route: `GET /warga/edukasi/tersimpan` -> Method `tersimpan`.
  * Route: `GET /warga/edukasi/{id}` -> Method `show`.
  * Route: `POST /warga/edukasi/{id}/bookmark` -> Method `toggleBookmark`.

## 6. Aturan Validasi Data (*Form Request Validation*)
* **Admin Create/Update:** `judul` (required, string, max:255), `kategori` (required, string), `konten_html` (required), `gambar_thumbnail` (required_on_create, image, max:2048).

## 7. Penanganan Error & Kasus Khusus (*Edge Cases*)
* Saat Warga mengakses halaman artikel yang sudah dihapus oleh Admin, kembalikan `abort(404)`.
* Pastikan input `konten_html` aman dari *Malicious Scripts* (meskipun Admin yang mengisi, perlindungan standar *XSS* di *middleware* atau menggunakan purifier sangat direkomendasikan saat *rendering* di halaman Warga, atau cukup cetak dengan `{!! $artikel->konten_html !!}` karena Admin dianggap aman).
