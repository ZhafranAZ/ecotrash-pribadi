<x-petugas-layout>
    <div x-data="{ activeTab: 'pesanan' }">
        <!-- Header -->
        <header class="bg-surface border-b border-outline px-4 pt-6 pb-4 sticky top-0 z-30">
            <h1 class="text-xl font-black text-on-surface mb-4">Riwayat Tugas</h1>
            
            <!-- Segmented Control Tabs -->
            <div class="bg-surface-variant p-1.5 rounded-2xl flex gap-1">
                <button 
                    @click="activeTab = 'pesanan'"
                    :class="activeTab === 'pesanan' ? 'bg-surface text-on-surface shadow-sm font-bold' : 'text-on-surface-variant font-medium hover:text-on-surface'"
                    class="flex-1 py-2.5 text-sm rounded-xl transition-all flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                    Pesanan
                </button>
                <button 
                    @click="activeTab = 'laporan'"
                    :class="activeTab === 'laporan' ? 'bg-surface text-on-surface shadow-sm font-bold' : 'text-on-surface-variant font-medium hover:text-on-surface'"
                    class="flex-1 py-2.5 text-sm rounded-xl transition-all flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">report</span>
                    Laporan
                </button>
            </div>
        </header>

        <div class="px-4 py-6 pb-24 space-y-6">
            
            <!-- Summary Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-surface border border-outline rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Selesai</p>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[24px]">check_circle</span>
                        <span class="text-2xl font-black text-on-surface">4</span>
                    </div>
                </div>
                <div class="bg-surface border border-outline rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Kendala</p>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-orange-500 text-[24px]">warning</span>
                        <span class="text-2xl font-black text-on-surface">1</span>
                    </div>
                </div>
            </div>

            <!-- TAB PESANAN -->
            <div x-show="activeTab === 'pesanan'" x-transition.opacity class="space-y-6">
                <!-- Grup Komplek 1 -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="h-6 w-1 bg-primary rounded-full"></div>
                        <h2 class="font-bold text-sm text-on-surface">Komp. Permata Hijau</h2>
                    </div>
                    <div class="space-y-3">
                        <!-- Item Riwayat -->
                        <a href="{{ route('petugas.riwayat.detail', 'INV-0998') }}" class="block glass-card rounded-2xl p-4 flex items-center gap-4 hover:scale-[0.99] transition-transform">
                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">check</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-sm text-on-surface mb-0.5">INV-0998</p>
                                <p class="text-xs text-on-surface-variant line-clamp-1">Kav 4, Blok B</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-primary">Selesai</p>
                                <p class="text-[10px] text-on-surface-variant mt-0.5">07:45</p>
                            </div>
                        </a>
                        <a href="{{ route('petugas.riwayat.detail', 'INV-0999') }}" class="block glass-card rounded-2xl p-4 flex items-center gap-4 hover:scale-[0.99] transition-transform">
                            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 shrink-0">
                                <span class="material-symbols-outlined">report</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-sm text-on-surface mb-0.5">INV-0999</p>
                                <p class="text-xs text-on-surface-variant line-clamp-1">Kav 5, Blok C</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-orange-500">Terkunci</p>
                                <p class="text-[10px] text-on-surface-variant mt-0.5">07:30</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Grup Komplek 2 -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="h-6 w-1 bg-primary rounded-full"></div>
                        <h2 class="font-bold text-sm text-on-surface">Perumahan Asri Indah</h2>
                    </div>
                    <div class="space-y-3">
                        <a href="{{ route('petugas.riwayat.detail', 'INV-1000') }}" class="block glass-card rounded-2xl p-4 flex items-center gap-4 hover:scale-[0.99] transition-transform">
                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">check</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-sm text-on-surface mb-0.5">INV-1000</p>
                                <p class="text-xs text-on-surface-variant line-clamp-1">Jl. Sudirman No 2</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-primary">Selesai</p>
                                <p class="text-[10px] text-on-surface-variant mt-0.5">07:15</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- TAB LAPORAN -->
            <div x-show="activeTab === 'laporan'" x-transition.opacity class="space-y-4" style="display: none;">
                <a href="{{ route('petugas.riwayat.detail', 'LAP-001') }}" class="block glass-card rounded-2xl p-4 flex items-center gap-4 hover:scale-[0.99] transition-transform">
                    <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined">check</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface mb-0.5">LAP-001</p>
                        <p class="text-xs text-on-surface-variant line-clamp-1">Lahan Kosong Depan Minimarket</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-primary">Selesai</p>
                        <p class="text-[10px] text-on-surface-variant mt-0.5">08:15</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-petugas-layout>
