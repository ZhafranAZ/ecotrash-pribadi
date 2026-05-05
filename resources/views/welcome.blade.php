<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth scroll-pt-[72px]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EcoTrash - Kelola Sampah Komplek</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background text-on-background font-body-md antialiased selection:bg-primary/20 selection:text-primary">
    <!-- Sticky Header -->
    <header class="sticky top-0 z-50 bg-surface/80 backdrop-blur-md border-b border-outline-variant transition-all">
        <div class="max-w-[1280px] mx-auto px-10 flex items-center justify-between h-[72px]">
            <div class="flex items-center gap-3 text-primary">
                <span class="material-symbols-outlined text-[28px]"
                    style="font-variation-settings: 'FILL' 1;">eco</span>
                <h2 class="text-on-surface font-title-sm font-bold tracking-tight">EcoTrash</h2>
            </div>
            <nav class="hidden md:flex items-center gap-8">
                <a class="text-on-surface-variant hover:text-primary text-sm font-medium transition-colors"
                    href="#">Beranda</a>
                <a class="text-on-surface-variant hover:text-primary text-sm font-medium transition-colors"
                    href="#fitur">Fitur</a>
                <a class="text-on-surface-variant hover:text-primary text-sm font-medium transition-colors"
                    href="#cara-kerja">Cara Kerja</a>
                <a class="text-on-surface-variant hover:text-primary text-sm font-medium transition-colors"
                    href="#kontak">Kontak</a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="/login"
                    class="text-primary hover:text-primary-dark text-sm font-bold transition-all hover:-translate-y-0.5 active:scale-95">Masuk</a>
                <a href="/register"
                    class="bg-primary hover:bg-primary-dark text-on-primary text-sm font-bold h-10 px-6 rounded-lg transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/20 active:scale-95 flex items-center justify-center">
                    Daftar Akun
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative pt-12 pb-24 px-10 overflow-hidden">
            <div class="max-w-[1280px] mx-auto">
                <div class="rounded-[24px] overflow-hidden relative min-h-[560px] flex items-center"
                    style="background-image: linear-gradient(to right, rgba(18, 28, 42, 0.9) 0%, rgba(18, 28, 42, 0.4) 100%), url('http://127.0.0.1:8000/images/Landingpage_Title.png'); background-size: cover; background-position: center;">
                    <div class="relative z-10 max-w-[640px] px-8 md:px-16 py-12 flex flex-col gap-6">
                        <span
                            class="inline-flex items-center self-start gap-1.5 px-3 py-1 rounded-full bg-primary/20 text-white text-xs font-bold uppercase tracking-wider backdrop-blur-sm border border-primary/30">
                            <span class="material-symbols-outlined text-[14px]">stars</span> Premium Service
                        </span>
                        <h1
                            class="text-white text-[40px] md:text-display-lg font-bold leading-tight tracking-[-0.02em]">
                            Kelola Sampah Komplek Lebih Mudah, Bersih, dan Menguntungkan
                        </h1>
                        <p class="text-white text-lg md:text-[18px] leading-relaxed max-w-[540px]">
                            Jadwalkan penjemputan sampah, laporkan masalah kebersihan dengan cepat, dan dapatkan koin
                            reward untuk setiap aksi baik Anda demi lingkungan.
                        </p>
                        <div class="pt-4 flex flex-wrap gap-4">
                            <a href="#cta"
                                class="bg-primary hover:bg-primary-dark text-on-primary text-base font-bold h-12 px-8 rounded-lg transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/30 active:scale-95 flex items-center justify-center gap-2 shadow-lg shadow-primary/20 inline-flex">
                                Mulai Bersihkan Lingkungan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 px-10 bg-surface" id="fitur">
            <div class="max-w-[1280px] mx-auto flex flex-col gap-12">
                <div class="flex flex-col gap-4 text-center items-center">
                    <h2 class="text-primary font-label-caps uppercase tracking-[0.05em]">Layanan Cerdas</h2>
                    <h3 class="text-on-surface text-[32px] md:text-headline-md font-bold leading-tight max-w-[720px]">
                        Apa yang Bisa Anda Lakukan dengan EcoTrash?
                    </h3>
                    <p class="text-on-surface-variant text-body-md max-w-[600px]">
                        Platform terintegrasi untuk menciptakan lingkungan perumahan yang lebih bersih, asri, dan
                        bernilai.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Feature 1 -->
                    <div class="glass-card rounded-xl p-6 flex flex-col gap-4">
                        <div
                            class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center text-primary mb-2">
                            <span class="material-symbols-outlined text-[24px]">calendar_month</span>
                        </div>
                        <h4 class="text-on-surface font-title-sm font-bold leading-tight">Jemput Sampah Terjadwal</h4>
                        <p class="text-on-surface-variant text-sm leading-relaxed">
                            Atur jadwal penjemputan sampah rumah tangga secara rutin tanpa perlu repot mengingatkan
                            petugas.
                        </p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="glass-card rounded-xl p-6 flex flex-col gap-4">
                        <div
                            class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center text-primary mb-2">
                            <span class="material-symbols-outlined text-[24px]">campaign</span>
                        </div>
                        <h4 class="text-on-surface font-title-sm font-bold leading-tight">Lapor Sampah Liar</h4>
                        <p class="text-on-surface-variant text-sm leading-relaxed">
                            Temukan tumpukan sampah liar? Foto dan laporkan langsung untuk penanganan instan oleh tim
                            kami.
                        </p>
                    </div>
                    <!-- Feature 3 (Gold Accent) -->
                    <div class="glass-card rounded-xl p-6 flex flex-col gap-4 relative overflow-hidden group/coin"
                        style="border-color: rgba(245, 158, 11, 0.6); background: linear-gradient(145deg, rgba(255,255,255,0.9) 0%, rgba(245, 158, 11, 0.1) 100%);">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-accent/20 rounded-full blur-3xl -mr-12 -mt-12 group-hover/coin:bg-accent/30 transition-all duration-500">
                        </div>
                        <div
                            class="w-12 h-12 rounded-lg bg-accent/20 flex items-center justify-center text-accent mb-2 relative z-10 shadow-[0_0_15px_rgba(245,158,11,0.3)]">
                            <span class="material-symbols-outlined text-[24px]"
                                style="font-variation-settings: 'FILL' 1;">monetization_on</span>
                        </div>
                        <h4 class="text-on-surface font-title-sm font-bold leading-tight relative z-10">Kumpulkan Koin
                            Reward</h4>
                        <p class="text-on-surface-variant text-sm leading-relaxed relative z-10">
                            Setiap aksi positif Anda menghasilkan koin yang bisa ditukar dengan potongan iuran atau
                            hadiah menarik.
                        </p>
                    </div>
                    <!-- Feature 4 -->
                    <div class="glass-card rounded-xl p-6 flex flex-col gap-4">
                        <div
                            class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center text-primary mb-2">
                            <span class="material-symbols-outlined text-[24px]">menu_book</span>
                        </div>
                        <h4 class="text-on-surface font-title-sm font-bold leading-tight">Edukasi Lingkungan</h4>
                        <p class="text-on-surface-variant text-sm leading-relaxed">
                            Akses panduan praktis memilah sampah dan tips mendaur ulang untuk gaya hidup berkelanjutan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-24 px-10 bg-surface-container-low" id="cara-kerja">
            <div class="max-w-[800px] mx-auto flex flex-col gap-12 items-center text-center">
                <div class="flex flex-col gap-4 items-center">
                    <h2 class="text-primary font-label-caps uppercase tracking-[0.05em]">Alur Proses</h2>
                    <h3 class="text-on-surface text-[32px] md:text-headline-md font-bold leading-tight">
                        Bagaimana Cara Kerjanya?
                    </h3>
                    <p class="text-on-surface-variant text-body-md mb-4 max-w-[600px]">
                        Sistem kami dirancang agar sangat mudah digunakan oleh seluruh warga komplek, dari pendaftaran
                        hingga mendapatkan reward.
                    </p>
                </div>
                <div class="flex flex-col gap-8 text-left w-full max-w-[600px]">
                    <div class="flex items-start gap-6">
                        <div
                            class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-on-primary font-bold shrink-0 shadow-md text-lg">
                            1</div>
                        <div>
                            <h4 class="text-on-surface font-bold text-xl mb-2">Daftar &amp; Atur Alamat</h4>
                            <p class="text-on-surface-variant text-base">Buat akun dengan mudah dan masukkan detail
                                alamat rumah Anda di dalam komplek.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div
                            class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center text-primary font-bold shrink-0 border border-outline-variant text-lg">
                            2</div>
                        <div>
                            <h4 class="text-on-surface font-bold text-xl mb-2">Pesan atau Lapor</h4>
                            <p class="text-on-surface-variant text-base">Pilih jadwal rutin penjemputan atau laporkan
                                tumpukan sampah insidental melalui aplikasi.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div
                            class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center text-primary font-bold shrink-0 border border-outline-variant text-lg">
                            3</div>
                        <div>
                            <h4 class="text-on-surface font-bold text-xl mb-2">Petugas Bergerak</h4>
                            <p class="text-on-surface-variant text-base">Tim kami yang profesional akan datang tepat
                                waktu sesuai jadwal dan lokasi laporan.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6 relative group/step">
                        <div
                            class="w-12 h-12 rounded-full bg-accent/20 flex items-center justify-center text-accent font-bold shrink-0 shadow-[0_0_20px_rgba(245,158,11,0.5)] text-lg border border-accent/30 group-hover/step:scale-110 transition-transform">
                            4</div>
                        <div>
                            <h4 class="text-on-surface font-bold text-xl mb-2">Terima Koin</h4>
                            <p class="text-on-surface-variant text-base">Sistem otomatis mencatat partisipasi Anda dan
                                koin reward akan langsung masuk ke dompet digital Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pre-Footer CTA -->
        <section id="cta" class="py-24 px-10 bg-surface relative overflow-hidden">
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary-container/10 rounded-full blur-[100px] pointer-events-none">
            </div>
            <div
                class="max-w-[800px] mx-auto text-center relative z-10 glass-card rounded-[2rem] p-12 md:p-16 border border-primary/20 bg-white/60">
                <span class="material-symbols-outlined text-[48px] text-primary mb-6 block">compost</span>
                <h2 class="text-on-surface text-[32px] md:text-[40px] font-bold leading-tight mb-6">
                    Siap Mewujudkan Komplek Perumahan yang Lebih Bersih?
                </h2>
                <p class="text-on-surface-variant text-lg mb-8 max-w-[600px] mx-auto">
                    Bergabunglah dengan ratusan komplek lainnya yang telah beralih ke pengelolaan sampah modern,
                    efisien, dan menguntungkan.
                </p>
                <a href="/register"
                    class="bg-primary hover:bg-primary-container text-on-primary text-base font-bold h-14 px-10 rounded-xl transition-all hover:scale-105 shadow-[0_10px_20px_-5px_rgba(0,108,73,0.3)] mx-auto inline-flex items-center justify-center">
                    Daftar Akun Warga Sekarang
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="kontak"
        class="bg-gradient-to-b from-primary-darker to-primary text-white/90 pt-16 pb-8 px-10 relative overflow-hidden">
        <div class="max-w-[1280px] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-white/10 pb-12 mb-8">
                <div class="md:col-span-2 flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-white opacity-90">
                        <span class="material-symbols-outlined text-[24px]"
                            style="font-variation-settings: 'FILL' 1;">eco</span>
                        <span class="font-title-sm font-bold tracking-wide">EcoTrash</span>
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed max-w-[400px]">
                        Solusi premium pengelolaan sampah untuk perumahan modern. Menggabungkan teknologi, kepedulian
                        lingkungan, dan sistem reward yang transparan.
                    </p>
                    <div class="flex flex-col gap-3 mt-4">
                        <span class="text-white/100 text-xs font-bold uppercase tracking-wider">Social</span>
                        <div class="flex items-center gap-4">
                            <a href="mailto:contact@ecotrash.id"
                                class="text-white/60 hover:text-white transition-colors" aria-label="Email">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z" />
                                </svg>
                            </a>
                            <a href="https://instagram.com/ecotrash" target="_blank"
                                class="text-white/60 hover:text-white transition-colors" aria-label="Instagram">
                                <svg class="w-6 h-5 fill-current" viewBox="0 0 24 26"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                            </a>
                            <a href="#" target="_blank" class="text-white/60 hover:text-white transition-colors"
                                aria-label="TikTok">
                                <svg class="w-6 h-5 fill-current" viewBox="0 0 24 28"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 2.78-1.15 5.54-3.33 7.37-1.94 1.62-4.64 2.11-7.13 1.5-3.16-.73-5.55-3.41-5.98-6.59-.44-3.17 1.28-6.4 4.14-7.63 1.25-.56 2.65-.74 4.02-.68V14.9c-1.45.02-2.93.38-4.04 1.34-1.17 1.05-1.65 2.73-1.14 4.24.47 1.48 1.9 2.54 3.46 2.63 1.64.1 3.25-.66 4.08-2.06.63-1.07.82-2.34.8-3.58-.02-5.78-.01-11.56-.01-17.34l-.03-.01z" />
                                </svg>
                            </a>
                            <a href="#" target="_blank" class="text-white/60 hover:text-white transition-colors"
                                aria-label="YouTube">
                                <svg class="w-6 h-5 fill-current" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-2">Layanan</h4>
                    <a class="text-white/60 hover:text-white text-sm transition-colors" href="#">Jemput
                        Sampah</a>
                    <a class="text-white/60 hover:text-white text-sm transition-colors" href="#">Lapor Instan</a>
                    <a class="text-white/60 hover:text-white text-sm transition-colors" href="#">Tukar Koin
                        Reward</a>
                    <a class="text-white/60 hover:text-white text-sm transition-colors" href="#">Pusat
                        Edukasi</a>
                </div>
                <div class="flex flex-col gap-4">
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-2">Dukungan</h4>
                    <a class="text-white/60 hover:text-white text-sm transition-colors" href="#">Pusat
                        Bantuan</a>
                    <a class="text-white/60 hover:text-white text-sm transition-colors" href="#">Syarat &amp;
                        Ketentuan</a>
                    <a class="text-white/60 hover:text-white text-sm transition-colors" href="#">Kebijakan
                        Privasi</a>
                    <a class="text-white/60 hover:text-white text-sm transition-colors" href="#">Hubungi Kami</a>
                </div>
            </div>
            <div
                class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-outline-variant relative z-10">
                <p>© 2026 EcoTrash Indonesia. Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-4">
                    <a class="hover:text-white transition-colors" href="#"><span
                            class="material-symbols-outlined text-[20px]">language</span></a>
                    <a class="hover:text-white transition-colors" href="#">ID | EN</a>
                </div>
            </div>

            <!-- Giant EcoTrash Text -->
            <div class="w-full flex justify-center mt-12 md:mt-20 relative z-0">
                <span
                    class="text-[14vw] md:text-[14vw] font-black leading-[0.8] tracking-[-0.004em] text-white/80 select-none pointer-events-none">
                    EcoTrash
                </span>
            </div>
        </div>
    </footer>
</body>

</html>