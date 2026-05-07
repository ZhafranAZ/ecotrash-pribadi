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
    <header class="sticky top-0 z-50 bg-surface/80 backdrop-blur-md border-b border-outline-variant transition-all" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-[1280px] mx-auto px-6 md:px-10 flex items-center justify-between h-[72px]">
            <div class="flex items-center gap-3 text-primary">
                <span class="material-symbols-outlined text-[28px]"
                    style="font-variation-settings: 'FILL' 1;">eco</span>
                <h2 class="text-on-surface font-title-sm font-bold tracking-tight">EcoTrash</h2>
            </div>
            
            <!-- Desktop Nav -->
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
            <div class="hidden md:flex items-center gap-4">
                <a href="/login"
                    class="text-primary hover:text-primary-dark text-sm font-bold transition-all hover:-translate-y-0.5 active:scale-95">Masuk</a>
                <a href="/register"
                    class="bg-primary hover:bg-primary-dark text-white text-sm font-bold h-10 px-6 rounded-lg transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/20 active:scale-95 flex items-center justify-center">
                    Daftar Akun
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-on-surface hover:bg-surface-variant rounded-lg transition-colors">
                <span class="material-symbols-outlined text-[28px]" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
            </button>
        </div>

        <!-- Mobile Dropdown -->
        <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden absolute top-[72px] left-0 w-full bg-white border-b border-outline-variant shadow-lg py-4 px-6 flex flex-col gap-4">
            <a @click="mobileMenuOpen = false" class="text-on-surface hover:text-primary font-medium transition-colors py-2" href="#">Beranda</a>
            <a @click="mobileMenuOpen = false" class="text-on-surface hover:text-primary font-medium transition-colors py-2" href="#fitur">Fitur</a>
            <a @click="mobileMenuOpen = false" class="text-on-surface hover:text-primary font-medium transition-colors py-2" href="#cara-kerja">Cara Kerja</a>
            <a @click="mobileMenuOpen = false" class="text-on-surface hover:text-primary font-medium transition-colors py-2" href="#kontak">Kontak</a>
            <hr class="border-outline-variant/50">
            <div class="flex flex-col gap-3 pt-2">
                <a href="/login" class="text-primary font-bold text-center border border-primary rounded-lg py-3">Masuk</a>
                <a href="/register" class="bg-primary text-white font-bold text-center rounded-lg py-3 shadow-md">Daftar Akun</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative pt-6 pb-20 md:pt-12 md:pb-24 px-6 md:px-10 overflow-hidden">
            <div class="max-w-[1280px] mx-auto">
                <div class="rounded-[24px] overflow-hidden relative min-h-[480px] md:min-h-[560px] flex items-center"
                    style="background-image: linear-gradient(to right, rgba(18, 28, 42, 0.9) 0%, rgba(18, 28, 42, 0.4) 100%), url('http://127.0.0.1:8000/images/Landingpage_Title.png'); background-size: cover; background-position: center;">
                    <div class="relative z-10 max-w-[640px] px-6 md:px-16 py-10 md:py-12 flex flex-col gap-6">
                        <span
                            class="inline-flex items-center self-start gap-1.5 px-3 py-1 rounded-full bg-primary/20 text-white text-xs font-bold uppercase tracking-wider backdrop-blur-sm border border-primary/30">
                            <span class="material-symbols-outlined text-[14px]">stars</span> Premium Service
                        </span>
                        <h1
                            class="text-white text-[32px] md:text-display-lg font-bold leading-tight tracking-[-0.02em]">
                            Kelola Sampah Komplek Lebih Mudah, Bersih, dan Menguntungkan
                        </h1>
                        <p class="text-white text-base md:text-[18px] leading-relaxed max-w-[540px]">
                            Jadwalkan penjemputan sampah, laporkan masalah kebersihan dengan cepat, dan dapatkan koin
                            reward untuk setiap aksi baik Anda demi lingkungan.
                        </p>
                        <div class="pt-4 flex flex-col sm:flex-row gap-4">
                            <a href="#cta"
                                class="bg-primary hover:bg-primary-dark text-white text-base font-bold h-12 px-8 rounded-lg transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/30 active:scale-95 flex items-center justify-center gap-2 shadow-lg shadow-primary/20 text-center">
                                Mulai Bersihkan Lingkungan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 md:py-20 px-6 md:px-10 bg-surface" id="fitur">
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
        <section class="py-16 md:py-24 px-6 md:px-10 bg-surface-container-low overflow-hidden" id="cara-kerja">
            <div class="max-w-[1280px] mx-auto flex flex-col gap-12 md:gap-16 items-center">
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
                    x-init="setInterval(() => { scene = scene >= 4 ? 1 : scene + 1; if(scene===4){ animatingBalance=true; setTimeout(()=>animatingBalance=false, 2000); } }, 4500)">

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

                            /* ---- Scene 1: Daftar & Atur Alamat ---- */
                            @keyframes s1CardPop {
                                0% {
                                    opacity: 0;
                                    transform: translateY(20px) scale(0.9);
                                }

                                15%,
                                85% {
                                    opacity: 1;
                                    transform: translateY(0) scale(1);
                                }

                                100% {
                                    opacity: 0;
                                    transform: translateY(-20px) scale(0.9);
                                }
                            }

                            @keyframes s1PinDrop {

                                0%,
                                25% {
                                    opacity: 0;
                                    transform: translateY(-40px) scale(1.5);
                                }

                                35% {
                                    opacity: 1;
                                    transform: translateY(0) scale(1);
                                }

                                40% {
                                    transform: translateY(-10px);
                                }

                                45%,
                                85% {
                                    transform: translateY(0);
                                    opacity: 1;
                                }

                                100% {
                                    opacity: 0;
                                    transform: translateY(-20px);
                                }
                            }

                            @keyframes s1MapExpand {

                                0%,
                                15% {
                                    opacity: 0;
                                    transform: scaleX(0);
                                }

                                25%,
                                85% {
                                    opacity: 1;
                                    transform: scaleX(1);
                                }

                                100% {
                                    opacity: 0;
                                    transform: scaleX(0);
                                }
                            }

                            @keyframes s1CheckPop {

                                0%,
                                45% {
                                    opacity: 0;
                                    transform: scale(0);
                                }

                                50%,
                                85% {
                                    opacity: 1;
                                    transform: scale(1);
                                }

                                100% {
                                    opacity: 0;
                                    transform: scale(0);
                                }
                            }

                            .s1-card {
                                animation: s1CardPop 4.5s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            .s1-map {
                                animation: s1MapExpand 4.5s infinite cubic-bezier(0.22, 1, 0.36, 1);
                                transform-origin: center;
                            }

                            .s1-pin {
                                animation: s1PinDrop 4.5s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            .s1-check {
                                animation: s1CheckPop 4.5s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            /* ---- Scene 2: Cursor & Success ---- */
                            @keyframes s2CursorMove {
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

                            @keyframes s2Ripple {

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

                            @keyframes s2SuccessBtn {

                                0%,
                                60% {
                                    fill: #10b981;
                                    width: 104px;
                                    x: 18px;
                                }

                                65%,
                                95% {
                                    fill: #059669;
                                    width: 40px;
                                    x: 50px;
                                }

                                100% {
                                    fill: #10b981;
                                    width: 104px;
                                    x: 18px;
                                }
                            }

                            @keyframes s2SuccessText {

                                0%,
                                55% {
                                    opacity: 1;
                                }

                                60%,
                                100% {
                                    opacity: 0;
                                }
                            }

                            @keyframes s2Checkmark {

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

                            .s2-cursor {
                                animation: s2CursorMove 4.5s infinite cubic-bezier(0.22, 1, 0.36, 1);
                                transform-origin: top left;
                            }

                            .s2-ripple-1 {
                                animation: s2Ripple 4.5s 0s infinite ease-out;
                            }

                            .s2-ripple-2 {
                                animation: s2Ripple 4.5s 0.15s infinite ease-out;
                            }

                            .s2-ripple-3 {
                                animation: s2Ripple 4.5s 0.3s infinite ease-out;
                            }

                            .s2-btn {
                                animation: s2SuccessBtn 4.5s infinite cubic-bezier(0.22, 1, 0.36, 1);
                            }

                            .s2-text {
                                animation: s2SuccessText 4.5s infinite;
                            }

                            .s2-check {
                                animation: s2Checkmark 4.5s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                                transform-origin: 70px 148px;
                            }

                            /* ---- Scene 3: Truck Parallax ---- */
                            @keyframes s3Truck {
                                0% {
                                    transform: translateX(-130%);
                                }

                                30%,
                                70% {
                                    transform: translateX(0);
                                }

                                100% {
                                    transform: translateX(130%);
                                }
                            }

                            @keyframes s3Wheel {
                                0% {
                                    transform: rotate(0deg);
                                }

                                30%,
                                70% {
                                    transform: rotate(360deg);
                                }

                                100% {
                                    transform: rotate(720deg);
                                }
                            }

                            @keyframes s3Pin {

                                0%,
                                100% {
                                    transform: translateY(0);
                                }

                                50% {
                                    transform: translateY(-7px);
                                }
                            }

                            @keyframes s3RoadMove {
                                0% {
                                    background-position: 0 0;
                                }

                                30%,
                                70% {
                                    background-position: -80px 0;
                                }

                                100% {
                                    background-position: -160px 0;
                                }
                            }

                            @keyframes s3TrashVanish {

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

                            .s3-truck {
                                animation: s3Truck 4.5s cubic-bezier(0.22, 1, 0.36, 1) infinite;
                            }

                            .s3-wheel {
                                animation: s3Wheel 4.5s cubic-bezier(0.22, 1, 0.36, 1) infinite;
                                transform-origin: center;
                            }

                            .s3-pin {
                                animation: s3Pin 1s ease-in-out infinite;
                            }

                            .s3-road {
                                background-image: linear-gradient(90deg, transparent 50%, rgba(16, 185, 129, 0.2) 50%);
                                background-size: 40px 2px;
                                animation: s3RoadMove 4.5s cubic-bezier(0.22, 1, 0.36, 1) infinite;
                            }

                            .s3-trash {
                                animation: s3TrashVanish 4.5s infinite;
                                transform-origin: center bottom;
                            }

                            /* ---- Scene 4: Terima Koin ---- */
                            @keyframes s4CoinFall {
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

                            @keyframes s4Reward {

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

                            @keyframes s4Sparkle {

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

                            .s4-coin-1 {
                                animation: s4CoinFall 4.5s 0.2s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            .s4-coin-2 {
                                animation: s4CoinFall 4.5s 0.5s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            .s4-coin-3 {
                                animation: s4CoinFall 4.5s 0.8s infinite cubic-bezier(0.34, 1.56, 0.64, 1);
                            }

                            .s4-reward {
                                animation: s4Reward 4.5s infinite ease-in-out;
                            }

                            .s4-sp-1 {
                                animation: s4Sparkle 4.5s 0.3s infinite;
                            }

                            .s4-sp-2 {
                                animation: s4Sparkle 4.5s 0.7s infinite;
                            }

                            .s4-sp-3 {
                                animation: s4Sparkle 4.5s 1.0s infinite;
                            }

                            .s4-sp-4 {
                                animation: s4Sparkle 4.5s 0.5s infinite;
                            }
                        </style>

                        <!-- ===== SCENE 1: Daftar & Atur Alamat ===== -->
                        <div x-show="scene === 1" x-transition:enter="scene-enter" x-transition:leave="scene-leave"
                            class="absolute inset-0 flex flex-col items-center justify-center p-8">

                            <div class="relative w-[180px] h-[220px] flex flex-col items-center justify-center">
                                <!-- Minimal Map Base -->
                                <div class="s1-map absolute bottom-10 w-full h-[60px] bg-outline-variant/10 border border-outline-variant/30 rounded-xl shadow-sm"
                                    style="transform: perspective(400px) rotateX(60deg);">
                                    <div class="absolute inset-0 flex items-center justify-center gap-4 opacity-50">
                                        <div class="w-1 h-full bg-outline-variant/20"></div>
                                        <div class="w-full h-1 bg-outline-variant/20 absolute"></div>
                                    </div>
                                </div>

                                <!-- Profile Card -->
                                <div
                                    class="s1-card absolute top-4 w-[120px] bg-white rounded-2xl shadow-md border border-outline-variant/50 p-3 flex flex-col items-center">
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center mb-2">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#006c49"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                    <div class="w-16 h-2 bg-outline-variant/30 rounded-full mb-1.5"></div>
                                    <div class="w-10 h-1.5 bg-outline-variant/20 rounded-full"></div>
                                </div>

                                <!-- Map Pin -->
                                <div class="s1-pin absolute bottom-12 flex flex-col items-center">
                                    <svg width="28" height="36" viewBox="0 0 24 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 0C5.372 0 0 5.373 0 12c0 9 12 20 12 20s12-11 12-20c0-6.627-5.372-12-12-12z"
                                            fill="#006c49" />
                                        <circle cx="12" cy="12" r="5" fill="white" />
                                    </svg>
                                    <div class="w-4 h-1 bg-black/20 blur-[2px] rounded-full mt-1"></div>
                                </div>

                                <!-- Success Check -->
                                <div
                                    class="s1-check absolute right-10 bottom-24 bg-[#10b981] w-6 h-6 rounded-full flex items-center justify-center shadow-md">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white"
                                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- ===== SCENE 2: Pesan & Lapor ===== -->
                        <div x-show="scene === 2" x-transition:enter="scene-enter" x-transition:leave="scene-leave"
                            class="absolute inset-0 flex flex-col items-center justify-center p-8">

                            <!-- Refined Phone SVG -->
                            <div class="relative flex items-center justify-center" style="transform:rotate(-8deg);">
                                <!-- Soft shadow behind phone -->
                                <div class="absolute inset-0 bg-black/5 blur-xl rounded-[20px] translate-y-4"></div>
                                <svg width="140" height="230" viewBox="0 0 140 230" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="relative z-10 drop-shadow-sm">
                                    <rect x="2" y="2" width="136" height="226" rx="20" stroke="#10b981"
                                        stroke-width="1.5" fill="white" />
                                    <!-- Speaker -->
                                    <rect x="50" y="12" width="40" height="6" rx="3" fill="#ecfdf5" />
                                    <!-- Header -->
                                    <rect x="14" y="30" width="112" height="22" rx="6" fill="#ecfdf5" />
                                    <text x="70" y="45" text-anchor="middle" font-family="Inter,sans-serif"
                                        font-size="9" font-weight="700" fill="#10b981">EcoTrash</text>
                                    <!-- Content Lines -->
                                    <rect x="20" y="64" width="70" height="6" rx="3" fill="#d1fae5" />
                                    <rect x="20" y="78" width="50" height="6" rx="3" fill="#ecfdf5" />

                                    <g>
                                        <!-- Ripple rings -->
                                        <circle cx="70" cy="148" r="20" stroke="#10b981" stroke-width="1.5"
                                            class="s2-ripple-1" fill="none" opacity="0" />
                                        <circle cx="70" cy="148" r="20" stroke="#10b981" stroke-width="1"
                                            class="s2-ripple-2" fill="none" opacity="0" />
                                        <circle cx="70" cy="148" r="20" stroke="#059669" stroke-width="0.8"
                                            class="s2-ripple-3" fill="none" opacity="0" />
                                        <!-- Button -->
                                        <rect class="s2-btn" x="18" y="134" width="104" height="28" rx="14"
                                            fill="#10b981" />
                                        <text class="s2-text" x="70" y="152" text-anchor="middle"
                                            font-family="Inter,sans-serif" font-size="9" font-weight="600"
                                            fill="white">Pesan Sekarang</text>
                                        <!-- Checkmark -->
                                        <path class="s2-check" d="M63 148 L68 153 L77 143" stroke="white"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                            fill="none" opacity="0" />
                                    </g>
                                    <!-- Home indicator -->
                                    <rect x="55" y="214" width="30" height="3" rx="1.5" fill="#a7f3d0" />
                                </svg>

                                <!-- Custom Hand Asset Cursor -->
                                <div class="absolute s2-cursor" style="bottom: 10px; left: 85px; z-index: 20;">
                                    <img src="{{ asset('assets/hand.svg') }}" class="w-16 h-auto drop-shadow-md"
                                        alt="cursor">
                                </div>
                            </div>
                        </div>

                        <!-- ===== SCENE 3: Petugas Bergerak ===== -->
                        <div x-show="scene === 3" x-transition:enter="scene-enter" x-transition:leave="scene-leave"
                            class="absolute inset-0 flex flex-col items-center justify-center px-8">

                            <div class="relative w-full flex flex-col items-center justify-end" style="height:220px;">

                                <!-- Parallax Road -->
                                <div class="absolute bottom-[42px] left-0 right-0 h-[2px] bg-[#10b981]/20"></div>
                                <div class="s3-road absolute bottom-[42px] left-0 right-0 h-[2px]"></div>

                                <!-- Modern Minimalist House -->
                                <div class="absolute center-x bottom-12 flex gap-2 items-end z-10 drop-shadow-sm">
                                    <!-- Trash Bin -->
                                    <div class="s3-trash relative mb-0.5">
                                        <svg width="21" height="28" viewBox="0 0 12 16" fill="none" stroke="#10b981"
                                            stroke-width="1.2" stroke-linejoin="round">
                                            <path d="M2 3h8v12H2zM1 3h10M4 1v2M8 1v2" />
                                        </svg>
                                    </div>
                                    <!-- Custom House Asset -->
                                    <img src="{{ asset('assets/House.svg') }}" class="w-[200px] h-auto pb-1"
                                        alt="House">
                                </div>

                                <!-- Compactor Truck -->
                                <div class="s3-truck absolute bottom-[38px] z-20 drop-shadow-sm" style="width:180px;">
                                    <!-- Location pin -->
                                    <div class="s3-pin absolute -top-12 left-1/2 -translate-x-1/2">
                                        <svg width="20" height="26" viewBox="0 0 20 26" fill="none">
                                            <circle cx="10" cy="10" r="9" fill="#10b981" stroke="white"
                                                stroke-width="2" />
                                            <circle cx="10" cy="10" r="4" fill="white" />
                                            <path d="M10 19 L10 26" stroke="#10b981" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <!-- Modern Truck SVG -->
                                    <svg width="180" height="90" viewBox="0 0 180 90" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <!-- Compactor Body -->
                                        <path d="M10 20 L95 20 L95 70 L10 70 Z" fill="#ecfdf5" stroke="#10b981"
                                            stroke-width="1.5" stroke-linejoin="round" />
                                        <path d="M20 20 L30 70 M40 20 L50 70 M60 20 L70 70 M80 20 L90 70"
                                            stroke="#10b981" stroke-width="1" stroke-opacity="0.2" />
                                        <!-- Cab -->
                                        <path d="M95 35 Q110 35 125 40 L135 70 L95 70 Z" fill="#ecfdf5" stroke="#10b981"
                                            stroke-width="1.5" stroke-linejoin="round" />
                                        <!-- Windshield -->
                                        <path d="M100 40 Q110 40 120 44 L125 55 L100 55 Z" fill="#d1fae5"
                                            stroke="#10b981" stroke-width="1.5" stroke-linejoin="round" />
                                        <!-- Details -->
                                        <rect x="85" y="25" width="5" height="45" fill="#10b981" />
                                        <rect x="138" y="60" width="10" height="6" rx="2" fill="none" stroke="#10b981"
                                            stroke-width="1.5" />
                                        <!-- Wheels -->
                                        <g style="transform-origin:35px 70px;" class="s3-wheel">
                                            <circle cx="35" cy="70" r="14" stroke="#10b981" stroke-width="2"
                                                fill="white" />
                                            <circle cx="35" cy="70" r="5" stroke="#10b981" stroke-width="1.5"
                                                fill="none" />
                                            <circle cx="35" cy="70" r="2" fill="#10b981" />
                                        </g>
                                        <g style="transform-origin:70px 70px;" class="s3-wheel">
                                            <circle cx="70" cy="70" r="14" stroke="#10b981" stroke-width="2"
                                                fill="white" />
                                            <circle cx="70" cy="70" r="5" stroke="#10b981" stroke-width="1.5"
                                                fill="none" />
                                            <circle cx="70" cy="70" r="2" fill="#10b981" />
                                        </g>
                                        <g style="transform-origin:115px 70px;" class="s3-wheel">
                                            <circle cx="115" cy="70" r="14" stroke="#10b981" stroke-width="2"
                                                fill="white" />
                                            <circle cx="115" cy="70" r="5" stroke="#10b981" stroke-width="1.5"
                                                fill="none" />
                                            <circle cx="115" cy="70" r="2" fill="#10b981" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- ===== SCENE 4: Terima Koin ===== -->
                        <div x-show="scene === 4" x-transition:enter="scene-enter" x-transition:leave="scene-leave"
                            class="absolute inset-0 flex flex-col items-center justify-center p-8">

                            <div class="relative flex items-center justify-center" style="height:260px;width:200px;">
                                <!-- Sparkles -->
                                <div class="s4-sp-1 absolute" style="top:20px;left:10px;"><svg width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <path d="M6 0l1 5 5 1-5 1-1 5-1-5-5-1 5-1z" fill="#F59E0B" />
                                    </svg></div>
                                <div class="s4-sp-2 absolute" style="top:15px;right:15px;"><svg width="10" height="10"
                                        viewBox="0 0 12 12">
                                        <path d="M6 0l1 5 5 1-5 1-1 5-1-5-5-1 5-1z" fill="#F59E0B" />
                                    </svg></div>
                                <div class="s4-sp-3 absolute" style="bottom:50px;left:5px;"><svg width="8" height="8"
                                        viewBox="0 0 12 12">
                                        <path d="M6 0l1 5 5 1-5 1-1 5-1-5-5-1 5-1z" fill="#F59E0B" />
                                    </svg></div>
                                <div class="s4-sp-4 absolute" style="bottom:55px;right:10px;"><svg width="10"
                                        height="10" viewBox="0 0 12 12">
                                        <path d="M6 0l1 5 5 1-5 1-1 5-1-5-5-1 5-1z" fill="#F59E0B" />
                                    </svg></div>

                                <!-- Floating reward label -->
                                <div class="s4-reward absolute top-2 left-1/2 -translate-x-1/2 whitespace-nowrap z-30">
                                    <span class="text-[11px] font-bold px-3 py-1 rounded-full border shadow-sm"
                                        style="background:#fff7ed;color:#d97706;border-color:#fde68a;">+10 Poin
                                        Reward</span>
                                </div>

                                <!-- Coins falling -->
                                <div class="s4-coin-1 absolute z-20" style="top:30px;left:30px;">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-[11px] text-white border-2 border-white shadow-md drop-shadow-sm"
                                        style="background: linear-gradient(135deg, #FCD34D, #F59E0B);">Rp</div>
                                </div>
                                <div class="s4-coin-2 absolute z-20" style="top:20px;left:1/2;margin-left:-18px;">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-[11px] text-white border-2 border-white shadow-md drop-shadow-sm"
                                        style="background: linear-gradient(135deg, #FCD34D, #F59E0B);">Rp</div>
                                </div>
                                <div class="s4-coin-3 absolute z-20" style="top:30px;right:30px;">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-[11px] text-white border-2 border-white shadow-md drop-shadow-sm"
                                        style="background: linear-gradient(135deg, #FCD34D, #F59E0B);">Rp</div>
                                </div>

                                <!-- Refined Wallet Phone -->
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2">
                                    <!-- Soft shadow behind phone -->
                                    <div class="absolute inset-0 bg-black/5 blur-xl rounded-[20px] translate-y-4"></div>
                                    <svg width="130" height="170" viewBox="0 0 130 170" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="relative z-10 drop-shadow-sm">
                                        <rect x="2" y="2" width="126" height="166" rx="18" stroke="#10b981"
                                            stroke-width="1.5" fill="white" />
                                        <rect x="45" y="10" width="40" height="6" rx="3" fill="#ecfdf5" />
                                        <text x="65" y="52" text-anchor="middle" font-family="Inter,sans-serif"
                                            font-size="9" fill="#10b981" font-weight="600">Saldo Koin</text>

                                        <!-- Dynamic Counter Fake with Alpine -->
                                        <text x="65" y="80" text-anchor="middle" font-family="Inter,sans-serif"
                                            font-size="28" font-weight="700" fill="#064e3b"
                                            x-text="animatingBalance ? '240' : '250'">1,240</text>

                                        <rect x="28" y="94" width="74" height="22" rx="11" fill="#ecfdf5"
                                            stroke="#10b981" stroke-width="1" />
                                        <text x="65" y="108" text-anchor="middle" font-family="Inter,sans-serif"
                                            font-size="9" font-weight="600" fill="#10b981">+10 Koin</text>
                                        <rect x="20" y="128" width="90" height="1.5" rx="1" fill="#d1fae5" />
                                        <rect x="45" y="152" width="40" height="4" rx="2" fill="#a7f3d0" />
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
                            <button @click="scene=3" :class="scene===3 ? 'bg-primary w-5' : 'bg-outline-variant w-2'"
                                class="h-2 rounded-full transition-all duration-300"></button>
                            <button @click="scene=4" :class="scene===4 ? 'w-5' : 'bg-outline-variant w-2'"
                                :style="scene===4 ? 'background:#F59E0B' : ''"
                                class="h-2 rounded-full transition-all duration-300"></button>
                        </div>

                    </div>
                    <!-- Steps Column -->
                    <div class="flex flex-col gap-8 text-left w-full lg:pl-10 relative">
                        <div class="absolute left-[1.4rem] top-12 bottom-8 w-[2px] bg-outline-variant/30 -z-0"></div>

                        <div class="flex items-start gap-6 relative group/step cursor-default">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 shadow-sm text-lg relative z-10 transition-all border"
                                :class="scene === 1 ? 'bg-primary text-white ring-4 ring-primary/30 border-transparent scale-110' : 'bg-surface-container-highest text-on-surface border-outline-variant'">
                                1</div>
                            <div class="relative z-10 p-4 rounded-xl transition-all border"
                                :class="scene === 1 ? 'bg-surface shadow-md border-primary/20 scale-[1.02]' : 'bg-surface/50 border-transparent'">
                                <h4 class="text-on-surface font-bold text-xl mb-2"
                                    :class="scene === 1 ? 'text-primary' : ''">Daftar &amp; Atur Alamat</h4>
                                <p class="text-on-surface-variant text-base">Buat akun dengan mudah dan masukkan detail
                                    alamat rumah Anda di dalam komplek.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-6 relative group/step cursor-default">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 text-lg relative z-10 transition-all shadow-md border"
                                :class="scene === 2 ? 'bg-primary text-white ring-4 ring-primary/30 border-transparent scale-110' : 'bg-surface-container-highest text-on-surface border-outline-variant'">
                                2</div>
                            <div class="relative z-10 p-4 rounded-xl transition-all border"
                                :class="scene === 2 ? 'bg-surface shadow-md border-primary/20 scale-[1.02]' : 'bg-surface/50 border-transparent'">
                                <h4 class="text-on-surface font-bold text-xl mb-2"
                                    :class="scene === 2 ? 'text-primary' : ''">Pesan atau Lapor</h4>
                                <p class="text-on-surface-variant text-base">Pilih jadwal rutin penjemputan atau
                                    laporkan tumpukan sampah insidental melalui aplikasi.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-6 relative group/step cursor-default">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 text-lg relative z-10 transition-all shadow-md border"
                                :class="scene === 3 ? 'bg-primary text-white ring-4 ring-primary/30 border-transparent scale-110' : 'bg-surface-container-highest text-on-surface border-outline-variant'">
                                3</div>
                            <div class="relative z-10 p-4 rounded-xl transition-all border"
                                :class="scene === 3 ? 'bg-surface shadow-md border-primary/20 scale-[1.02]' : 'bg-surface/50 border-transparent'">
                                <h4 class="text-on-surface font-bold text-xl mb-2"
                                    :class="scene === 3 ? 'text-primary' : ''">Petugas Bergerak</h4>
                                <p class="text-on-surface-variant text-base">Tim kami yang profesional akan datang tepat
                                    waktu sesuai jadwal dan lokasi laporan.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-6 relative group/step cursor-default">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 text-lg relative z-10 transition-all shadow-md border"
                                :class="scene === 4 ? 'text-white border-transparent scale-110' : 'bg-surface-container-highest text-on-surface border-outline-variant'"
                                :style="scene === 4 ? 'background:#F59E0B; box-shadow: 0 0 20px rgba(245,158,11,0.5)' : ''">
                                4</div>
                            <div class="relative z-10 p-4 rounded-xl transition-all border"
                                :class="scene === 4 ? 'bg-surface shadow-md scale-[1.02]' : 'bg-surface/50 border-transparent'"
                                :style="scene === 4 ? 'border-color: rgba(245,158,11,0.3)' : ''">
                                <h4 class="text-on-surface font-bold text-xl mb-2"
                                    :style="scene === 4 ? 'color:#d97706' : ''">Terima Koin</h4>
                                <p class="text-on-surface-variant text-base">Sistem otomatis mencatat partisipasi Anda
                                    dan koin reward akan langsung masuk ke dompet digital Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- Pre-Footer CTA -->
        <section id="cta" class="py-20 md:py-32 px-6 md:px-10 bg-surface relative">
            <!-- Background Glow Left -->
            <div class="absolute top-1/2 left-0 transform -translate-y-1/2 w-[150px] h-[300px] bg-primary/20 blur-[80px] pointer-events-none rounded-r-full"></div>
            <!-- Background Glow Right -->
            <div class="absolute top-1/2 right-0 transform -translate-y-1/2 w-[150px] h-[300px] bg-primary/20 blur-[80px] pointer-events-none rounded-l-full"></div>

            <div class="max-w-[800px] mx-auto text-center relative z-10 flex flex-col items-center">
                <div
                    class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-primary/10 flex items-center justify-center mb-6 md:mb-8 border border-primary/20">
                    <span class="material-symbols-outlined text-[32px] md:text-[40px] text-primary"
                        style="font-variation-settings: 'FILL' 1;">eco</span>
                </div>
                <h2 class="text-on-surface text-[28px] md:text-[40px] font-bold leading-tight mb-4 md:mb-6">
                    Siap Mewujudkan Komplek Perumahan yang Lebih Bersih?
                </h2>
                <p class="text-on-surface-variant text-base md:text-lg mb-8 md:mb-10 max-w-[600px] mx-auto">
                    Bergabunglah dengan ratusan komplek lainnya yang telah beralih ke pengelolaan sampah modern,
                    efisien, dan menguntungkan.
                </p>
                <a href="/register"
                    class="bg-primary hover:bg-primary-container text-white text-sm md:text-base font-bold h-12 md:h-14 px-8 md:px-10 rounded-xl transition-all hover:scale-105 shadow-[0_10px_20px_-5px_rgba(0,108,73,0.3)] inline-flex items-center justify-center text-center">
                    Daftar Akun Warga Sekarang
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="kontak"
        class="bg-gradient-to-b from-primary-darker to-primary text-white/90 pt-16 pb-8 px-6 md:px-10 relative overflow-hidden">
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