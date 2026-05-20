<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>@yield('title', 'EcoTrash')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')

    <style>
        /* Safe area for mobile devices */
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom);
        }

        .pt-safe {
            padding-top: env(safe-area-inset-top);
        }
    </style>
</head>

<body class="font-body-md antialiased bg-white md:bg-surface-dim min-h-screen text-on-surface" x-data="{
        showLogoutModal: false,
        toast: { show: false, message: '', type: 'success' },
        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => { this.toast.show = false; }, 3500);
        }
    }" @show-toast.window="showToast($event.detail.message, $event.detail.type || 'success')">
    <!-- Hybrid Container -->
    <div class="flex h-screen overflow-hidden relative">

        <!-- DESKTOP SIDEBAR -->
        <aside
            class="hidden md:flex flex-col w-72 bg-white border-r border-outline h-screen shrink-0 relative z-40 shadow-sm">
            <!-- Brand/Header -->
            <div class="h-20 flex items-center px-8 border-b border-outline shrink-0">
                <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center mr-3 shadow-sm">
                    <span class="material-symbols-outlined text-[24px]"
                        style="font-variation-settings: 'FILL' 1;">eco</span>
                </div>
                <span class="text-2xl font-black text-primary tracking-tight">EcoTrash</span>
            </div>

            <!-- Menu -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest px-4 mb-3">Menu Utama
                </p>
                <a href="{{ route('warga.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('warga.dashboard') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-on-surface-variant hover:bg-surface hover:text-on-surface' }}">
                    <span class="material-symbols-outlined text-[24px]" {!! request()->routeIs('warga.dashboard') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>home</span>
                    <span class="font-bold text-sm">Beranda</span>
                </a>

                <a href="{{ route('warga.aktivitas.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('warga.aktivitas.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-on-surface-variant hover:bg-surface hover:text-on-surface' }}">
                    <span class="material-symbols-outlined text-[24px]" {!! request()->routeIs('warga.aktivitas.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>list_alt</span>
                    <span class="font-bold text-sm">Aktivitas Saya</span>
                </a>

                <a href="{{ route('warga.edukasi.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('warga.edukasi.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-on-surface-variant hover:bg-surface hover:text-on-surface' }}">
                    <span class="material-symbols-outlined text-[24px]" {!! request()->routeIs('warga.edukasi.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>menu_book</span>
                    <span class="font-bold text-sm">Edukasi</span>
                </a>

                <div class="pt-4 mt-4 border-t border-outline"></div>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest px-4 mb-3">Pengaturan
                </p>

                <a href="{{ route('warga.profil.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('warga.profil.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-on-surface-variant hover:bg-surface hover:text-on-surface' }}">
                    <span class="material-symbols-outlined text-[24px]" {!! request()->routeIs('warga.profil.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>person</span>
                    <span class="font-bold text-sm">Profil Akun</span>
                </a>
            </nav>

            <!-- Bottom Profile / Logout -->
            <div class="p-4 border-t border-outline">
                <button @click="showLogoutModal = true"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors">
                    <span class="material-symbols-outlined text-[24px]">logout</span>
                    <span class="font-bold text-sm">Keluar</span>
                </button>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative bg-white md:bg-surface/50">

            <!-- Mobile Header (Only visible on Mobile) -->
            <header
                class="md:hidden sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b-2 border-outline px-4 pt-[calc(env(safe-area-inset-top,0px)+1.25rem)] pb-5 flex items-center justify-between shrink-0">
                @yield('header')
            </header>

            <!-- Desktop Header -->
            <header
                class="hidden md:flex h-20 bg-white border-b border-outline px-8 items-center justify-between shrink-0 shadow-sm sticky top-0 z-30">
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-bold text-on-surface">@yield('title')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative" x-data="{ showNotif: false }" @click.away="showNotif = false">
                        <button @click="showNotif = !showNotif"
                            class="relative p-2 text-on-surface-variant hover:bg-surface-variant rounded-full transition-colors">
                            <span class="material-symbols-outlined text-[24px]">notifications</span>
                            <span
                                class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="showNotif" x-transition
                            class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-outline overflow-hidden z-50"
                            style="display:none;">
                            <div class="p-4 border-b border-outline flex justify-between items-center bg-surface">
                                <h3 class="font-bold text-on-surface">Notifikasi</h3>
                                <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded-md">2
                                    Baru</span>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                <div
                                    class="p-4 border-b border-outline hover:bg-surface transition-colors cursor-pointer opacity-100">
                                    <p class="font-bold text-sm text-on-surface">Pesanan Selesai!</p>
                                    <p class="text-xs text-on-surface-variant mt-1 line-clamp-2">Pesanan #ORD-001 telah
                                        selesai. Koin sebesar 150 telah ditambahkan ke saldo Anda.</p>
                                    <p class="text-[10px] text-on-surface-variant mt-2 font-medium">Baru saja</p>
                                </div>
                                <div
                                    class="p-4 border-b border-outline hover:bg-surface transition-colors cursor-pointer opacity-100">
                                    <p class="font-bold text-sm text-on-surface">Laporan Diterima</p>
                                    <p class="text-xs text-on-surface-variant mt-1 line-clamp-2">Laporan sampah liar di
                                        Lahan Kosong Blok C sedang diproses oleh admin.</p>
                                    <p class="text-[10px] text-on-surface-variant mt-2 font-medium">2 jam yang lalu</p>
                                </div>
                                <div class="p-4 hover:bg-surface transition-colors cursor-pointer opacity-60">
                                    <p class="font-bold text-sm text-on-surface">Selamat Datang di EcoTrash</p>
                                    <p class="text-xs text-on-surface-variant mt-1 line-clamp-2">Lengkapi profil Anda
                                        dan mulai bantu ciptakan lingkungan yang lebih bersih.</p>
                                    <p class="text-[10px] text-on-surface-variant mt-2 font-medium">1 hari yang lalu</p>
                                </div>
                            </div>
                            <div class="p-3 border-t border-outline text-center bg-surface">
                                <a href="#" class="text-sm font-bold text-primary hover:underline">Tandai semua
                                    dibaca</a>
                            </div>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-outline mx-1"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-xs font-bold text-on-surface">Budi Santoso</p>
                            <p class="text-[10px] text-on-surface-variant">Warga</p>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                            B
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto scroll-smooth pb-24 md:pb-8 pt-2 md:pt-8 px-0 md:px-8">
                <div class="max-w-md mx-auto md:max-w-6xl w-full">
                    @yield('content')
                </div>
            </main>

            <!-- MOBILE BOTTOM NAVIGATION (Fixed) -->
            <nav
                class="md:hidden fixed bottom-0 w-full bg-white border-t-2 border-outline pb-safe z-[60] rounded-t-2xl">
                <div class="flex justify-around items-center h-16 px-2">
                    <a href="{{ route('warga.dashboard') }}"
                        class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('warga.dashboard') ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[26px]" {!! request()->routeIs('warga.dashboard') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>home</span>
                        <span class="text-[10px] font-bold">Beranda</span>
                    </a>
                    <a href="{{ route('warga.aktivitas.index') }}"
                        class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('warga.aktivitas.*') ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[26px]" {!! request()->routeIs('warga.aktivitas.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>list_alt</span>
                        <span class="text-[10px] font-bold">Aktivitas</span>
                    </a>
                    <a href="{{ route('warga.edukasi.index') }}"
                        class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('warga.edukasi.*') ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[26px]" {!! request()->routeIs('warga.edukasi.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>menu_book</span>
                        <span class="text-[10px] font-bold">Edukasi</span>
                    </a>
                    <a href="{{ route('warga.profil.index') }}"
                        class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('warga.profil.*') ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[26px]" {!! request()->routeIs('warga.profil.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>person</span>
                        <span class="text-[10px] font-bold">Profil</span>
                    </a>
                </div>
            </nav>

            <!-- Global Toast Notification -->
            <div
                class="fixed top-4 left-1/2 -translate-x-1/2 md:top-6 md:left-auto md:right-8 md:translate-x-0 z-[100] w-[90%] max-w-sm pointer-events-none pt-safe md:pt-0">
                <div x-show="toast.show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4 md:translate-x-4 md:-translate-y-0 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 md:translate-x-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 -translate-y-4 md:translate-x-4 md:-translate-y-0 scale-95"
                    :class="{
                        'bg-primary border-primary/20 text-white shadow-primary/20': toast.type === 'success',
                        'bg-red-600 border-red-500/20 text-white shadow-red-500/20': toast.type === 'error',
                        'bg-yellow-500 border-yellow-400/20 text-white shadow-yellow-500/20': toast.type === 'warning'
                    }" class="pointer-events-auto flex items-center gap-3 px-4 py-3.5 rounded-2xl shadow-xl border"
                    style="display: none;">
                    <span class="material-symbols-outlined text-[20px] shrink-0"
                        x-text="toast.type === 'success' ? 'check_circle' : toast.type === 'error' ? 'cancel' : 'info'">
                    </span>
                    <p class="text-sm font-bold flex-1" x-text="toast.message"></p>
                </div>
            </div>

            <!-- Logout Confirmation Modal -->
            <div x-show="showLogoutModal" x-transition.opacity
                class="fixed inset-0 bg-black/50 z-[200] backdrop-blur-sm flex items-center justify-center p-4"
                style="display:none;" @click.self="showLogoutModal = false">
                <div x-show="showLogoutModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden text-center p-6 md:p-8">
                    <div
                        class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[40px]">logout</span>
                    </div>
                    <h3 class="font-black text-xl text-on-surface mb-2">Keluar Akun?</h3>
                    <p class="text-sm text-on-surface-variant mb-8">Anda harus masuk kembali untuk memesan layanan atau
                        melapor.</p>
                    <div class="flex gap-3">
                        <button @click="showLogoutModal = false"
                            class="flex-1 font-bold text-on-surface-variant py-3 rounded-xl bg-surface border border-outline hover:bg-surface-variant transition-colors">Batal</button>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full h-full font-bold text-white py-3 rounded-xl bg-red-600 hover:bg-red-700 shadow-lg shadow-red-600/30 transition-colors flex items-center justify-center">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>

        </div> <!-- End Main Content Wrapper -->
    </div> <!-- End Hybrid Container -->

    @stack('scripts')
</body>

</html>