# Konteks AI: Modul 2 (Profil Warga & Manajemen Akun)

*Gunakan dokumen ini sebagai konteks (prompt) utama saat memerintahkan AI untuk membangun backend Modul 2.*

---

## 1. Tujuan Modul (*Objective*)
Tujuan modul ini adalah membangun fungsionalitas Manajemen Profil dan Master Data. AI bertugas membuat *Controller* dan *Routing* agar: 
1. Warga dapat mengubah profil dasar dan mengelola banyak alamat (termasuk memilih satu "Alamat Utama").
2. Admin dapat mengelola (*CRUD*) data Warga, membuat/mengedit akun Petugas, dan mengelola master data Komplek.

## 2. Keterkaitan Frontend (*View & Client-Side*)
* `resources/views/warga/profil/index.blade.php` (Terdapat modal/form Edit Profil dan Kelola Alamat).
* `resources/views/admin/pengguna/index.blade.php` (Terdapat tabel data pengguna dan form penambahan Petugas).
* `resources/views/admin/pengaturan/index.blade.php` atau sejenisnya (Untuk pengelolaan daftar Komplek).
* **Peringatan:** Interaksi form menggunakan HTML standar dengan metode `POST`/`PUT`/`DELETE` via `@method` Blade. Pengembalian notifikasi menggunakan *Flash Session* (`->with('success', ...)`).

## 3. Fokus Database (*Schema Reference*)
* Tabel `users` (Kolom: `nama`, `no_telepon`, `email`, `password`, `role`).
* Tabel `alamat_warga` (Kolom: `id`, `warga_id`, `komplek_id`, `nama_alamat`, `blok_nomor_rumah`, `detail_patokan`, `is_utama`).
* Tabel `komplek` (Kolom: `id`, `nama_komplek`, `lat`, `lng`).

## 4. Alur Fungsional (*Business Logic Flow*)
* **Warga - Edit Profil:** Update data `nama` dan `no_telepon` milik user yang sedang login (`Auth::id()`).
* **Warga - Tambah Alamat:** Insert data ke `alamat_warga`. Jika ini adalah alamat pertama milik warga tersebut, otomatis set `is_utama = true`. Jika bukan, set `false`.
* **Warga - Set Alamat Utama:** Saat form disubmit untuk memilih alamat A sebagai alamat utama:
  1. Ubah semua alamat milik `warga_id` ini menjadi `is_utama = false`.
  2. Ubah alamat dengan ID yang dipilih menjadi `is_utama = true`.
* **Admin - Buat Akun Petugas:** Insert ke tabel `users` dengan `role = 'petugas'` dan berikan _password_ *default* atau hasil generate otomatis, lalu simpan datanya.
* **Admin - Kelola Komplek:** Sediakan fungsi *Create*, *Update*, dan *Delete* (Cek apakah komplek sedang terpakai di tabel pesanan/alamat sebelum mengizinkan *Delete*).

## 5. Daftar Route & Controller (*Routing Map*)
* **Warga:**
  * Buat `App\Http\Controllers\Warga\ProfilController`.
  * Route: `PUT /warga/profil/update` -> Method `updateProfile`.
  * Route: `POST /warga/profil/alamat` -> Method `storeAlamat`.
  * Route: `PUT /warga/profil/alamat/{id}/utama` -> Method `setAlamatUtama`.
  * Route: `DELETE /warga/profil/alamat/{id}` -> Method `destroyAlamat`.
* **Admin:**
  * Buat `App\Http\Controllers\Admin\PenggunaController`.
  * Route: `POST /admin/pengguna/petugas` -> Method `storePetugas`.
  * Route: `DELETE /admin/pengguna/petugas/{id}` -> Method `destroyPetugas`.
  * Buat `App\Http\Controllers\Admin\KomplekController`.

## 6. Aturan Validasi Data (*Form Request Validation*)
* **Update Profil:** `nama` (required, string, max:255), `no_telepon` (required, string, min:10).
* **Alamat Warga:** `komplek_id` (required, exists:komplek,id), `nama_alamat` (required, string), `blok_nomor_rumah` (required, string).
* **Tambah Petugas:** `nama` (required, string), `email` (required, email, unique:users,email), `password` (required, min:8).
* **Komplek:** `nama_komplek` (required, string), `lat` (required, numeric), `lng` (required, numeric).

## 7. Penanganan Error & Kasus Khusus (*Edge Cases*)
* Saat Admin menghapus (*Delete*) Komplek, berikan blok *Try-Catch*. Cek apakah ada record di `alamat_warga` yang menggunakan `komplek_id` tersebut. Jika ada, batalkan penghapusan dan kembalikan pesan error: "Komplek tidak dapat dihapus karena masih digunakan oleh Warga".
* Gunakan pembungkus `DB::transaction()` pada fitur **Set Alamat Utama** agar proses merubah nilai boolean aman dari kegagalan proses di tengah jalan.

## 8. Struktur Kembalian (*Response Format*)
Semua fungsi harus mengembalikan `RedirectResponse` (contoh: `return redirect()->back()`) dengan menyertakan *Flash Session*:
* Jika berhasil: `->with('success', 'Pesan sukses di sini')`.
* Jika gagal/error: `->withErrors(['error' => 'Pesan error di sini'])` atau `->with('error', '...')`.
