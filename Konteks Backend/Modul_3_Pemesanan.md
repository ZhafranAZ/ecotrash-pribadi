# Konteks AI: Modul 3 (Pemesanan Pengangkutan)

*Gunakan dokumen ini sebagai konteks (prompt) utama saat memerintahkan AI untuk membangun backend Modul 3.*

---

## 1. Tujuan Modul (*Objective*)
Tujuan modul ini adalah membangun fungsionalitas pemesanan (checkout) layanan pengangkutan sampah oleh Warga. AI bertugas mengubah tampilan statis form (yang sudah dibuat menggunakan Alpine.js) agar terhubung dengan backend menggunakan **Axios**, melakukan kalkulasi harga yang akurat berdasarkan master data, menghitung potongan harga dari koin, dan menyimpan data pesanan beserta log riwayat transaksinya secara aman menggunakan *Database Transactions*.

## 2. Keterkaitan Frontend (*View & Client-Side*)
* `resources/views/warga/pesan/create.blade.php` (Berisi form Alpine.js `x-data` multi-step).
* `resources/views/warga/pesan/berhasil.blade.php` (Halaman sukses/resi).
* **Peringatan:** File `create.blade.php` tidak memakai elemen `<form>` HTML biasa. AI harus memodifikasi fungsi `processPayment()` di dalam Alpine.js agar mengirim data *state* (kategori, jadwal, catatan, alamat id, jumlah koin) ke *Endpoint/Route Backend* menggunakan metode `axios.post`.

## 3. Fokus Database (*Schema Reference*)
* Tabel `pengaturan_sistem` (Kolom: `harga_kategori_kecil`, `harga_kategori_sedang`, `harga_kategori_besar`, dan `konversi_koin_rupiah`).
* Tabel `pesanan_pengangkutan` (Tabel utama transaksi. Kolom: `id`, `warga_id`, `komplek_id`, `nama_alamat_snapshot`, `blok_nomor_rumah`, `kategori_sampah`, `nama_hari_penjemputan`, `catatan_warga`, `koin_digunakan`, `harga_awal`, `total_harga_akhir`, `status`, `status_pembayaran`).
* Tabel `riwayat_status_pesanan` (Kolom: `pesanan_id`, `status`, `keterangan`).
* Tabel `alamat_warga` (Untuk mengambil snapshot teks alamat).
* Tabel `users` (Kolom: `saldo_koin` - untuk memotong saldo warga).

## 4. Alur Fungsional (*Business Logic Flow*)
* **Kalkulasi Server-Side:** Saat backend menerima *request*, jangan langsung percaya harga dari frontend. Ambil harga dari tabel `pengaturan_sistem` berdasarkan nilai `kategori_sampah`.
* **Sistem Koin (Dinamis):** Jika *request* menyertakan penggunaan koin:
  1. Pastikan `koin_digunakan` tidak melebihi `saldo_koin` Warga saat ini (`Auth::user()->saldo_koin`). 
  2. Ambil nilai konversi koin dari tabel `pengaturan_sistem` (kolom `konversi_koin_rupiah`). **JANGAN di-hardcode!**
  3. Hitung potongan harga: `koin_digunakan * konversi_koin_rupiah`.
  4. Maksimal penggunaan koin (potongan harga) tidak boleh melebihi 50% dari harga dasar pesanan.
  5. Jika lolos validasi, gunakan `App\Services\CoinService::deductCoins()` (buat class/method-nya jika belum ada) untuk memotong saldo Warga agar transaksi ini tercatat otomatis ke tabel `riwayat_koin` tipe 'keluar'.
* **Snapshot Alamat:** Cari data `alamat_warga` berdasarkan ID alamat yang dikirim. Ekstrak *string* teksnya dan simpan ke kolom snapshot di `pesanan_pengangkutan`. Ini mencegah transaksi kehilangan data lokasi jika warga menghapus alamat mereka di masa depan.
* **Status Simulasi Pembayaran:** Karena tidak ada *Payment Gateway* pihak ketiga, buat pesanan secara otomatis memiliki `status_pembayaran = 'paid'` dan `status = 'menunggu'`.
* **Insert Log:** Setelah tabel pesanan berhasil diisi, lakukan *insert* ke tabel `riwayat_status_pesanan` dengan keterangan "Pesanan baru berhasil dibuat dan telah lunas".
* **Notifikasi:** Setelah berhasil, panggil `NotificationService::send()` kepada Petugas (ambil `user_id` petugas yang mengelola `komplek_id` terkait) dengan pesan "Pesanan Pengangkutan Baru di area Anda" dan tipe `'info'`.

## 5. Daftar Route & Controller (*Routing Map*)
* Buat `App\Http\Controllers\Warga\PesananController`.
* Route: `POST /warga/pesan/checkout` -> Method `store` (Khusus menerima request Axios).
* Route: `GET /warga/pesan/berhasil/{id}` -> Method `success` (Untuk menampilkan halaman resi yang datanya di-*query* dari database).

## 6. Aturan Validasi Data (*Form Request Validation*)
Pesan validasi Laravel untuk Method `store`:
* `alamat_id` (required, exists:alamat_warga,id).
* `kategori` (required, string, in:Kecil,Sedang,Besar).
* `jadwal` (required, string).
* `koin` (nullable, integer, min:0).
* `catatan` (nullable, string).

## 7. Penanganan Error & Kasus Khusus (*Edge Cases*)
* **Wajib Gunakan DB Transaction (`DB::beginTransaction()` dan `DB::commit()`):** Jika *insert* ke tabel pesanan berhasil tetapi pemotongan koin di tabel *users* gagal, proses harus di-*rollback* total.
* **Kelebihan Saldo/Potongan:** Jika user nakal mengirim nilai koin di atas batas saldo mereka atau nilai potongannya di atas 50% tagihan, kembalikan response error/`abort(422, 'Penggunaan koin tidak valid')`.

## 8. Struktur Kembalian (*Response Format*)
* Fungsi `store` ini **WAJIB mengembalikan JSON** karena akan ditangkap oleh Alpine/Axios di frontend.
* *Return Statement*: `return response()->json(['status' => 'success', 'redirect_url' => route('warga.pesan.berhasil', $pesanan->id)]);`
* Alpine.js kemudian menggunakan URL tersebut untuk `window.location.href = response.data.redirect_url;`.
