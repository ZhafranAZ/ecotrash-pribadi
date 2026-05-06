@extends('layouts.warga')

@section('title', 'Beranda')



@section('header')
<div class="flex items-center gap-3">
    <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold shadow-sm">
        B
    </div>
    <div class="flex flex-col">
        <span class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Selamat datang,</span>
        <span class="text-sm font-bold text-on-surface truncate max-w-[150px]">Budi Santoso</span>
    </div>
</div>
<div class="relative" x-data="{ showNotif: false }" @click.away="showNotif = false">
    <button @click="showNotif = !showNotif" class="relative p-2 text-on-surface-variant hover:bg-surface-variant rounded-full transition-colors">
        <span class="material-symbols-outlined">notifications</span>
        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
    </button>
    
    <!-- Notification Dropdown -->
    <div x-show="showNotif" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-outline overflow-hidden z-[100]" style="display:none;">
        <div class="p-4 border-b border-outline flex justify-between items-center bg-surface">
            <h3 class="font-bold text-on-surface">Notifikasi</h3>
            <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded-md">2 Baru</span>
        </div>
        <div class="max-h-80 overflow-y-auto">
            <div class="p-4 border-b border-outline hover:bg-surface transition-colors cursor-pointer opacity-100">
                <p class="font-bold text-sm text-on-surface">Pesanan Selesai!</p>
                <p class="text-xs text-on-surface-variant mt-1 line-clamp-2">Pesanan #ORD-001 telah selesai. Koin sebesar 150 telah ditambahkan ke saldo Anda.</p>
                <p class="text-[10px] text-on-surface-variant mt-2 font-medium">Baru saja</p>
            </div>
            <div class="p-4 border-b border-outline hover:bg-surface transition-colors cursor-pointer opacity-100">
                <p class="font-bold text-sm text-on-surface">Laporan Diterima</p>
                <p class="text-xs text-on-surface-variant mt-1 line-clamp-2">Laporan sampah liar di Lahan Kosong Blok C sedang diproses oleh admin.</p>
                <p class="text-[10px] text-on-surface-variant mt-2 font-medium">2 jam yang lalu</p>
            </div>
            <div class="p-4 hover:bg-surface transition-colors cursor-pointer opacity-60">
                <p class="font-bold text-sm text-on-surface">Selamat Datang di EcoTrash</p>
                <p class="text-xs text-on-surface-variant mt-1 line-clamp-2">Lengkapi profil Anda dan mulai bantu ciptakan lingkungan yang lebih bersih.</p>
                <p class="text-[10px] text-on-surface-variant mt-2 font-medium">1 hari yang lalu</p>
            </div>
        </div>
        <div class="p-3 border-t border-outline text-center bg-surface">
            <a href="#" class="text-sm font-bold text-primary hover:underline">Tandai semua dibaca</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="p-4 md:p-0 space-y-6 md:space-y-0 md:grid md:grid-cols-12 md:gap-8" x-data="{ hasActiveOrder: true, hasSelisihOrder: true, hasGagalPickupOrder: true, showHistory: false, showTrackingModal: false, showSelisihModal: false, isPayingSelisih: false, paySelisih() { this.isPayingSelisih = true; setTimeout(() => { this.isPayingSelisih = false; this.showSelisihModal = false; this.hasSelisihOrder = false; showToast('Pembayaran berhasil. Jadwal diundur ke hari kerja berikutnya.', 'success'); }, 2000); } }">

    <!-- Left Column (Desktop) -->
    <div class="md:col-span-8 space-y-6 md:space-y-8">
        
        <!-- Banner Notifikasi: Gagal Pickup (Pagar Tertutup) -->
        <template x-if="hasGagalPickupOrder">
            <div class="bg-red-50 border border-red-200 rounded-3xl p-5 flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                    <span class="material-symbols-outlined">door_front</span>
                </div>
                <div>
                    <h3 class="font-bold text-red-800 text-sm md:text-base">Gagal Pickup: Pagar Tertutup</h3>
                    <p class="text-xs md:text-sm text-red-700 mt-1">Petugas tidak dapat mengambil sampah Anda karena pagar tertutup. Jadwal pengangkutan Anda dialihkan ke hari kerja berikutnya.</p>
                    <button @click="hasGagalPickupOrder = false" class="mt-3 text-xs font-bold text-red-600 bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg transition-colors">Tutup Notifikasi</button>
                </div>
            </div>
        </template>

        <!-- Banner Notifikasi: Selisih Pembayaran -->
        <template x-if="hasSelisihOrder">
            <div class="bg-amber-50 border border-amber-200 rounded-3xl p-5 flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                    <span class="material-symbols-outlined">receipt_long</span>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-amber-900 text-sm md:text-base">Pembayaran Tambahan Diperlukan</h3>
                    <p class="text-xs md:text-sm text-amber-800 mt-1">Petugas melaporkan ukuran sampah aktual lebih besar dari pesanan. Mohon lakukan pembayaran selisih harga sebesar <b>Rp10.000</b>.</p>
                    <p class="text-[10px] text-amber-700 mt-1 font-medium">*Setelah pembayaran, jadwal akan diatur ulang ke hari kerja berikutnya.</p>
                    <button @click="showSelisihModal = true" class="mt-3 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 px-4 py-2 rounded-xl transition-colors shadow-sm">Bayar Sekarang</button>
                </div>
            </div>
        </template>

        <!-- Coin Balance Card -->
        <div class="bg-gradient-to-br from-amber-400 to-amber-500 rounded-3xl p-6 md:p-8 text-white shadow-xl shadow-amber-500/20 relative overflow-hidden transition-transform hover:scale-[1.01] duration-300">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-amber-50 text-sm font-bold mb-1 opacity-90">Saldo Koin Eco</p>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[36px] md:text-[48px] text-amber-100" style="font-variation-settings: 'FILL' 1;">generating_tokens</span>
                        <span class="text-4xl md:text-5xl font-black tracking-tight">450</span>
                    </div>
                </div>
                <button @click="showHistory = true" class="bg-white/20 hover:bg-white/30 backdrop-blur-md transition-colors text-white text-xs md:text-sm font-bold px-4 py-2.5 md:px-6 md:py-3 rounded-xl md:rounded-2xl flex items-center gap-1 shadow-sm">
                    Riwayat <span class="material-symbols-outlined text-[16px] md:text-[20px]">chevron_right</span>
                </button>
            </div>
            <!-- Decorative circles -->
            <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -left-4 -top-4 w-20 h-20 bg-white/20 rounded-full blur-xl"></div>
        </div>

        <!-- Desktop Only: Active Tracker moved up -->
        <template x-if="hasActiveOrder">
            <div @click="showTrackingModal = true" class="hidden md:flex bg-primary/5 border border-primary/20 rounded-3xl p-6 items-center justify-between hover:border-primary/40 transition-colors cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary/20 flex items-center justify-center text-primary shrink-0 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[28px] animate-bounce">local_shipping</span>
                    </div>
                    <div>
                        <p class="text-base font-bold text-primary">Pesanan Sedang Diproses</p>
                        <p class="text-sm text-primary/80 mt-0.5 font-medium">Petugas sedang menuju lokasi Anda (12 Mei 2026)</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-primary text-[32px] group-hover:translate-x-1 transition-transform">chevron_right</span>
            </div>
        </template>


    </div>

    <!-- Right Column (Desktop) -->
    <div class="md:col-span-4 space-y-6 md:space-y-8">
        
        <!-- Mobile Only: Active Tracker -->
        <template x-if="hasActiveOrder">
            <div @click="showTrackingModal = true" class="md:hidden bg-primary/10 border border-primary/20 rounded-2xl p-4 flex items-center justify-between cursor-pointer active:bg-primary/20 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[20px] animate-pulse">local_shipping</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-primary">Pesanan Diproses</p>
                        <p class="text-xs text-primary/80 mt-0.5">Petugas menuju lokasi</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-primary">chevron_right</span>
            </div>
        </template>

        <!-- Quick Actions -->
        <div>
            <h3 class="text-sm md:text-base font-bold text-on-surface mb-3 px-1 md:mb-4">Mau apa hari ini?</h3>
            <div class="grid grid-cols-2 md:grid-cols-1 gap-4 md:gap-5">
                <a href="{{ route('warga.pesan.create') }}" class="group bg-white border border-outline rounded-3xl p-5 md:p-6 flex flex-col md:flex-row items-center md:justify-start justify-center gap-3 md:gap-5 shadow-sm hover:border-primary hover:shadow-xl hover:shadow-primary/10 transition-all active:scale-95 md:hover:-translate-y-1">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[32px] md:text-[40px]">delete_sweep</span>
                    </div>
                    <div class="text-center md:text-left">
                        <span class="text-sm md:text-lg font-bold text-on-surface block leading-tight">Pesan<br class="md:hidden"> Pengangkutan</span>
                        <span class="hidden md:block text-xs text-on-surface-variant mt-1">Jemput sampah dari rumah.</span>
                    </div>
                </a>
                
                <a href="{{ route('warga.lapor.create') }}" class="group bg-white border border-outline rounded-3xl p-5 md:p-6 flex flex-col md:flex-row items-center md:justify-start justify-center gap-3 md:gap-5 shadow-sm hover:border-orange-500 hover:shadow-xl hover:shadow-orange-500/10 transition-all active:scale-95 md:hover:-translate-y-1">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[32px] md:text-[40px]">add_a_photo</span>
                    </div>
                    <div class="text-center md:text-left">
                        <span class="text-sm md:text-lg font-bold text-on-surface block leading-tight">Lapor<br class="md:hidden"> Sampah Liar</span>
                        <span class="hidden md:block text-xs text-on-surface-variant mt-1">Foto titik tumpukan liar.</span>
                    </div>
                </a>
            </div>
        </div>
        
    </div>

    <!-- Koin History Modal -->
    <div x-show="showHistory" x-transition.opacity class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showHistory = false">
        <div x-show="showHistory" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden relative">
            
            <div class="p-5 border-b border-outline flex justify-between items-center bg-surface">
                <h3 class="font-black text-lg text-on-surface">Riwayat Koin Eco</h3>
                <button @click="showHistory = false" class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-red-100 hover:text-red-600 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            
            <div class="max-h-[60vh] overflow-y-auto">
                <div class="p-4 border-b border-outline flex items-center gap-4 hover:bg-surface-variant transition-colors">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface">Pesanan Selesai #ORD-001</p>
                        <p class="text-xs text-on-surface-variant">10 Mei 2026</p>
                    </div>
                    <span class="font-black text-green-600">+150</span>
                </div>
                
                <div class="p-4 border-b border-outline flex items-center gap-4 hover:bg-surface-variant transition-colors">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">remove</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface">Potongan Pesanan #ORD-002</p>
                        <p class="text-xs text-on-surface-variant">08 Mei 2026</p>
                    </div>
                    <span class="font-black text-red-600">-50</span>
                </div>

                <div class="p-4 border-b border-outline flex items-center gap-4 hover:bg-surface-variant transition-colors">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface">Bonus Pendaftaran</p>
                        <p class="text-xs text-on-surface-variant">01 Mei 2026</p>
                    </div>
                    <span class="font-black text-green-600">+350</span>
                </div>
                
                <div class="p-4 border-b border-outline flex items-center gap-4 hover:bg-surface-variant transition-colors">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface">Laporan Disetujui</p>
                        <p class="text-xs text-on-surface-variant">28 April 2026</p>
                    </div>
                    <span class="font-black text-green-600">+50</span>
                </div>
                
                <div class="p-4 border-b border-outline flex items-center gap-4 hover:bg-surface-variant transition-colors">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">remove</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface">Potongan Pesanan #ORD-003</p>
                        <p class="text-xs text-on-surface-variant">25 April 2026</p>
                    </div>
                    <span class="font-black text-red-600">-100</span>
                </div>
                
                <div class="p-4 border-b border-outline flex items-center gap-4 hover:bg-surface-variant transition-colors">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface">Pesanan Selesai #ORD-003</p>
                        <p class="text-xs text-on-surface-variant">26 April 2026</p>
                    </div>
                    <span class="font-black text-green-600">+100</span>
                </div>
                
                <div class="p-4 border-b border-outline flex items-center gap-4 hover:bg-surface-variant transition-colors">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface">Bonus Membaca Edukasi</p>
                        <p class="text-xs text-on-surface-variant">20 April 2026</p>
                    </div>
                    <span class="font-black text-green-600">+10</span>
                </div>
                
                <div class="p-4 flex items-center gap-4 hover:bg-surface-variant transition-colors">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm text-on-surface">Bonus Pendaftaran Awal</p>
                        <p class="text-xs text-on-surface-variant">15 April 2026</p>
                    </div>
                    <span class="font-black text-green-600">+50</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tracking Modal -->
    <div x-show="showTrackingModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showTrackingModal = false">
        <div x-show="showTrackingModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden relative">
            
            <div class="p-5 border-b border-outline flex justify-between items-center bg-surface">
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
    </div>

    <!-- Selisih Payment Modal -->
    <div x-show="showSelisihModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showSelisihModal = false">
        <div x-show="showSelisihModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative p-6 space-y-6 text-center">
            
            <h3 class="font-black text-xl text-on-surface">Pembayaran Selisih</h3>
            <p class="text-sm text-on-surface-variant">Scan QR Code di bawah ini untuk membayar tagihan selisih ukuran pesanan.</p>
            
            <div class="bg-white p-4 rounded-3xl border border-outline shadow-sm inline-block mx-auto relative overflow-hidden">
                <img src="{{ asset('images/mock_qr.png') }}" alt="QRIS Mockup" class="w-48 h-48 md:w-56 md:h-56 object-cover rounded-xl" :class="isPayingSelisih ? 'opacity-50 blur-sm' : ''" onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=SelisihPayment';">
                
                <div x-show="isPayingSelisih" class="absolute inset-0 flex flex-col items-center justify-center">
                    <div class="w-10 h-10 border-4 border-amber-500 border-t-transparent rounded-full animate-spin mb-2"></div>
                    <span class="text-sm font-bold text-amber-500">Memverifikasi...</span>
                </div>
            </div>

            <div class="bg-surface-variant p-4 rounded-2xl flex justify-between items-center text-left">
                <div>
                    <p class="text-xs font-bold text-on-surface-variant mb-1">Total Bayar</p>
                    <p class="text-lg font-black text-primary">Rp10.000</p>
                </div>
                <span class="text-xs font-bold bg-white px-2 py-1 rounded shadow-sm">EcoTrash Pay</span>
            </div>

            <button @click="paySelisih()" :disabled="isPayingSelisih" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 active:scale-95 transition-all flex items-center justify-center gap-2">
                <span x-show="!isPayingSelisih" class="material-symbols-outlined">qr_code_scanner</span>
                <span x-text="isPayingSelisih ? 'Memproses...' : 'Cek Status Pembayaran'"></span>
            </button>
            <button @click="showSelisihModal = false" x-show="!isPayingSelisih" class="w-full text-sm font-bold text-on-surface-variant py-2 hover:text-on-surface transition-colors">Nanti Saja</button>
        </div>
    </div>

</div>
@endsection
