<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - EcoTrash</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js for UI interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-surface-dim text-on-surface font-body-md antialiased min-h-screen flex"
    x-data="{
        sidebarOpen: false,
        notifOpen: false,
        toast: { show: false, message: '', type: 'success' },
        showAlert: true,
        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => { this.toast.show = false; }, 3500);
        }
    }"
    @show-toast.window="showToast($event.detail.message, $event.detail.type || 'success')"
>
    
    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="sidebarOpen" class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity" @click="sidebarOpen = false" x-transition.opacity></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-outline z-50 transition-transform duration-300 lg:translate-x-0 shadow-sm flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-outline sticky top-0 bg-white z-10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-primary hover:text-primary-dark transition-colors">
                <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                <span class="font-title-md font-bold tracking-tight">EcoTrash Admin</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 flex flex-col gap-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary font-semibold' : 'text-on-surface-variant hover:bg-surface-variant hover:text-on-surface transition-colors' }}">
                <span class="material-symbols-outlined text-[20px]">monitoring</span>
                Dasbor
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.laporan.*') ? 'bg-primary/10 text-primary font-semibold' : 'text-on-surface-variant hover:bg-surface-variant hover:text-on-surface transition-colors' }}">
                <span class="material-symbols-outlined text-[20px]">report</span>
                Laporan Sampah
            </a>
            <a href="{{ route('admin.operasional.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.operasional.*') ? 'bg-primary/10 text-primary font-semibold' : 'text-on-surface-variant hover:bg-surface-variant hover:text-on-surface transition-colors' }}">
                <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                Operasional
            </a>
            <a href="{{ route('admin.pengguna.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.pengguna.*') ? 'bg-primary/10 text-primary font-semibold' : 'text-on-surface-variant hover:bg-surface-variant hover:text-on-surface transition-colors' }}">
                <span class="material-symbols-outlined text-[20px]">group</span>
                Manajemen Pengguna
            </a>
            <a href="{{ route('admin.edukasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.edukasi.*') ? 'bg-primary/10 text-primary font-semibold' : 'text-on-surface-variant hover:bg-surface-variant hover:text-on-surface transition-colors' }}">
                <span class="material-symbols-outlined text-[20px]">menu_book</span>
                Edukasi
            </a>
            <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.pengaturan.*') ? 'bg-primary/10 text-primary font-semibold' : 'text-on-surface-variant hover:bg-surface-variant hover:text-on-surface transition-colors' }}">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                Pengaturan
            </a>
        </nav>

        <!-- Profile / Logout -->
        <div class="p-4 border-t border-outline sticky bottom-0 bg-white z-10">
            <div class="flex items-center gap-3 mb-3 px-2">
                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                    A
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-on-surface truncate">Super Admin</p>
                    <p class="text-xs text-on-surface-variant truncate">admin@ecotrash.com</p>
                </div>
            </div>
            <a href="{{ route('admin.profil.index') }}" class="w-full flex items-center justify-center gap-2 py-2 text-on-surface-variant hover:bg-surface-variant rounded-lg transition-colors text-sm font-medium mb-1">
                <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                Profil Saya
            </a>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors text-sm font-medium">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:pl-64">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-outline flex items-center justify-between px-4 lg:px-8 shadow-sm z-30">
            <!-- Mobile Menu Button -->
            <button @click="sidebarOpen = true" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-variant lg:hidden">
                <span class="material-symbols-outlined">menu</span>
            </button>

            <!-- Search -->
            <div class="hidden md:flex items-center bg-surface-dim rounded-lg px-3 py-2 w-96 border border-outline focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                <span class="material-symbols-outlined text-on-surface-variant text-[20px] mr-2">search</span>
                <input type="text" placeholder="Cari resi, nama warga, atau ID laporan..." class="bg-transparent border-none outline-none text-sm w-full text-on-surface placeholder-on-surface-variant">
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2 md:gap-4">
                <!-- Notification Bell -->
                <div class="relative" x-data @click.outside="notifOpen = false">
                    <button @click="notifOpen = !notifOpen" class="relative p-2 text-on-surface-variant hover:bg-surface-variant rounded-full transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="notifOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 mt-2 w-80 bg-white rounded-xl border border-outline shadow-xl z-50" style="display: none;">
                        <div class="p-4 border-b border-outline flex items-center justify-between">
                            <h4 class="font-bold text-on-surface text-sm">Notifikasi</h4>
                            <span class="text-xs text-primary font-medium cursor-pointer hover:underline">Tandai semua dibaca</span>
                        </div>
                        <div class="divide-y divide-outline max-h-72 overflow-y-auto">
                            <div class="p-4 flex items-start gap-3 hover:bg-surface-dim transition-colors bg-primary/5">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                                </div>
                                <div>
                                    <p class="text-sm text-on-surface font-medium">Pesanan baru masuk</p>
                                    <p class="text-xs text-on-surface-variant mt-0.5">Budi Santoso — Komplek Bunga Asri</p>
                                    <p class="text-xs text-primary mt-1">2 menit lalu</p>
                                </div>
                            </div>
                            <div class="p-4 flex items-start gap-3 hover:bg-surface-dim transition-colors bg-primary/5">
                                <div class="w-9 h-9 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">report</span>
                                </div>
                                <div>
                                    <p class="text-sm text-on-surface font-medium">Laporan baru menunggu verifikasi</p>
                                    <p class="text-xs text-on-surface-variant mt-0.5">Siti Aminah — Lahan Blok C</p>
                                    <p class="text-xs text-primary mt-1">15 menit lalu</p>
                                </div>
                            </div>
                            <div class="p-4 flex items-start gap-3 hover:bg-surface-dim transition-colors">
                                <div class="w-9 h-9 rounded-full bg-green-50 flex items-center justify-center text-green-600 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                </div>
                                <div>
                                    <p class="text-sm text-on-surface font-medium">Tugas petugas selesai</p>
                                    <p class="text-xs text-on-surface-variant mt-0.5">Jajang Suryana — 12 resi diselesaikan</p>
                                    <p class="text-xs text-on-surface-variant mt-1">1 jam lalu</p>
                                </div>
                            </div>
                            <div class="p-4 flex items-start gap-3 hover:bg-surface-dim transition-colors">
                                <div class="w-9 h-9 rounded-full bg-surface-variant flex items-center justify-center text-on-surface-variant shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">article</span>
                                </div>
                                <div>
                                    <p class="text-sm text-on-surface font-medium">Artikel "Daur Ulang Plastik" diterbitkan</p>
                                    <p class="text-xs text-on-surface-variant mt-0.5">Oleh Super Admin</p>
                                    <p class="text-xs text-on-surface-variant mt-1">3 jam lalu</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 text-center border-t border-outline">
                            <a href="{{ route('admin.notifikasi.index') }}" class="text-sm text-primary font-medium hover:underline">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </div>

                <div class="h-8 w-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm lg:hidden">
                    A
                </div>
            </div>
        </header>

        <!-- Emergency Alert Banner -->
        <div x-show="showAlert" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-red-600 text-white px-4 lg:px-8 py-2.5 flex items-center justify-between gap-4 z-20" style="display: none;">
            <div class="flex items-center gap-3 min-w-0">
                <span class="material-symbols-outlined text-[20px] shrink-0 animate-pulse">warning</span>
                <p class="text-sm font-medium truncate">⚠️ <strong>Petugas Asep Sunandar</strong> berhalangan hari ini — Area <strong>Komplek Cemara Indah</strong> belum memiliki petugas aktif.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.operasional.index') }}" class="bg-white/20 hover:bg-white/30 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors whitespace-nowrap">Tugaskan Ulang</a>
                <button @click="showAlert = false" class="text-white/70 hover:text-white p-1 rounded transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        </div>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-8">
            <div class="max-w-[1400px] mx-auto">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-on-surface">@yield('title')</h1>
                    @hasSection('subtitle')
                        <p class="text-on-surface-variant mt-1 text-sm">@yield('subtitle')</p>
                    @endif
                </div>
                
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Global Toast Notification -->
    <div class="fixed bottom-6 right-6 z-[100] pointer-events-none">
        <div x-show="toast.show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            :class="{
                'bg-primary border-primary/20': toast.type === 'success',
                'bg-red-600 border-red-500/20': toast.type === 'error',
                'bg-yellow-500 border-yellow-400/20': toast.type === 'warning'
            }"
            class="pointer-events-auto flex items-center gap-3 px-5 py-3.5 rounded-xl border shadow-2xl text-white min-w-[280px] max-w-sm"
            style="display: none;">
            <span class="material-symbols-outlined text-[20px] shrink-0"
                x-text="toast.type === 'success' ? 'check_circle' : toast.type === 'error' ? 'cancel' : 'info'">
            </span>
            <p class="text-sm font-semibold flex-1" x-text="toast.message"></p>
            <button @click="toast.show = false" class="opacity-70 hover:opacity-100 transition-opacity pointer-events-auto">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
