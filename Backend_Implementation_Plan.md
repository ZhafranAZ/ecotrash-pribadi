# Rencana Implementasi Backend & Database EcoTrash

## Keputusan Arsitektur & Teknologi

Berdasarkan diskusi kita, berikut adalah teknologi dan pendekatan yang akan digunakan untuk *backend*:

### 1. Penyimpanan File (Storage)
*   **Fase Development (Sekarang):** Kita akan menggunakan *local storage* bawaan Laravel (`storage/app/public` via `php artisan storage:link`). Ini yang paling cepat dan gratis untuk dikembangkan di komputer lokal.
*   **Fase Deployment (Nanti):** Idealnya, saat aplikasi di-*deploy* ke *production* (terutama di server cloud), gambar tidak boleh disimpan di *folder* aplikasi. Praktik terbaik (*Best Practice*) adalah menggunakan **Object Storage** seperti Amazon S3 (AWS), Google Cloud Storage, atau Cloudinary. 
*   **Strategi Kode:** Saya akan memprogram penyimpanannya menggunakan fitur `Storage::disk('public')` milik Laravel. Keunggulannya, ketika Anda mau *deploy* ke AWS S3 nanti, Anda **tidak perlu mengubah kode sama sekali**, cukup mengubah konfigurasi di file `.env` saja.

### 2. Simulasi Pembayaran
*   Untuk saat ini, kita akan menggunakan **Simulasi Database**. Saat warga menekan tombol bayar pada *modal* QRIS/Transfer, *frontend* akan mengirim *request* ke *backend*, dan database akan langsung memperbarui status dari `menunggu_pembayaran` menjadi `paid` tanpa memanggil pihak ketiga.

### 3. Sistem Notifikasi (Real-time)
*   Karena Anda menginginkan notifikasi langsung *real-time* (tanpa *refresh* halaman), kita akan menggunakan **Laravel Reverb** (fitur WebSocket bawaan terbaru Laravel 11) dikombinasikan dengan **Laravel Echo** di sisi *frontend* (Alpine.js).
*   Setiap kali ada pesanan baru, laporan liar, atau perubahan ukuran dari petugas, *backend* akan melakukan *Broadcasting Event* yang akan ditangkap seketika oleh *browser* pengguna.

---

## Roadmap Tahapan Implementasi

Proses *backend* akan dikerjakan secara sistematis melalui tahapan berikut:

### Tahap 1: Fondasi Database & Autentikasi (Fokus Pertama)
1.  **Migrations:** Membuat struktur tabel fisik di database berdasarkan `Database_Schema.md`.
2.  **Models & Relationships:** Menyambungkan relasi antar tabel (contoh: `User` memiliki banyak `Pesanan`).
3.  **Seeders:** Membuat data awal untuk *testing* (1 Akun Admin, Warga dummy, Petugas dummy, Master Komplek, dan Pengaturan Sistem).
4.  **Autentikasi Multi-Role:** Menyesuaikan alur *login/register* agar Warga, Petugas, dan Admin diarahkan ke *dashboard* masing-masing, serta memasang *Middleware* keamanan.

### Tahap 2: Setup Real-time & Notifikasi
1.  **Instalasi Laravel Reverb & Echo:** Mengonfigurasi WebSocket server lokal.
2.  **Sistem Notifikasi Database:** Menyimpan histori notifikasi ke dalam tabel `notifikasi`.
3.  **Broadcasting:** Membuat *Event* Laravel (misal: `PesananDibuat`) yang otomatis mengirimkan data ke lonceng notifikasi di UI secara *real-time*.

### Tahap 3: Manajemen Profil & Data Master
1.  **Profil Warga:** Integrasi API untuk *upload* foto profil dan manajemen multi-alamat (CRUD Alamat).
2.  **Admin:** Membuat fungsi pengubahan Pengaturan Sistem (Harga koin, batas waktu) dan Master Komplek.

### Tahap 4: Core Transaction (Pemesanan Angkut Sampah)
1.  **Kalkulasi Warga:** Logika pemesanan, pengecekan harga/koin berdasarkan `pengaturan_sistem`, dan simpan data ke tabel `pesanan_pengangkutan`.
2.  **Simulasi Pembayaran:** Endpoint untuk mengubah status pembayaran QRIS/Transfer.

### Tahap 5: Operasional Petugas & Resolusi
1.  **Tugas Petugas:** API untuk memuat tugas berdasarkan area, mengubah status menjadi *Proses*, dan *Upload* Foto Bukti Selesai.
2.  **Kendala Lapangan:** Fitur laporan beda ukuran (memicu tagihan selisih ke warga) atau pagar tertutup (batal otomatis).
3.  **Lapor Sampah Liar:** Integrasi *upload* laporan dan persetujuan Admin.
