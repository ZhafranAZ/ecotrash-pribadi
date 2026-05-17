# Konteks AI: Modul 1 (Core Setup & Autentikasi)

*Gunakan dokumen ini sebagai konteks (prompt) utama saat memerintahkan AI untuk membangun backend Modul 1.*

---

## 1. Tujuan Modul (*Objective*)
Tujuan modul ini adalah menginisiasi struktur fondasi aplikasi. AI harus membuat seluruh *Database Migration* berdasarkan `Database_Schema.md` agar relasi *Foreign Key* terbentuk sempurna, menyusun *Seeder* awal (Dummy Data), dan mengonfigurasi autentikasi (Breeze/Jetstream) yang dimodifikasi agar mendukung *Multi-Role* (Admin, Warga, Petugas) menggunakan *Middleware*. Modul ini juga mencakup alur registrasi warga yang melalui dua tahap (Multi-step: Register -> Setup Address).

## 2. Keterkaitan Frontend (*View & Client-Side*)
* `resources/views/auth/login.blade.php` (Form login)
* `resources/views/auth/register.blade.php` (Form registrasi Warga Tahap 1)
* `resources/views/auth/setup-address.blade.php` (Form registrasi Warga Tahap 2)
* **Peringatan:** Interaksi akan menggunakan form submit HTML standar bawaan Blade, tidak menggunakan Axios/API.

## 3. Fokus Database (*Schema Reference*)
AI wajib membuat struktur Migration secara berurutan agar relasi kunci tamu (*Foreign Key*) tidak eror:
1. `komplek` (id, nama_komplek, lat, lng)
2. `users` (id, nama, email, no_telepon, password, role [enum: admin,warga,petugas], saldo_koin, status_kehadiran)
3. `alamat_warga` (relasi ke users dan komplek)
4. `petugas_komplek` (pivot users dan komplek)
5. `pengaturan_sistem` (konversi_koin_rupiah, harga_kategori, dll)
*(AI harus membuat file migration seluruh tabel yang ada di skema, meskipun modul lain belum dikerjakan, agar struktur database lengkap di awal).*

## 4. Alur Fungsional (*Business Logic Flow*)
* **Seeder:** Buat `DatabaseSeeder` yang mengeksekusi pembuatan 3 akun user: 1 Admin, 1 Warga, 1 Petugas. Buat juga 2 data `komplek` dummy, dan 1 baris (row) data `pengaturan_sistem` default.
* **Registrasi Warga (Tahap 1):** Saat user submit form register, masukkan data ke tabel `users` dengan `role = 'warga'` dan `saldo_koin = 0`. Login-kan pengguna secara otomatis, lalu **redirect ke halaman `/setup-address`**.
* **Registrasi Warga (Tahap 2 - Setup Address):** Pada halaman ini, warga memasukkan detail alamat. Saat form disubmit, insert data ke tabel `alamat_warga` (relasikan dengan `Auth::id()`). Setelah tersimpan, **redirect ke `/warga/dashboard`**.
* **Redirection Login:** Modifikasi *logic* otentikasi. Saat login berhasil, periksa `Auth::user()->role` untuk mengarahkan ke dashboard yang tepat:
  - `if role == 'admin'` -> redirect ke `/admin/dashboard`
  - `if role == 'petugas'` -> redirect ke `/petugas/beranda`
  - `if role == 'warga'` -> redirect ke `/warga/dashboard` (atau `/home` yang mengarah ke `/warga/dashboard`)
* **Middleware Pemisah:** Buat file `RoleMiddleware` untuk melindungi *Route* agar role tidak bisa saling mengakses halaman satu sama lain.

## 5. Daftar Route & Controller (*Routing Map*)
* Modifikasi `App\Http\Controllers\Auth\RegisteredUserController::class` (Method `store` untuk Tahap 1, dan tambahkan fungsi baru untuk memproses form Setup Address).
* Modifikasi `App\Http\Controllers\Auth\AuthenticatedSessionController::class` (Method `store` untuk logic redirect beda role).
* Daftarkan *Middleware* di `bootstrap/app.php` atau `app/Http/Kernel.php` dengan alias `role`.

## 6. Aturan Validasi Data (*Form Request Validation*)
* **Register Tahap 1:** `nama` (required, string), `email` (required, email, unique:users), `no_telepon` (required, string, min:10), `password` (required, confirmed, min:8).
* **Setup Address Tahap 2:** `komplek_id` (required, exists:komplek,id), `blok_nomor_rumah` (required, string), `detail_patokan` (nullable, string).
* **Login:** `email` (required, email), `password` (required).

## 7. Penanganan Error & Kasus Khusus (*Edge Cases*)
* Jika Warga mencoba masuk ke `/warga/dashboard` tetapi belum menyelesaikan tahap *setup-address*, buat *middleware* atau *check* yang memaksa mereka *redirect* kembali ke halaman `/setup-address` hingga alamat terisi.
* Pastikan kolom `no_telepon` bisa menyimpan awalan "0" atau "+62" (gunakan tipe data *String/Varchar*, bukan *Integer* di Migration `users`).

## 8. Struktur Kembalian (*Response Format*)
* `RedirectResponse`: Gunakan `redirect()->route(...)` atau `redirect()->intended(...)` setelah berhasil. Tidak perlu mengembalikan data JSON.
