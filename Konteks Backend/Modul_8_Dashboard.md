# Konteks AI: Modul 8 (Observabilitas & Dashboard Warga/Admin)

*Gunakan dokumen ini sebagai konteks (prompt) utama saat memerintahkan AI untuk membangun backend Modul 8.*

---

## 1. Tujuan Modul (*Objective*)
Tujuan modul ini adalah merangkai seluruh data yang tersebar dari Modul 1-7 menjadi ringkasan informatif pada halaman **Dashboard**. Modul ini juga bertanggung jawab membangun *Notification Service* terpusat yang akan menyuplai pesan ke *Dropdown/Panel Bel Lonceng* di seluruh *layout*.

## 2. Keterkaitan Frontend (*View & Client-Side*)
* **Warga:**
  * `resources/views/warga/dashboard.blade.php`: Menampilkan Saldo Koin, serta notifikasi/banner statis (misal alert "Pembayaran Tambahan" yang datanya dipasok dari Backend).
  * `resources/views/warga/aktivitas/index.blade.php`: Terdapat 2 *Tab* (Pesanan & Laporan). Backend harus mensuplai 2 *Collection* berbeda yang ditangkap oleh logika *Alpine.js* di halaman ini.
* **Admin:**
  * `resources/views/admin/dashboard.blade.php`: Menampilkan agregasi statistik (Total pengguna, Total laporan menunggu, dsb).
* **Global Layout:**
  * AI harus memodifikasi `layouts.warga` dan `layouts.admin` pada bagian lambang Lonceng agar menampilkan jumlah angka *Unread Notification* (Notifikasi belum dibaca).

## 3. Fokus Database (*Schema Reference*)
* Tabel `notifikasi` (`id`, `user_id`, `judul`, `pesan`, `is_read`, `created_at`).
* Semua tabel relasional lainnya (`users`, `pesanan_pengangkutan`, `laporan_sampah_liar`) digunakan untuk *Query Builder Agregat* (seperti `count()`, `sum()`).

## 4. Alur Fungsional (*Business Logic Flow*)
### A. Notification Service & View Composer
1. **Pusat Notifikasi (`App\Services\NotificationService`):** Modul 3, 4, 5, dan 6 memiliki fitur "Kirim Notifikasi". Agar kodenya tidak berulang-ulang, AI pada Modul 8 ini ditugaskan untuk membuat satu *Class* khusus (`NotificationService`) yang berfungsi seperti "Tukang Pos". Modul lain tinggal memanggil `NotificationService::send($userId, $judul, $pesan, $tipe)` untuk memasukkan data ke tabel `notifikasi`. (Tipe bisa berupa: 'info', 'warning', 'success', 'error').
2. Buat **View Composer** di `AppServiceProvider` (atau semacamnya) agar variabel `$unreadNotifications` (`where('user_id', auth()->id())->where('is_read', false)->get()`) selalu tersedia di *Views* mana pun, sehingga lambang lonceng di Navigation Bar dapat berfungsi otomatis tanpa perlu mengirim variabel dari masing-masing Controller.

### B. Aktivitas Warga
1. Tampilkan riwayat *Pesanan Pengangkutan* milik Warga yang sedang login, diurutkan dari terbaru. Muat relasi ke tabel `riwayat_status_pesanan` untuk menampilkan *Timeline Tracking* di *Modal Alpine*.
2. Tampilkan riwayat *Laporan Sampah Liar* milik Warga tersebut.

### C. Dashboard Admin
1. Hitung total Warga terdaftar, Petugas terdaftar.
2. Hitung total *Pesanan Pengangkutan* hari ini (`whereDate('created_at', today())`).
3. Hitung jumlah *Laporan Sampah Liar* dengan status `menunggu`.
4. Hitung **jumlah koin beredar** (Total dari penjumlahan seluruh kolom `saldo_koin` di tabel `users` warga).

## 5. Daftar Route & Controller (*Routing Map*)
* **Global (Semua Role):**
  * Buat Endpoint `POST /notifikasi/mark-all-as-read` untuk merubah semua notifikasi milik *user* yang sedang *login* menjadi `is_read = true` ketika tombol **"Tandai Semua Dibaca"** di-klik.
* **Warga:**
  * Route: `GET /warga/dashboard` -> `App\Http\Controllers\Warga\DashboardController@index`.
  * Route: `GET /warga/aktivitas` -> `App\Http\Controllers\Warga\AktivitasController@index`.
* **Admin:**
  * Route: `GET /admin/dashboard` -> `App\Http\Controllers\Admin\DashboardController@index`.

## 6. Penanganan Error & Kasus Khusus (*Edge Cases*)
* Kueri statistik pada Dashboard Admin berpotensi menjadi lambat jika data mencapai puluhan ribu. AI diperbolehkan menyarankan penggunaan *Cache* (cth: `Cache::remember('admin_stats', 60, function() {...})`) jika diperlukan, walau tidak wajib untuk MVP.
* Banner khusus "Pembayaran Tambahan" di Dashboard Warga hanya boleh muncul JIKA terdapat pesanan pengangkutan dengan status `hold_kapasitas`.
