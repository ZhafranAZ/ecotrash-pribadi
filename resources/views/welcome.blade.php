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
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        <section class="py-24 px-10 bg-surface-container-low overflow-hidden" id="cara-kerja">
            <div class="max-w-[1280px] mx-auto flex flex-col gap-16 items-center">
                <div class="flex flex-col gap-4 items-center text-center max-w-[800px]">
                    <h2 class="text-primary font-label-caps uppercase tracking-[0.05em]">Alur Proses</h2>
                    <h3 class="text-on-surface text-[32px] md:text-headline-md font-bold leading-tight">
                        Bagaimana Cara Kerjanya?
                    </h3>
                    <p class="text-on-surface-variant text-body-md mb-4 max-w-[600px]">
                        Sistem kami dirancang agar sangat mudah digunakan oleh seluruh warga komplek, dari pendaftaran
                        hingga mendapatkan reward.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center w-full relative"
                    x-data="{ scene: 1, animatingBalance: false }"
                    x-init="setInterval(() => { scene = scene >= 3 ? 1 : scene + 1; if(scene===3){ animatingBalance=true; setTimeout(()=>animatingBalance=false, 2000); } }, 4500)">

                    <!-- Ambient Glow Background behind the grid -->
                    <div
                        class="absolute top-1/2 left-1/4 -translate-y-1/2 w-[400px] h-[400px] bg-primary/10 blur-[100px] rounded-full pointer-events-none -z-10">
                    </div>

                    <!-- Animation Column -->
                    <div
                        class="w-full h-[460px] relative rounded-3xl bg-white/60 backdrop-blur-sm border border-outline-variant shadow-sm flex flex-col items-center justify-center overflow-hidden">

                        <style>
                            /* ---- Scene Transitions ---- */
                            [x-cloak] {
                                display: none !important;
                            }

                            .scene-enter {
                                animation: sceneFadeIn 0.5s ease forwards;
                            }

                            .scene-leave {
                                animation: sceneFadeOut 0.4s ease forwards;
                            }

                            @keyframes sceneFadeIn {
                                from {
                                    opacity: 0;
                                    transform: translateY(12px);
                                }

                                to {
                                    opacity: 1;
                                    transform: translateY(0);
                                }
                            }

                            @keyframes sceneFadeOut {
                                from {
                                    opacity: 1;
                                }

                                to {
                                    opacity: 0;
                                }
                            }

                            /* ---- Scene 1: Cursor & Success ---- */
                            @keyframes s1CursorMove {
                                0% {
                                    transform: translate(100px, 80px);
                                    opacity: 0;
                                }

                                20% {
                                    transform: translate(100px, 80px);
                                    opacity: 1;
                                }

                                50% {
                                    transform: translate(0, 0);
                                }

                                60% {
                                    transform: translate(0, 0) scale(0.85);
                                }

                                /* click */
                                65% {
                                    transform: translate(0, 0) scale(1);
                                }

                                85% {
                                    transform: translate(-30px, 60px);
                                    opacity: 1;
                                }

                                100% {
                                    transform: translate(-30px, 60px);
                                    opacity: 0;
                                }
                            }

                            @keyframes s1Ripple {

                                0%,
                                60% {
                                    transform: scale(0.5);
                                    opacity: 0;
                                }

                                65% {
                                    opacity: 0.7;
                                }

                                100% {
                                    transform: scale(2.8);
                                    opacity: 0;
                                }
                            }

                            @keyframes s1SuccessBtn {

                                0%,
                                60% {
                                    fill: #006c49;
                                    width: 104px;
                                    x: 18px;
                                }

                                65%,
                                95% {
                                    fill: #10b981;
                                    width: 40px;
                                    x: 50px;
                                }

                                100% {
                                    fill: #006c49;
                                    width: 104px;
                                    x: 18px;
                                }
                            }

                            @keyframes s1SuccessText {

                                0%,
                                55% {
                                    opacity: 1;
                                }

                                60%,
                                100% {
                                    opacity: 0;
                                }
                            }

                            @keyframes s1Checkmark {

                                0%,
                                60% {
                                    opacity: 0;
                                    transform: scale(0);
                                }

                                65%,
                                95% {
                                    opacity: 1;
                                    transform: scale(1);
                                }

                                100% {
                                    opacity: 0;
                                    transform: scale(0);
                                }
                            }

                            .s1-cursor {
                                animation: s1CursorMove 4.5s infinite cubic-bezier(0.22, 1, 0.36, 1);
                            }

                            .s1-ripple-1 {
                                animation: s1Ripple 4.5s 0s infinite ease-out;
                            }

                            .s1-ripple-2 {
                                animation: s1Ripple 4.5s 0.15s infinite ease-out;
                            }

                            .s1-ripple-3 {
                                animation: s1Ripple 4.5s 0.3s infinite ease-out;
                            }

                            .s1-btn {
                                animation: s1SuccessBtn 4.5s infinite cubic-bezier(0.22, 1, 0.36, 1);
                            }

                            .s1-text {
                                animation: s1SuccessText 4.5s infinite;
                            }

                            .s1-check {
                                animation: s1Checkmark 4.5s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                                transform-origin: 70px 148px;
                            }

                            /* ---- Scene 2: Truck Parallax ---- */
                            @keyframes s2Truck {
                                0% {
                                    transform: translateX(-130%);
                                }

                                30% {
                                    transform: translateX(0);
                                }

                                70% {
                                    transform: translateX(0);
                                }

                                100% {
                                    transform: translateX(130%);
                                }
                            }

                            @keyframes s2Wheel {
                                0% {
                                    transform: rotate(0deg);
                                }

                                30% {
                                    transform: rotate(360deg);
                                }

                                70% {
                                    transform: rotate(360deg);
                                }

                                100% {
                                    transform: rotate(720deg);
                                }
                            }

                            @keyframes s2Pin {

                                0%,
                                100% {
                                    transform: translateY(0);
                                }

                                50% {
                                    transform: translateY(-7px);
                                }
                            }

                            @keyframes s2RoadMove {
                                0% {
                                    background-position: 0 0;
                                }

                                30% {
                                    background-position: -80px 0;
                                }

                                70% {
                                    background-position: -80px 0;
                                }

                                100% {
                                    background-position: -160px 0;
                                }
                            }

                            @keyframes s2TrashVanish {

                                0%,
                                55% {
                                    opacity: 1;
                                    transform: scale(1);
                                }

                                65%,
                                100% {
                                    opacity: 0;
                                    transform: scale(0);
                                }
                            }

                            .s2-truck {
                                animation: s2Truck 4.5s cubic-bezier(0.22, 1, 0.36, 1) infinite;
                            }

                            .s2-wheel {
                                animation: s2Wheel 4.5s cubic-bezier(0.22, 1, 0.36, 1) infinite;
                                transform-origin: center;
                            }

                            .s2-pin {
                                animation: s2Pin 1s ease-in-out infinite;
                            }

                            .s2-road {
                                background-image: linear-gradient(90deg, transparent 50%, rgba(108, 122, 113, 0.3) 50%);
                                background-size: 40px 2px;
                                animation: s2RoadMove 4.5s cubic-bezier(0.22, 1, 0.36, 1) infinite;
                            }

                            .s2-trash {
                                animation: s2TrashVanish 4.5s infinite;
                                transform-origin: center bottom;
                            }

                            /* ---- Scene 3 ---- */
                            @keyframes s3CoinFall {
                                0% {
                                    transform: translateY(-70px) rotateY(0deg);
                                    opacity: 0;
                                }

                                20% {
                                    opacity: 1;
                                }

                                80% {
                                    transform: translateY(0) rotateY(540deg);
                                    opacity: 1;
                                }

                                95%,
                                100% {
                                    transform: translateY(6px) scale(0.6);
                                    opacity: 0;
                                }
                            }

                            @keyframes s3Reward {

                                0%,
                                60% {
                                    opacity: 0;
                                    transform: translateY(10px);
                                }

                                75% {
                                    opacity: 1;
                                    transform: translateY(0);
                                }

                                90%,
                                100% {
                                    opacity: 0;
                                    transform: translateY(-8px);
                                }
                            }

                            @keyframes s3Sparkle {

                                0%,
                                50% {
                                    transform: scale(0) rotate(0deg);
                                    opacity: 0;
                                }

                                65% {
                                    transform: scale(1.2) rotate(45deg);
                                    opacity: 0.8;
                                }

                                80% {
                                    transform: scale(1) rotate(90deg);
                                    opacity: 0.5;
                                }

                                100% {
                                    transform: scale(0) rotate(120deg);
                                    opacity: 0;
                                }
                            }

                            .s3-coin-1 {
                                animation: s3CoinFall 4.5s 0.2s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            .s3-coin-2 {
                                animation: s3CoinFall 4.5s 0.5s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            .s3-coin-3 {
                                animation: s3CoinFall 4.5s 0.8s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            .s3-reward {
                                animation: s3Reward 4.5s infinite ease-in-out;
                            }

                            .s3-sp-1 {
                                animation: s3Sparkle 4.5s 0.3s infinite;
                            }

                            .s3-sp-2 {
                                animation: s3Sparkle 4.5s 0.7s infinite;
                            }

                            .s3-sp-3 {
                                animation: s3Sparkle 4.5s 1.0s infinite;
                            }

                            .s3-sp-4 {
                                animation: s3Sparkle 4.5s 0.5s infinite;
                            }
                        </style>

                        <!-- ===== SCENE 1: Pesan & Lapor ===== -->
                        <div x-show="scene === 1" x-transition:enter="scene-enter" x-transition:leave="scene-leave"
                            class="absolute inset-0 flex flex-col items-center justify-center p-8">

                            <!-- Phone SVG -->
                            <div class="relative flex items-center justify-center" style="transform:rotate(-8deg);">
                                <svg width="140" height="230" viewBox="0 0 140 230" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="4" y="4" width="132" height="222" rx="20" stroke="#006c49" stroke-width="3"
                                        fill="white" />
                                    <rect x="50" y="12" width="40" height="8" rx="4" fill="#e6eeff" />
                                    <rect x="14" y="30" width="112" height="22" rx="4" fill="#006c49" />
                                    <text x="70" y="45" text-anchor="middle" font-family="Inter,sans-serif"
                                        font-size="9" font-weight="700" fill="white">EcoTrash</text>
                                    <rect x="20" y="64" width="70" height="7" rx="3" fill="#d9e3f6" />
                                    <rect x="20" y="78" width="50" height="7" rx="3" fill="#e6eeff" />

                                    <g>
                                        <!-- Ripple rings -->
                                        <circle cx="70" cy="148" r="20" stroke="#006c49" stroke-width="1.5"
                                            class="s1-ripple-1" fill="none" opacity="0" />
                                        <circle cx="70" cy="148" r="20" stroke="#006c49" stroke-width="1"
                                            class="s1-ripple-2" fill="none" opacity="0" />
                                        <circle cx="70" cy="148" r="20" stroke="#10b981" stroke-width="0.8"
                                            class="s1-ripple-3" fill="none" opacity="0" />
                                        <!-- Button -->
                                        <rect class="s1-btn" x="18" y="134" width="104" height="28" rx="8"
                                            fill="#006c49" />
                                        <text class="s1-text" x="70" y="152" text-anchor="middle"
                                            font-family="Inter,sans-serif" font-size="9" font-weight="600"
                                            fill="white">Pesan Sekarang</text>
                                        <!-- Checkmark -->
                                        <path class="s1-check" d="M63 148 L68 153 L77 143" stroke="white"
                                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"
                                            opacity="0" />
                                    </g>
                                    <rect x="55" y="210" width="30" height="4" rx="2" fill="#bbcabf" />
                                </svg>

                                <!-- macOS Cursor SVG -->
                                <div class="absolute s1-cursor" style="bottom: 50px; left: 80px; z-index: 20;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 3L18.5 10L12 12.5L14.5 19L11.5 20L9 13.5L4 16.5V3Z" fill="black"
                                            stroke="white" stroke-width="1.5" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- ===== SCENE 2: Petugas Bergerak ===== -->
                        <div x-show="scene === 2" x-transition:enter="scene-enter" x-transition:leave="scene-leave"
                            class="absolute inset-0 flex flex-col items-center justify-center px-8">

                            <div class="relative w-full flex flex-col items-center justify-end" style="height:220px;">
                                <!-- Parallax Road -->
                                <div class="absolute bottom-8 left-0 right-0 h-[2px] bg-outline-variant/30"></div>
                                <div class="s2-road absolute bottom-8 left-0 right-0 h-[2px]"></div>

                                <!-- Modern Minimalist House -->
                                <div class="absolute right-20 bottom-10 flex gap-2 items-end">
                                    <!-- Trash Bin -->
                                    <div class="s2-trash relative mb-0.5">
                                        <svg width="21" height="28" viewBox="0 0 12 16" fill="none" stroke="#6c7a71"
                                            stroke-width="1.2" stroke-linejoin="round">
                                            <path d="M2 3h8v12H2zM1 3h10M4 1v2M8 1v2" />
                                        </svg>
                                    </div>
                                    <!-- House -->
                                    <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="#006c49"
                                        stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 10L12 3l9 7" stroke-width="1" /> <!-- Roof -->
                                        <path d="M5 10v11h14V10" /> <!-- Body -->
                                        <rect x="9" y="14" width="6" height="7" /> <!-- Door -->
                                        <rect x="16" y="12" width="2" height="4" /> <!-- Window -->
                                        <rect x="6" y="12" width="2" height="4" /> Window
                                    </svg>
                                </div>

                                <!-- Compactor Truck -->
                                <div class="s2-truck absolute bottom-[38px]" style="width:180px;">
                                    <!-- Location pin -->
                                    <div class="s2-pin absolute -top-12 left-1/2 -translate-x-1/2">
                                        <svg width="20" height="26" viewBox="0 0 20 26" fill="none">
                                            <circle cx="10" cy="10" r="9" fill="#006c49" stroke="white"
                                                stroke-width="2" />
                                            <circle cx="10" cy="10" r="4" fill="white" />
                                            <path d="M10 19 L10 26" stroke="#006c49" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <!-- Modern Truck SVG -->
                                    <svg width="180" height="90" viewBox="0 0 180 90" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <!-- Compactor Body -->
                                        <path d="M10 20 L95 20 L95 70 L10 70 Z" fill="#eff4ff" stroke="#006c49"
                                            stroke-width="2.5" stroke-linejoin="round" />
                                        <path d="M20 20 L30 70 M40 20 L50 70 M60 20 L70 70 M80 20 L90 70"
                                            stroke="#006c49" stroke-width="1.5" stroke-opacity="0.2" />
                                        <!-- Cab -->
                                        <path d="M95 35 Q110 35 125 40 L135 70 L95 70 Z" fill="#eff4ff" stroke="#006c49"
                                            stroke-width="2.5" stroke-linejoin="round" />
                                        <!-- Windshield -->
                                        <path d="M100 40 Q110 40 120 44 L125 55 L100 55 Z" fill="#e6eeff"
                                            stroke="#006c49" stroke-width="1.5" stroke-linejoin="round" />
                                        <!-- Details -->
                                        <rect x="85" y="25" width="5" height="45" fill="#006c49" />
                                        <rect x="138" y="60" width="10" height="6" rx="2" fill="none" stroke="#006c49"
                                            stroke-width="1.5" />
                                        <!-- Wheels -->
                                        <g style="transform-origin:35px 70px;" class="s2-wheel">
                                            <circle cx="35" cy="70" r="14" stroke="#006c49" stroke-width="2.5"
                                                fill="white" />
                                            <circle cx="35" cy="70" r="5" stroke="#006c49" stroke-width="1.5"
                                                fill="none" />
                                            <circle cx="35" cy="70" r="2" fill="#006c49" />
                                        </g>
                                        <g style="transform-origin:70px 70px;" class="s2-wheel">
                                            <circle cx="70" cy="70" r="14" stroke="#006c49" stroke-width="2.5"
                                                fill="white" />
                                            <circle cx="70" cy="70" r="5" stroke="#006c49" stroke-width="1.5"
                                                fill="none" />
                                            <circle cx="70" cy="70" r="2" fill="#006c49" />
                                        </g>
                                        <g style="transform-origin:115px 70px;" class="s2-wheel">
                                            <circle cx="115" cy="70" r="14" stroke="#006c49" stroke-width="2.5"
                                                fill="white" />
                                            <circle cx="115" cy="70" r="5" stroke="#006c49" stroke-width="1.5"
                                                fill="none" />
                                            <circle cx="115" cy="70" r="2" fill="#006c49" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- ===== SCENE 3: Terima Koin ===== -->
                        <div x-show="scene === 3" x-transition:enter="scene-enter" x-transition:leave="scene-leave"
                            class="absolute inset-0 flex flex-col items-center justify-center p-8">

                            <div class="relative flex items-center justify-center" style="height:260px;width:200px;">
                                <!-- Sparkles -->
                                <div class="s3-sp-1 absolute" style="top:20px;left:10px;"><svg width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <path d="M6 0l1 5 5 1-5 1-1 5-1-5-5-1 5-1z" fill="#F59E0B" />
                                    </svg></div>
                                <div class="s3-sp-2 absolute" style="top:15px;right:15px;"><svg width="10" height="10"
                                        viewBox="0 0 12 12">
                                        <path d="M6 0l1 5 5 1-5 1-1 5-1-5-5-1 5-1z" fill="#F59E0B" />
                                    </svg></div>
                                <div class="s3-sp-3 absolute" style="bottom:50px;left:5px;"><svg width="8" height="8"
                                        viewBox="0 0 12 12">
                                        <path d="M6 0l1 5 5 1-5 1-1 5-1-5-5-1 5-1z" fill="#F59E0B" />
                                    </svg></div>
                                <div class="s3-sp-4 absolute" style="bottom:55px;right:10px;"><svg width="10"
                                        height="10" viewBox="0 0 12 12">
                                        <path d="M6 0l1 5 5 1-5 1-1 5-1-5-5-1 5-1z" fill="#F59E0B" />
                                    </svg></div>

                                <!-- Floating reward label -->
                                <div class="s3-reward absolute top-2 left-1/2 -translate-x-1/2 whitespace-nowrap">
                                    <span class="text-[11px] font-bold px-3 py-1 rounded-full border shadow-sm"
                                        style="background:#fff7ed;color:#d97706;border-color:#fde68a;">+10 Poin
                                        Reward</span>
                                </div>

                                <!-- Coins falling -->
                                <div class="s3-coin-1 absolute" style="top:30px;left:30px;">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-[11px] text-white border-2 border-white shadow-md"
                                        style="background: linear-gradient(135deg, #FCD34D, #F59E0B);">Rp</div>
                                </div>
                                <div class="s3-coin-2 absolute" style="top:20px;left:1/2;margin-left:-18px;">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-[11px] text-white border-2 border-white shadow-md"
                                        style="background: linear-gradient(135deg, #FCD34D, #F59E0B);">Rp</div>
                                </div>
                                <div class="s3-coin-3 absolute" style="top:30px;right:30px;">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-[11px] text-white border-2 border-white shadow-md"
                                        style="background: linear-gradient(135deg, #FCD34D, #F59E0B);">Rp</div>
                                </div>

                                <!-- Phone / Wallet -->
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2">
                                    <svg width="130" height="170" viewBox="0 0 130 170" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="3" width="124" height="164" rx="18" stroke="#006c49"
                                            stroke-width="2.5" fill="white" />
                                        <rect x="45" y="10" width="40" height="7" rx="3" fill="#e6eeff" />
                                        <text x="65" y="52" text-anchor="middle" font-family="Inter,sans-serif"
                                            font-size="9" fill="#6c7a71" font-weight="500">Saldo Koin</text>

                                        <!-- Dynamic Counter Fake with Alpine -->
                                        <text x="65" y="80" text-anchor="middle" font-family="Inter,sans-serif"
                                            font-size="28" font-weight="700" fill="#121c2a"
                                            x-text="animatingBalance ? '240' : '250'">1,250</text>

                                        <rect x="28" y="94" width="74" height="20" rx="10" fill="#006c49" />
                                        <text x="65" y="108" text-anchor="middle" font-family="Inter,sans-serif"
                                            font-size="9" font-weight="600" fill="white">+10 Koin</text>
                                        <rect x="20" y="122" width="90" height="1.5" rx="1" fill="#e6eeff" />
                                        <rect x="45" y="148" width="40" height="5" rx="2" fill="#d9e3f6" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Scene Dot Indicators -->
                        <div class="absolute bottom-5 flex gap-2 z-10">
                            <button @click="scene=1" :class="scene===1 ? 'bg-primary w-5' : 'bg-outline-variant w-2'"
                                class="h-2 rounded-full transition-all duration-300"></button>
                            <button @click="scene=2" :class="scene===2 ? 'bg-primary w-5' : 'bg-outline-variant w-2'"
                                class="h-2 rounded-full transition-all duration-300"></button>
                            <button @click="scene=3" :class="scene===3 ? 'w-5' : 'bg-outline-variant w-2'"
                                :style="scene===3 ? 'background:#F59E0B' : ''"
                                class="h-2 rounded-full transition-all duration-300"></button>
                        </div>

                    </div>

                    <!-- Steps Column -->
                    <div class="flex flex-col gap-8 text-left w-full lg:pl-10 relative">
                        <div class="absolute left-[1.4rem] top-12 bottom-8 w-[2px] bg-outline-variant/30 -z-0"></div>

                        <div class="flex items-start gap-6 relative group/step cursor-default">
                            <div
                                class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 shadow-sm text-lg relative z-10 transition-all bg-surface-container-highest text-on-surface border border-outline-variant">
                                1</div>
                            <div
                                class="relative z-10 bg-surface/50 p-4 rounded-xl border border-transparent transition-all">
                                <h4 class="text-on-surface font-bold text-xl mb-2">Daftar &amp; Atur Alamat</h4>
                                <p class="text-on-surface-variant text-base">Buat akun dengan mudah dan masukkan detail
                                    alamat rumah Anda di dalam komplek.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-6 relative group/step cursor-default">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 text-lg relative z-10 transition-all shadow-md border"
                                :class="scene === 1 ? 'bg-primary text-white ring-4 ring-primary/30 border-transparent scale-110' : 'bg-surface-container-highest text-on-surface border-outline-variant'">
                                2</div>
                            <div class="relative z-10 p-4 rounded-xl transition-all border"
                                :class="scene === 1 ? 'bg-surface shadow-md border-primary/20 scale-[1.02]' : 'bg-surface/50 border-transparent'">
                                <h4 class="text-on-surface font-bold text-xl mb-2"
                                    :class="scene === 1 ? 'text-primary' : ''">Pesan atau Lapor</h4>
                                <p class="text-on-surface-variant text-base">Pilih jadwal rutin penjemputan atau
                                    laporkan tumpukan sampah insidental melalui aplikasi.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-6 relative group/step cursor-default">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 text-lg relative z-10 transition-all shadow-md border"
                                :class="scene === 2 ? 'bg-primary text-white ring-4 ring-primary/30 border-transparent scale-110' : 'bg-surface-container-highest text-on-surface border-outline-variant'">
                                3</div>
                            <div class="relative z-10 p-4 rounded-xl transition-all border"
                                :class="scene === 2 ? 'bg-surface shadow-md border-primary/20 scale-[1.02]' : 'bg-surface/50 border-transparent'">
                                <h4 class="text-on-surface font-bold text-xl mb-2"
                                    :class="scene === 2 ? 'text-primary' : ''">Petugas Bergerak</h4>
                                <p class="text-on-surface-variant text-base">Tim kami yang profesional akan datang tepat
                                    waktu sesuai jadwal dan lokasi laporan.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-6 relative group/step cursor-default">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 text-lg relative z-10 transition-all shadow-md border"
                                :class="scene === 3 ? 'text-white border-transparent scale-110' : 'bg-surface-container-highest text-on-surface border-outline-variant'"
                                :style="scene === 3 ? 'background:#F59E0B; box-shadow: 0 0 20px rgba(245,158,11,0.5)' : ''">
                                4</div>
                            <div class="relative z-10 p-4 rounded-xl transition-all border"
                                :class="scene === 3 ? 'bg-surface shadow-md scale-[1.02]' : 'bg-surface/50 border-transparent'"
                                :style="scene === 3 ? 'border-color: rgba(245,158,11,0.3)' : ''">
                                <h4 class="text-on-surface font-bold text-xl mb-2"
                                    :style="scene === 3 ? 'color:#d97706' : ''">Terima Koin</h4>
                                <p class="text-on-surface-variant text-base">Sistem otomatis mencatat partisipasi Anda
                                    dan koin reward akan langsung masuk ke dompet digital Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- Pre-Footer CTA -->
        <section id="cta" class="py-50 px-10 bg-surface">
            <!-- Background Orbs -->

            <div class="max-w-[800px] mx-auto text-center relative z-10 flex flex-col items-center">
                <div
                    class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center mb-8 border border-primary/20">
                    <span class="material-symbols-outlined text-[40px] text-primary">compost</span>
                </div>
                <h2 class="text-on-surface text-[32px] md:text-[40px] font-bold leading-tight mb-6">
                    Siap Mewujudkan Komplek Perumahan yang Lebih Bersih?
                </h2>
                <p class="text-on-surface-variant text-lg mb-10 max-w-[600px] mx-auto">
                    Bergabunglah dengan ratusan komplek lainnya yang telah beralih ke pengelolaan sampah modern,
                    efisien, dan menguntungkan.
                </p>
                <a href="/register"
                    class="bg-primary hover:bg-primary-container text-on-primary text-base font-bold h-14 px-10 rounded-xl transition-all hover:scale-105 shadow-[0_10px_20px_-5px_rgba(0,108,73,0.3)] inline-flex items-center justify-center">
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
                    class="text-[14vw] md:text-[17vw] font-black leading-[0.8] tracking-[-0.004em] text-white/80 select-none pointer-events-none">
                    EcoTrash
                </span>
            </div>
        </div>
    </footer>
</body>

</html>