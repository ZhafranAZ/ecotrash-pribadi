@extends('layouts.warga')

@section('title', 'Aktivitas Saya')

@section('header')
<div class="flex items-center gap-3 w-full justify-center">
    <span class="font-bold text-on-surface text-lg">Aktivitas Saya</span>
</div>
@endsection

@section('content')
<div class="p-4 md:p-0" x-data="{
    tab: 'pesanan',
    showTrackingModal: false,
    showReportModal: false,
    selectedPesanan: null,
    selectedLaporan: null,
    pesananData: @js($pesanan->map(fn($p) => [
        'id' => $p->id,
        'status' => $p->status,
        'kategori_sampah' => $p->kategori_sampah,
        'total_harga_akhir' => $p->total_harga_akhir,
        'harga_awal' => $p->harga_awal,
        'koin_digunakan' => $p->koin_digunakan,
        'tanggal_penjemputan' => $p->tanggal_penjemputan ? $p->tanggal_penjemputan->translatedFormat('l, d M Y') : '-',
        'riwayat' => $p->riwayatStatus->map(fn($r) => [
            'status' => $r->status,
            'keterangan' => $r->keterangan,
            'waktu' => $r->created_at ? $r->created_at->translatedFormat('d M Y, H:i') : '-',
        ]),
    ])),
    laporanData: @js($laporan->map(fn($l) => [
        'id' => $l->id,
        'status' => $l->status,
        'deskripsi' => $l->deskripsi,
        'alamat_lokasi' => $l->alamat_lokasi,
        'foto' => $l->foto_laporan_warga ? asset('storage/' . $l->foto_laporan_warga) : 'https://images.unsplash.com/photo-1605333396825-724bc297341e?q=80&w=800&auto=format&fit=crop',
        'created_at' => $l->created_at ? $l->created_at->translatedFormat('d M Y, H:i') : '-',
    ])),
    openPesanan(id) {
        this.selectedPesanan = this.pesananData.find(p => p.id === id);
        if (this.selectedPesanan) this.showTrackingModal = true;
    },
    openLaporan(id) {
        this.selectedLaporan = this.laporanData.find(l => l.id === id);
        if (this.selectedLaporan) this.showReportModal = true;
    },
    statusLabel(status) {
        return status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
    }
}">
    
    <!-- Header Desktop -->
    <div class="hidden md:flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black text-on-surface">Riwayat Aktivitas</h2>
            <p class="text-on-surface-variant mt-2">Pantau status pesanan pengangkutan dan laporan sampah liar Anda.</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex bg-surface-dim p-1.5 md:p-2 rounded-xl md:rounded-2xl mb-6 md:mb-8 shadow-inner border border-outline/50 md:max-w-md md:mx-0">
        <button @click="tab = 'pesanan'" :class="tab === 'pesanan' ? 'bg-white text-primary font-bold shadow-md' : 'text-on-surface-variant hover:text-on-surface font-medium'" class="flex-1 py-3 md:py-4 text-sm md:text-base rounded-lg md:rounded-xl transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[20px]">local_shipping</span> Pesanan
        </button>
        <button @click="tab = 'laporan'" :class="tab === 'laporan' ? 'bg-white text-orange-500 font-bold shadow-md' : 'text-on-surface-variant hover:text-on-surface font-medium'" class="flex-1 py-3 md:py-4 text-sm md:text-base rounded-lg md:rounded-xl transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[20px]">report</span> Laporan
        </button>
    </div>

    <!-- Tab Content: Pesanan -->
    <div x-show="tab === 'pesanan'" x-transition.opacity class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        @forelse($pesanan as $item)
            <div class="bg-white border border-outline rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-xl hover:shadow-primary/10 transition-all cursor-pointer group"
                 @click="openPesanan('{{ $item->id }}')">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <span class="text-xs uppercase tracking-wider font-bold px-3 py-1.5 rounded-lg border
                            @if($item->status === 'diproses') text-blue-600 bg-blue-50 border-blue-100
                            @elseif($item->status === 'selesai') text-green-600 bg-green-50 border-green-100
                            @elseif($item->status === 'menunggu') text-orange-600 bg-orange-50 border-orange-100
                            @elseif($item->status === 'dibatalkan' || $item->status === 'gagal_pickup') text-red-600 bg-red-50 border-red-100
                            @elseif($item->status === 'hold_kapasitas') text-amber-600 bg-amber-50 border-amber-100
                            @else text-gray-600 bg-gray-50 border-gray-100
                            @endif
                            flex items-center gap-1 w-fit">
                            @if($item->status === 'selesai')<span class="material-symbols-outlined text-[16px] font-bold">check</span>@endif
                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                        </span>
                        <p class="text-sm text-on-surface-variant mt-3 font-medium">{{ $item->tanggal_penjemputan->translatedFormat('d M Y') }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full {{ $item->status === 'selesai' ? 'bg-surface-variant text-on-surface-variant' : 'bg-primary/10 text-primary group-hover:scale-110 group-hover:bg-primary group-hover:text-white' }} flex items-center justify-center transition-all">
                        <span class="material-symbols-outlined text-[24px]">{{ $item->status === 'selesai' ? 'inventory_2' : 'local_shipping' }}</span>
                    </div>
                </div>
                <div class="flex items-end justify-between border-t border-outline/50 pt-4 mt-auto">
                    <div>
                        <p class="text-xs text-on-surface-variant mb-1">Kategori Sampah</p>
                        <p class="font-black text-base text-on-surface">{{ ucfirst($item->kategori_sampah) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-on-surface-variant mb-1">Total Biaya</p>
                        <p class="text-lg font-black {{ $item->status === 'selesai' ? 'text-on-surface' : 'text-primary' }}">Rp{{ number_format($item->total_harga_akhir, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                <div class="w-24 h-24 bg-surface-dim rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-outline">
                    <span class="material-symbols-outlined text-[40px] text-on-surface-variant">inbox</span>
                </div>
                <h3 class="text-lg font-bold text-on-surface mb-1">Belum Ada Pesanan</h3>
                <p class="text-sm text-on-surface-variant">Anda belum pernah memesan pengangkutan sampah.</p>
            </div>
        @endforelse
    </div>

    <!-- Tab Content: Laporan -->
    <div x-show="tab === 'laporan'" x-transition.opacity style="display:none;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @forelse($laporan as $item)
                <div class="bg-white border border-outline rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-md transition-shadow flex gap-5 cursor-pointer group"
                     @click="openLaporan({{ $item->id }})">
                    <div class="w-24 h-24 md:w-28 md:h-28 rounded-2xl bg-surface-dim overflow-hidden border border-outline shrink-0 shadow-inner">
                        <img src="{{ $item->foto_laporan_warga ? asset('storage/' . $item->foto_laporan_warga) : 'https://images.unsplash.com/photo-1605333396825-724bc297341e?q=80&w=200&auto=format&fit=crop' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                    </div>
                    <div class="flex flex-col justify-between flex-1 py-1">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] md:text-xs uppercase tracking-wider font-bold px-2.5 py-1 rounded-md border
                                @if($item->status === 'menunggu') text-orange-600 bg-orange-50 border-orange-100
                                @elseif($item->status === 'disetujui' || $item->status === 'sedang_dibersihkan') text-blue-600 bg-blue-50 border-blue-100
                                @elseif($item->status === 'selesai') text-green-600 bg-green-50 border-green-100
                                @elseif($item->status === 'ditolak') text-red-600 bg-red-50 border-red-100
                                @else text-gray-600 bg-gray-50 border-gray-100
                                @endif
                            ">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span>
                            <span class="text-xs md:text-sm text-on-surface-variant font-medium">{{ $item->created_at->translatedFormat('d M') }}</span>
                        </div>
                        <div>
                            <p class="font-bold text-sm md:text-base text-on-surface line-clamp-2 leading-tight mb-1 group-hover:text-primary transition-colors">{{ $item->alamat_lokasi ?? 'Lokasi Laporan' }}</p>
                            <p class="text-xs text-on-surface-variant line-clamp-1">{{ Str::limit($item->deskripsi, 60) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-24 h-24 bg-surface-dim rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-outline">
                        <span class="material-symbols-outlined text-[40px] text-on-surface-variant">inbox</span>
                    </div>
                    <h3 class="text-lg font-bold text-on-surface mb-1">Belum Ada Laporan</h3>
                    <p class="text-sm text-on-surface-variant">Anda belum pernah melaporkan tumpukan sampah liar.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ================================================ -->
    <!-- TRACKING MODAL (Dynamic Timeline) -->
    <!-- ================================================ -->
    <div class="fixed inset-0 z-[100] pointer-events-none flex flex-col justify-end md:justify-center md:items-center">
        <div x-show="showTrackingModal" x-transition.opacity class="absolute inset-0 bg-black/50 pointer-events-auto backdrop-blur-sm" @click="showTrackingModal = false" style="display:none;"></div>
        
        <div x-show="showTrackingModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full md:translate-y-4 md:scale-95 md:opacity-0"
             x-transition:enter-end="translate-y-0 md:translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 md:translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave-end="translate-y-full md:translate-y-4 md:scale-95 md:opacity-0"
             class="bg-white rounded-t-3xl md:rounded-3xl w-full max-w-md mx-auto md:w-[480px] pointer-events-auto flex flex-col shadow-2xl relative max-h-[90vh] overflow-hidden"
             style="display:none;">
            
            <div class="w-12 h-1.5 bg-surface-variant rounded-full mx-auto my-3 md:hidden"></div>
            <div class="p-5 border-b border-outline flex justify-between items-center bg-surface md:rounded-t-3xl">
                <h3 class="font-black text-lg text-on-surface">Detail Lacak Pesanan</h3>
                <button @click="showTrackingModal = false" class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-red-100 hover:text-red-600 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto">
                <template x-if="selectedPesanan">
                    <div>
                        <!-- Pesanan Info Card -->
                        <div class="flex items-center gap-4 mb-6 p-4 bg-primary/5 border border-primary/20 rounded-2xl">
                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined">local_shipping</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-on-surface text-sm truncate" x-text="'Pesanan #' + selectedPesanan.id"></p>
                                <p class="text-xs text-on-surface-variant" x-text="selectedPesanan.tanggal_penjemputan"></p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-xs text-on-surface-variant">Total</p>
                                <p class="font-black text-primary" x-text="'Rp' + Number(selectedPesanan.total_harga_akhir).toLocaleString('id-ID')"></p>
                            </div>
                        </div>

                        <!-- Dynamic Timeline from riwayatStatus -->
                        <div class="space-y-0 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-outline before:to-transparent">
                            <template x-for="(step, index) in selectedPesanan.riwayat" :key="index">
                                <div class="relative flex items-start gap-4 pb-6">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white shrink-0 shadow-sm z-10"
                                         :class="index === selectedPesanan.riwayat.length - 1 ? 'bg-primary text-white' : 'bg-green-500 text-white'">
                                        <span class="material-symbols-outlined text-[16px]" x-text="index === selectedPesanan.riwayat.length - 1 ? (step.status === 'selesai' ? 'check_circle' : 'radio_button_checked') : 'check'"></span>
                                    </div>
                                    <div class="flex-1 p-4 rounded-xl border shadow-sm"
                                         :class="index === selectedPesanan.riwayat.length - 1 ? 'border-primary bg-primary/5' : 'border-outline bg-surface'">
                                        <h4 class="font-bold text-sm" :class="index === selectedPesanan.riwayat.length - 1 ? 'text-primary' : 'text-on-surface'" x-text="statusLabel(step.status)"></h4>
                                        <p class="text-xs text-on-surface-variant mt-1" x-text="step.keterangan"></p>
                                        <p class="text-[10px] text-on-surface-variant mt-2 font-medium" x-text="step.waktu"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ================================================ -->
        <!-- REPORT MODAL (Dynamic Laporan Detail) -->
        <!-- ================================================ -->
        <div x-show="showReportModal" x-transition.opacity class="absolute inset-0 bg-black/50 pointer-events-auto backdrop-blur-sm" @click="showReportModal = false" style="display:none;"></div>
        
        <div x-show="showReportModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full md:translate-y-4 md:scale-95 md:opacity-0"
             x-transition:enter-end="translate-y-0 md:translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 md:translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave-end="translate-y-full md:translate-y-4 md:scale-95 md:opacity-0"
             class="bg-white rounded-t-3xl md:rounded-3xl w-full max-w-md mx-auto md:w-[500px] pointer-events-auto flex flex-col shadow-2xl relative max-h-[90vh] overflow-hidden"
             style="display:none;">
            
            <div class="w-12 h-1.5 bg-surface-variant rounded-full mx-auto my-3 md:hidden z-10"></div>
            
            <button @click="showReportModal = false" class="hidden md:flex absolute top-4 right-4 w-10 h-10 bg-surface/50 backdrop-blur-md rounded-full items-center justify-center hover:bg-surface-variant text-on-surface transition-colors z-10 shadow-sm">
                <span class="material-symbols-outlined">close</span>
            </button>
            
            <template x-if="selectedLaporan">
                <div>
                    <div class="h-48 md:h-64 relative bg-surface-dim shrink-0">
                        <img :src="selectedLaporan.foto" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-6 right-6">
                            <span class="text-xs uppercase tracking-wider font-bold text-white px-3 py-1.5 rounded-lg border border-white/20 mb-2 inline-block"
                                  :class="{
                                      'bg-orange-500/80': selectedLaporan.status === 'menunggu',
                                      'bg-blue-500/80': selectedLaporan.status === 'disetujui' || selectedLaporan.status === 'sedang_dibersihkan',
                                      'bg-green-500/80': selectedLaporan.status === 'selesai',
                                      'bg-red-500/80': selectedLaporan.status === 'ditolak'
                                  }"
                                  x-text="statusLabel(selectedLaporan.status)"></span>
                            <h3 class="font-black text-2xl text-white leading-tight" x-text="selectedLaporan.alamat_lokasi || 'Lokasi Laporan'"></h3>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 overflow-y-auto">
                        <div class="flex items-start gap-3 mb-6 bg-surface p-4 rounded-2xl border border-outline">
                            <span class="material-symbols-outlined text-primary mt-0.5">location_on</span>
                            <div>
                                <p class="font-bold text-on-surface text-sm">Lokasi Laporan</p>
                                <p class="text-xs text-on-surface-variant mt-1" x-text="selectedLaporan.alamat_lokasi"></p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <p class="font-bold text-on-surface text-sm mb-2">Deskripsi Pelapor</p>
                            <p class="text-sm text-on-surface-variant leading-relaxed" x-text="selectedLaporan.deskripsi"></p>
                        </div>

                        <div class="border-t border-outline pt-4">
                            <p class="text-xs text-on-surface-variant">Dilaporkan pada: <span class="font-bold" x-text="selectedLaporan.created_at"></span></p>
                        </div>

                        <button @click="showReportModal = false" class="w-full bg-surface border border-outline text-on-surface font-bold py-4 rounded-xl hover:bg-surface-variant transition-colors mt-4 md:hidden">
                            Tutup
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
@endsection
