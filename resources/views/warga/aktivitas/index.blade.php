@extends('layouts.warga')

@section('title', 'Aktivitas Saya')

@section('header')
<div class="flex items-center gap-3 w-full justify-center">
    <span class="font-bold text-on-surface text-lg">Aktivitas Saya</span>
</div>
@endsection

@section('content')
<div class="p-4 md:p-0" x-data="{ tab: 'pesanan', showResiModal: false, showTrackingModal: false, showReportModal: false }">
    
    <!-- Header Desktop -->
    <div class="hidden md:flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black text-on-surface">Riwayat Aktivitas</h2>
            <p class="text-on-surface-variant mt-2">Pantau status pesanan pengangkutan dan laporan sampah liar Anda.</p>
        </div>
    </div>

    <!-- Tabs (Wider on desktop) -->
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
        <!-- Card 1 (Diproses) -->
        <div class="bg-white border border-outline rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-xl hover:shadow-primary/10 transition-all cursor-pointer group" @click="showTrackingModal = true">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <span class="text-xs uppercase tracking-wider font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">Diproses</span>
                    <p class="text-sm text-on-surface-variant mt-3 font-medium">12 Mei 2026</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[24px]">local_shipping</span>
                </div>
            </div>
            <div class="flex items-end justify-between border-t border-outline/50 pt-4 mt-auto">
                <div>
                    <p class="text-xs text-on-surface-variant mb-1">Kategori Sampah</p>
                    <p class="font-black text-base text-on-surface">Besar</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-on-surface-variant mb-1">Total Biaya</p>
                    <p class="text-lg font-black text-primary">Rp25.000</p>
                </div>
            </div>
        </div>

        <!-- Card 2 (Selesai) -->
        <div class="bg-white border border-outline rounded-3xl p-5 md:p-6 shadow-sm opacity-80 hover:opacity-100 transition-opacity cursor-pointer" @click="showResiModal = true">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <span class="text-xs uppercase tracking-wider font-bold text-green-600 bg-green-50 px-3 py-1.5 rounded-lg border border-green-100 flex items-center gap-1 w-fit">
                        <span class="material-symbols-outlined text-[16px] font-bold">check</span> Selesai
                    </span>
                    <p class="text-sm text-on-surface-variant mt-3 font-medium">08 Mei 2026</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-surface-variant flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[24px]">inventory_2</span>
                </div>
            </div>
            <div class="flex items-end justify-between border-t border-outline/50 pt-4 mt-auto">
                <div>
                    <p class="text-xs text-on-surface-variant mb-1">Kategori Sampah</p>
                    <p class="font-black text-base text-on-surface">Kecil</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-on-surface-variant mb-1">Total Biaya</p>
                    <p class="text-lg font-black text-on-surface">Rp15.000</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content: Laporan -->
    <div x-show="tab === 'laporan'" x-transition.opacity style="display:none;">
        <template x-if="true"> <!-- Change to true to see report, false for empty state. For now, true. -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <div class="bg-white border border-outline rounded-3xl p-5 md:p-6 shadow-sm hover:shadow-md transition-shadow flex gap-5 cursor-pointer group" @click="showReportModal = true">
                    <div class="w-24 h-24 md:w-28 md:h-28 rounded-2xl bg-surface-dim overflow-hidden border border-outline shrink-0 shadow-inner">
                        <img src="https://images.unsplash.com/photo-1605333396825-724bc297341e?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                    </div>
                    <div class="flex flex-col justify-between flex-1 py-1">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] md:text-xs uppercase tracking-wider font-bold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-md border border-orange-100">Menunggu</span>
                            <span class="text-xs md:text-sm text-on-surface-variant font-medium">15 Mei</span>
                        </div>
                        <div>
                            <p class="font-bold text-sm md:text-base text-on-surface line-clamp-2 leading-tight mb-1 group-hover:text-primary transition-colors">Lahan Kosong Blok C</p>
                            <p class="text-xs text-on-surface-variant line-clamp-1">Sampah plastik menumpuk dan bau menyengat...</p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template x-if="false"> <!-- Empty state -->
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-24 h-24 bg-surface-dim rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-outline">
                    <span class="material-symbols-outlined text-[40px] text-on-surface-variant">inbox</span>
                </div>
                <h3 class="text-lg font-bold text-on-surface mb-1">Belum Ada Laporan</h3>
                <p class="text-sm text-on-surface-variant">Anda belum pernah melaporkan tumpukan sampah liar.</p>
            </div>
        </template>
    </div>

    <!-- Resi Modal (Bottom Sheet on Mobile, Center Modal on Desktop) -->
    <div class="fixed inset-0 z-[100] pointer-events-none flex flex-col justify-end md:justify-center md:items-center">
        <div x-show="showResiModal" x-transition.opacity class="absolute inset-0 bg-black/50 pointer-events-auto backdrop-blur-sm" @click="showResiModal = false" style="display:none;"></div>
        
        <div x-show="showResiModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full md:translate-y-4 md:scale-95 md:opacity-0"
             x-transition:enter-end="translate-y-0 md:translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 md:translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave-end="translate-y-full md:translate-y-4 md:scale-95 md:opacity-0"
             class="bg-white rounded-t-3xl md:rounded-3xl w-full max-w-md mx-auto md:w-[480px] pointer-events-auto flex flex-col shadow-2xl relative"
             style="display:none;">
            
            <div class="w-12 h-1.5 bg-surface-variant rounded-full mx-auto my-3 md:hidden"></div>
            
            <!-- Close Button Desktop -->
            <button @click="showResiModal = false" class="hidden md:flex absolute top-4 right-4 w-10 h-10 bg-surface rounded-full items-center justify-center hover:bg-surface-variant text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
            
            <div class="px-6 pb-8 pt-4 md:pt-10 md:px-10">
                <div class="text-center mb-8 relative">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4 text-primary shadow-inner">
                        <span class="material-symbols-outlined text-[40px]">receipt_long</span>
                    </div>
                    <h3 class="font-black text-2xl text-on-surface">Resi Pemesanan</h3>
                    <p class="text-sm font-mono text-on-surface-variant mt-2 bg-surface inline-block px-3 py-1 rounded-md border border-outline">INV-120526-001</p>
                </div>
                
                <div class="bg-surface p-6 rounded-3xl text-sm border border-outline relative overflow-hidden shadow-sm">
                    <!-- Ticket cutouts -->
                    <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full border-r border-outline shadow-inner"></div>
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full border-l border-outline shadow-inner"></div>
                    
                    <div class="space-y-5">
                        <div class="flex justify-between items-center">
                            <span class="text-on-surface-variant font-medium text-sm">Jadwal Jemput</span>
                            <span class="font-bold text-on-surface text-base">Senin, 12 Mei 2026</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-on-surface-variant font-medium text-sm">Kategori</span>
                            <span class="font-bold text-on-surface bg-white shadow-sm border border-outline px-3 py-1 rounded-lg">Besar</span>
                        </div>
                        <hr class="border-outline border-dashed my-6">
                        <div class="flex justify-between items-center">
                            <span class="text-on-surface-variant font-medium">Biaya Dasar</span>
                            <span class="font-bold text-on-surface text-base">Rp35.000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-amber-600 font-medium flex items-center gap-1.5"><span class="material-symbols-outlined text-[18px]">generating_tokens</span> Potongan Koin</span>
                            <span class="font-bold text-amber-600 text-base">- Rp10.000</span>
                        </div>
                        <div class="h-4"></div>
                        <div class="flex justify-between items-end pt-5 mt-1 border-t-2 border-outline border-dashed">
                            <span class="text-on-surface font-bold text-lg mb-1">Total Bayar</span>
                            <span class="font-black text-primary text-3xl tracking-tight">Rp25.000</span>
                        </div>
                    </div>
                </div>

                <button @click="showResiModal = false" class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-primary-dark transition-colors mt-8 shadow-lg shadow-primary/30 text-lg md:hidden">
                    Tutup Resi
                </button>
            </div>
        </div>

        <!-- Tracking Modal -->
        <div x-show="showTrackingModal" x-transition.opacity class="absolute inset-0 bg-black/50 pointer-events-auto backdrop-blur-sm" @click="showTrackingModal = false" style="display:none;"></div>
        <div x-show="showTrackingModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full md:translate-y-4 md:scale-95 md:opacity-0"
             x-transition:enter-end="translate-y-0 md:translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 md:translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave-end="translate-y-full md:translate-y-4 md:scale-95 md:opacity-0"
             class="bg-white rounded-t-3xl md:rounded-3xl w-full max-w-md mx-auto md:w-[480px] pointer-events-auto flex flex-col shadow-2xl relative"
             style="display:none;">
            
            <div class="w-12 h-1.5 bg-surface-variant rounded-full mx-auto my-3 md:hidden"></div>
            <div class="p-5 border-b border-outline flex justify-between items-center bg-surface md:rounded-t-3xl">
                <h3 class="font-black text-lg text-on-surface">Detail Lacak Pesanan</h3>
                <button @click="showTrackingModal = false" class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-red-100 hover:text-red-600 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6 p-4 bg-primary/5 border border-primary/20 rounded-2xl">
                    <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface">Menuju Lokasi Anda</p>
                        <p class="text-xs text-on-surface-variant">Estimasi tiba: 10-15 menit</p>
                    </div>
                </div>

                <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-outline before:to-transparent">
                    <div class="relative flex items-center justify-between md:justify-normal group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-primary text-white shrink-0 shadow-sm z-10">
                            <span class="material-symbols-outlined text-[16px]">check</span>
                        </div>
                        <div class="w-[calc(100%-3rem)] p-4 rounded-xl border border-primary bg-primary/5 shadow-sm">
                            <h3 class="font-bold text-primary text-sm">Menuju Lokasi</h3>
                            <p class="text-xs text-on-surface-variant mt-1">Petugas (Ahmad) sedang dalam perjalanan.</p>
                        </div>
                    </div>
                    <div class="relative flex items-center justify-between md:justify-normal group">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-surface-variant text-on-surface-variant shrink-0 z-10">
                            <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                        </div>
                        <div class="w-[calc(100%-3rem)] p-4 rounded-xl border border-outline bg-surface">
                            <h3 class="font-bold text-on-surface text-sm">Pesanan Diterima</h3>
                            <p class="text-xs text-on-surface-variant mt-1">Menunggu petugas mengambil pesanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Modal -->
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
            
            <div class="h-48 md:h-64 relative bg-surface-dim shrink-0">
                <img src="https://images.unsplash.com/photo-1605333396825-724bc297341e?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-4 left-6 right-6">
                    <span class="text-xs uppercase tracking-wider font-bold text-white bg-orange-500/80 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/20 mb-2 inline-block">Menunggu Tinjauan</span>
                    <h3 class="font-black text-2xl text-white leading-tight">Lahan Kosong Blok C</h3>
                </div>
            </div>

            <div class="p-6 md:p-8 overflow-y-auto">
                <div class="flex items-start gap-3 mb-6 bg-surface p-4 rounded-2xl border border-outline">
                    <span class="material-symbols-outlined text-primary mt-0.5">location_on</span>
                    <div>
                        <p class="font-bold text-on-surface text-sm">Lokasi Pin Peta</p>
                        <p class="text-xs text-on-surface-variant mt-1">Jl. Mawar Merah No. 12, RT 01/RW 02, Kec. Sukajadi.</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="font-bold text-on-surface text-sm mb-2">Deskripsi Pelapor</p>
                    <p class="text-sm text-on-surface-variant leading-relaxed">"Sampah plastik menumpuk dan bau menyengat di lahan kosong pinggir jalan. Sudah ada sekitar 3 hari tidak diangkut."</p>
                </div>

                <div class="border-t border-outline pt-6">
                    <p class="font-bold text-on-surface text-sm mb-3">Status Tindak Lanjut</p>
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[16px]">pending</span>
                            </div>
                            <div class="w-0.5 h-full bg-outline my-1"></div>
                        </div>
                        <div class="pb-6">
                            <p class="font-bold text-sm text-on-surface">Laporan Diterima</p>
                            <p class="text-xs text-on-surface-variant mt-1">15 Mei 2026, 09:30 WIB</p>
                        </div>
                    </div>
                </div>

                <button @click="showReportModal = false" class="w-full bg-surface border border-outline text-on-surface font-bold py-4 rounded-xl hover:bg-surface-variant transition-colors mt-2 md:hidden">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
