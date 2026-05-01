# Rencana Implementasi Frontend Warga (EcoTrash)

Dokumen ini adalah rencana teknis (*draft*) untuk membangun antarmuka pengguna (UI) Role Warga, yang dirancang secara khusus dengan pendekatan **Mobile-First**. Struktur data yang ditampilkan mengacu pada `Database_Schema.md` dan panduan visual dari `UIUX_Warga.md`.

---

## 1. Arsitektur Layout Utama (`resources/js/Layouts/WargaLayout.jsx`)

Karena target utamanya adalah pengguna *smartphone*, kita akan membuat layout khusus untuk Warga yang berbeda dari Admin.
- **Header:** Sticky header sederhana (hanya muncul di halaman tertentu).
- **Bottom Navigation Bar:** Navigasi tetap di bawah layar dengan 4 menu utama:
  - 🏠 Beranda (Home)
  - 📋 Aktivitas (Riwayat)
  - 📚 Edukasi
  - 👤 Profil
- **Teknologi:** React.js, Inertia.js, Tailwind CSS untuk *styling*, Framer Motion (opsional) untuk interaktivitas dan animasi.

---

## 2. Rincian Halaman & Integrasi Data

### A. Beranda / Dasbor (`resources/js/Pages/Warga/Dashboard.jsx`)
Ini adalah halaman pendaratan utama setelah warga login.
- **Data (Props dari Inertia):**
  - `auth.user.nama`, `auth.user.saldo_koin`.
  - Status `pesanan_pengangkutan` aktif (jika ada).
- **Komponen UI:**
  - Kartu identitas (Nama & Saldo Koin).
  - 2 Tombol Aksi Utama (Besar & Jelas): **Pesan Pengangkutan** & **Lapor Sampah Liar**.
  - *Tracker* pesanan aktif (misal: "Pesanan Anda sedang menuju lokasi").
  - Widget Peta Mini (Leaflet.js terintegrasi React-Leaflet) yang menampilkan lokasi TPS terdekat atau titik kumpul.

### B. Alur Pemesanan Pengangkutan (`resources/js/Pages/Warga/Pesan/Create.jsx`)
Dibuat dengan gaya *Wizard* (langkah bertahap) dalam satu halaman menggunakan React State untuk transisi antar *step*.
- **Data (Input Warga -> `pesanan_pengangkutan`):**
  - Step 1: Pilih `alamat_warga.id` (Dropdown/Card) & `kategori_sampah` (Kecil/Sedang/Besar).
  - Step 2: Pilih Jadwal Penjemputan dalam bentuk *Card Hari* (berdasarkan ketersediaan operasional minggu berjalan) & input `catatan_warga`.
  - Step 3 (Checkout): Ringkasan `total_harga_akhir`, input `koin_digunakan`.
- **Komponen UI:**
  - Progress bar indikator langkah (1, 2, 3).
  - *Toggle button* untuk kategori sampah.
  - Antarmuka pemilihan jadwal berupa deretan kartu kalender horizontal (Misal: [Sen 11], [Sel 12], dst) yang bisa di-*tap*.
  - Kartu rincian pembayaran dengan opsi *slider/input* untuk potong saldo koin.

### C. Alur Lapor Sampah Liar (`resources/js/Pages/Warga/Lapor/Create.jsx`)
- **Data (Input Warga -> `laporan_sampah_liar`):**
  - `lat`, `lng`, `foto_laporan_warga`, `deskripsi`.
- **Komponen UI:**
  - Peta Interaktif (React-Leaflet) *fullscreen* untuk meletakkan pin lokasi (akurasi tinggi).
  - Area *Upload* foto yang ramah sentuhan.
  - Form deskripsi.

### D. Aktivitas / Riwayat (`resources/js/Pages/Warga/Aktivitas/Index.jsx`)
- **Data (Props Tabel `pesanan_pengangkutan` & `laporan_sampah_liar`):**
  - Menarik data berdasarkan `warga_id`.
- **Komponen UI:**
  - *Tabs Switcher* menggunakan React State di bagian atas: **Pesanan** | **Laporan**.
  - Daftar kartu (*Card List*) berisi ringkasan riwayat.
  - Label status menggunakan warna yang berbeda (Kuning: Menunggu, Biru: Diproses, Hijau: Selesai, Merah: Batal).
  - Modal detail resi (muncul dari bawah - *Bottom Sheet* menggunakan Headless UI / Framer Motion).

### E. Edukasi (`resources/js/Pages/Warga/Edukasi/Index.jsx` & `Show.jsx`)
- **Data (Props Tabel `artikel_edukasi` & `bookmark_artikel`):**
  - Menampilkan daftar artikel dan status bookmark.
- **Komponen UI:**
  - *Search bar* di bagian atas.
  - Tampilan kartu *grid* atau *list* dengan gambar thumbnail (`gambar_thumbnail`).
  - Tombol simpan/bookmark (Bintang).

### F. Profil (`resources/js/Pages/Warga/Profil/Index.jsx`)
- **Data (Props Tabel `users` & `alamat_warga`):**
  - Informasi akun, manajemen daftar alamat.
- **Komponen UI:**
  - Menu vertikal (List view).
  - Modal/Halaman terpisah untuk "Kelola Alamat" (Tambah/Edit Alamat dengan koneksi ke data `komplek`).

---

## 3. Desain Visual & Tema (Aesthetics)
Sesuai arahan, UI akan dibuat:
- **Premium Forest Theme:** Dominasi warna putih/bersih (`bg-surface`) dengan aksen Hijau (`#10B981`) dan Emas/Amber (`#F59E0B`) untuk fitur Koin/Reward.
- **Glassmorphism Ringan:** Kartu-kartu akan memiliki bayangan lembut (`shadow-sm`) dan sedikit transparansi pada header agar terlihat modern.
- **Responsif:** Lebar maksimal konten dibatasi (`max-w-md` atau `max-w-lg`) lalu diposisikan di tengah layar (`mx-auto`) agar tetap terlihat proporsional jika dibuka di Desktop/Tablet, namun memberikan pengalaman menyerupai aplikasi *mobile* sejati.

---

## Urutan Eksekusi (Langkah Selanjutnya):
1. Membuat layout utama (`WargaLayout.jsx`) lengkap dengan Bottom Navigation.
2. Membuat tampilan **Beranda (Dashboard)** Warga.
3. Membuat **Form Pemesanan & Lapor** (dengan integrasi React-Leaflet).
4. Membuat halaman **Aktivitas, Edukasi, dan Profil**.

