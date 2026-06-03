<x-petugas-layout>
    <div class="px-4 pt-6 pb-24" x-data="{ activeTab: 'pesanan' }">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-sm font-bold text-on-surface-variant">Halo Petugas,</p>
                <h1 class="text-2xl font-black text-on-surface">{{ $petugas->nama }}</h1>
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
                <span class="text-xs font-bold bg-primary text-white px-3 py-1 rounded-full shadow-sm">{{ $kompleks->count() }} Komplek</span>
            </div>

            @forelse($kompleks as $komplek)
                @php
                    $activePesananCount = $komplek->pesanan()
                        ->where('petugas_id', $petugas->id)
                        ->whereIn('status', ['menunggu', 'sedang_diangkut', 'ditunda'])
                        ->count();
                @endphp
                <a href="{{ route('petugas.komplek.warga', ['id' => $komplek->id]) }}" class="block glass-card rounded-3xl p-5 hover:scale-[0.99] transition-transform">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-primary/20 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[28px]">holiday_village</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-on-surface mb-0.5 truncate">{{ $komplek->nama_komplek }}</h3>
                            <p class="text-xs font-medium text-on-surface-variant">Kec. Bojongsoang</p>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white text-xs font-black shadow-sm mb-1">
                                {{ $activePesananCount }}
                            </div>
                            <p class="text-[10px] font-bold text-on-surface-variant">Titik</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">info</span>
                    <p class="text-sm font-bold text-on-surface">Tidak ada area tugas hari ini.</p>
                </div>
            @endforelse

        </div>

        <!-- TAB: LAPORAN LIAR -->
        <div x-show="activeTab === 'laporan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="space-y-4">
            
            <div class="flex items-center justify-between mb-4 px-1">
                <h2 class="text-lg font-black text-on-surface">Laporan Menunggu</h2>
                <span class="text-xs font-bold bg-orange-500 text-white px-3 py-1 rounded-full shadow-sm">{{ $laporanLiar->count() }} Laporan</span>
            </div>

            @forelse($laporanLiar as $laporan)
                <a href="{{ route('petugas.laporan.detail', ['id' => $laporan->id]) }}" class="block glass-card rounded-3xl p-5 hover:scale-[0.99] transition-transform border-orange-200">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden shrink-0 bg-surface-variant">
                            <img src="{{ $laporan->foto_laporan_warga ? asset('storage/' . $laporan->foto_laporan_warga) : 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?auto=format&fit=crop&w=150&q=80' }}" alt="Sampah" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-bold text-orange-600 bg-orange-100 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                    Status: {{ str_replace('_', ' ', $laporan->status) }}
                                </span>
                            </div>
                            <h3 class="text-sm font-bold text-on-surface mb-1 line-clamp-2">{{ $laporan->deskripsi }}</h3>
                            <p class="text-xs font-medium text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">location_on</span>
                                {{ $laporan->komplek->nama_komplek ?? 'Lokasi tidak terdaftar' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-outline flex items-center justify-between">
                        <span class="text-[10px] font-bold text-on-surface-variant">Dilaporkan: {{ $laporan->created_at->diffForHumans() }}</span>
                        <div class="flex items-center text-primary text-xs font-bold">
                            Lihat Lokasi <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">check_circle</span>
                    <p class="text-sm font-bold text-on-surface">Tidak ada laporan menunggu pembersihan.</p>
                </div>
            @endforelse
            
        </div>
    </div>
</x-petugas-layout>
