<x-petugas-layout>
    <div class="px-4 pt-6 pb-24" x-data="{ activeTab: 'pesanan' }">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-sm font-bold text-on-surface-variant">Halo Petugas,</p>
                <h1 class="text-2xl font-black text-on-surface">Ahmad Sobari</h1>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center border-2 border-white shadow-sm shrink-0">
                <span class="material-symbols-outlined text-[24px]">account_circle</span>
            </div>
        </div>

        <!-- Segmented Control -->
        <div class="bg-surface border border-outline rounded-2xl p-1 flex items-center mb-6 shadow-sm">
            <button @click="activeTab = 'pesanan'" 
                class="flex-1 py-2.5 rounded-xl text-sm font-bold transition-all"
                :class="activeTab === 'pesanan' ? 'bg-primary text-white shadow-md' : 'text-on-surface-variant hover:bg-surface-variant'">
                Pesanan Warga
            </button>
            <button @click="activeTab = 'laporan'" 
                class="flex-1 py-2.5 rounded-xl text-sm font-bold transition-all"
                :class="activeTab === 'laporan' ? 'bg-primary text-white shadow-md' : 'text-on-surface-variant hover:bg-surface-variant'">
                Laporan Liar
            </button>
        </div>

        <!-- TAB: PESANAN -->
        <div x-show="activeTab === 'pesanan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4">
            
            <div class="flex items-center justify-between mb-4 px-1">
                <h2 class="text-lg font-black text-on-surface">Area Tugas Hari Ini</h2>
                <span class="text-xs font-bold bg-primary text-white px-3 py-1 rounded-full shadow-sm">2 Komplek</span>
            </div>

            <!-- Komplek Card 1 -->
            <a href="{{ route('petugas.komplek.warga', ['id' => 1]) }}" class="block glass-card rounded-3xl p-5 hover:scale-[0.99] transition-transform">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary/20 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[28px]">holiday_village</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-bold text-on-surface mb-0.5 truncate">Perumahan Asri Indah</h3>
                        <p class="text-xs font-medium text-on-surface-variant">Kec. Bojongsoang</p>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white text-xs font-black shadow-sm mb-1">
                            8
                        </div>
                        <p class="text-[10px] font-bold text-on-surface-variant">Titik</p>
                    </div>
                </div>
            </a>

            <!-- Komplek Card 2 -->
            <a href="{{ route('petugas.komplek.warga', ['id' => 2]) }}" class="block glass-card rounded-3xl p-5 hover:scale-[0.99] transition-transform">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-surface-variant flex items-center justify-center text-on-surface-variant shrink-0">
                        <span class="material-symbols-outlined text-[28px]">domain</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-bold text-on-surface mb-0.5 truncate">Komp. Permata Hijau</h3>
                        <p class="text-xs font-medium text-on-surface-variant">Kec. Bojongsoang</p>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-surface text-on-surface text-xs font-black border border-outline shadow-sm mb-1">
                            0
                        </div>
                        <p class="text-[10px] font-bold text-on-surface-variant">Titik</p>
                    </div>
                </div>
            </a>

        </div>

        <!-- TAB: LAPORAN LIAR -->
        <div x-show="activeTab === 'laporan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-4">
            
            <div class="flex items-center justify-between mb-4 px-1">
                <h2 class="text-lg font-black text-on-surface">Laporan Menunggu</h2>
                <span class="text-xs font-bold bg-orange-500 text-white px-3 py-1 rounded-full shadow-sm">1 Laporan</span>
            </div>

            <!-- Laporan Card -->
            <a href="{{ route('petugas.laporan.detail', ['id' => 1]) }}" class="block glass-card rounded-3xl p-5 hover:scale-[0.99] transition-transform border-orange-200">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl overflow-hidden shrink-0 bg-surface-variant">
                        <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?auto=format&fit=crop&w=150&q=80" alt="Sampah" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold text-orange-600 bg-orange-100 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                Laporan Warga
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-on-surface mb-1 line-clamp-2">Tumpukan sampah plastik di lahan kosong depan minimarket.</h3>
                        <p class="text-xs font-medium text-on-surface-variant flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">location_on</span>
                            Komp. Permata Hijau
                        </p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-outline flex items-center justify-between">
                    <span class="text-[10px] font-bold text-on-surface-variant">Dilaporkan: 2 jam lalu</span>
                    <div class="flex items-center text-primary text-xs font-bold">
                        Lihat Lokasi <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                    </div>
                </div>
            </a>
            
        </div>
    </div>
</x-petugas-layout>
