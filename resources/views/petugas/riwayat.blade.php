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
                        <span class="text-2xl font-black text-on-surface">{{ $totalSelesai }}</span>
                    </div>
                </div>
                <div class="bg-surface border border-outline rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Kendala</p>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-orange-500 text-[24px]">warning</span>
                        <span class="text-2xl font-black text-on-surface">{{ $totalKendala }}</span>
                    </div>
                </div>
            </div>

            <!-- TAB PESANAN -->
            <div x-show="activeTab === 'pesanan'" x-transition.opacity class="space-y-6">
                @forelse($pesananByKomplek as $namaKomplek => $pesanans)
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="h-6 w-1 bg-primary rounded-full"></div>
                            <h2 class="font-bold text-sm text-on-surface">{{ $namaKomplek }}</h2>
                        </div>
                        <div class="space-y-3">
                            @foreach($pesanans as $pesanan)
                                @php
                                    $isSelesai = $pesanan->status === 'selesai';
                                    $iconBg = $isSelesai ? 'bg-primary/20' : 'bg-orange-100';
                                    $iconColor = $isSelesai ? 'text-primary' : 'text-orange-500';
                                    $icon = $isSelesai ? 'check' : 'report';
                                    $statusLabel = $isSelesai ? 'Selesai' : 'Hold Kapasitas';
                                    $statusColor = $isSelesai ? 'text-primary' : 'text-orange-500';
                                @endphp
                                <a href="{{ route('petugas.riwayat.detail', ['type' => 'pesanan', 'id' => $pesanan->id]) }}" class="block glass-card rounded-2xl p-4 flex items-center gap-4 hover:scale-[0.99] transition-transform">
                                    <div class="w-12 h-12 rounded-full {{ $iconBg }} flex items-center justify-center {{ $iconColor }} shrink-0">
                                        <span class="material-symbols-outlined">{{ $icon }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-sm text-on-surface mb-0.5">{{ $pesanan->id }}</p>
                                        <p class="text-xs text-on-surface-variant line-clamp-1">{{ $pesanan->blok_nomor_rumah ?? $pesanan->nama_alamat_snapshot }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-bold {{ $statusColor }}">{{ $statusLabel }}</p>
                                        <p class="text-[10px] text-on-surface-variant mt-0.5">{{ $pesanan->updated_at->format('H:i') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <span class="material-symbols-outlined text-on-surface-variant text-[48px] mb-3">inbox</span>
                        <p class="text-sm font-medium text-on-surface-variant">Belum ada riwayat pesanan</p>
                    </div>
                @endforelse
            </div>

            <!-- TAB LAPORAN -->
            <div x-show="activeTab === 'laporan'" x-transition.opacity class="space-y-4" style="display: none;">
                @forelse($laporanSelesai as $laporan)
                    @php
                        $isSelesai = $laporan->status === 'selesai';
                        $iconBg = $isSelesai ? 'bg-primary/20' : 'bg-red-100';
                        $iconColor = $isSelesai ? 'text-primary' : 'text-red-500';
                        $icon = $isSelesai ? 'check' : 'close';
                        $statusLabel = $isSelesai ? 'Selesai' : 'Ditolak';
                        $statusColor = $isSelesai ? 'text-primary' : 'text-red-500';
                    @endphp
                    <a href="{{ route('petugas.riwayat.detail', ['type' => 'laporan', 'id' => $laporan->id]) }}" class="block glass-card rounded-2xl p-4 flex items-center gap-4 hover:scale-[0.99] transition-transform">
                        <div class="w-12 h-12 rounded-full {{ $iconBg }} flex items-center justify-center {{ $iconColor }} shrink-0">
                            <span class="material-symbols-outlined">{{ $icon }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-sm text-on-surface mb-0.5">LAP-{{ str_pad($laporan->id, 3, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-xs text-on-surface-variant line-clamp-1">{{ $laporan->alamat_lokasi ?? ($laporan->lat && $laporan->lng ? $laporan->lat . ', ' . $laporan->lng : 'Lokasi tidak tersedia') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold {{ $statusColor }}">{{ $statusLabel }}</p>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">{{ $laporan->updated_at->format('H:i') }}</p>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-12">
                        <span class="material-symbols-outlined text-on-surface-variant text-[48px] mb-3">inbox</span>
                        <p class="text-sm font-medium text-on-surface-variant">Belum ada riwayat laporan</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-petugas-layout>
