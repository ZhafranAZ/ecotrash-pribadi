@extends('layouts.warga')

@section('title', 'Beranda')

@push('styles')
    <style>
        @keyframes shimmer {
            0% {
                transform: translateX(-150%) skewX(-20deg);
            }

            50%,
            100% {
                transform: translateX(150%) skewX(-20deg);
            }
        }

        @keyframes wave {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-15deg);
            }

            75% {
                transform: rotate(15deg);
            }
        }

        .animate-wave {
            display: inline-block;
            animation: wave 2.5s ease-in-out infinite;
            transform-origin: 70% 70%;
        }
    </style>
@endpush

@section('header')
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold shadow-sm">
            {{ substr($namaUser, 0, 1) }}
        </div>
        <div class="flex flex-col">
            <span class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Selamat datang,</span>
            <span class="text-sm font-bold text-on-surface truncate max-w-[150px] flex items-center gap-1">{{ $namaUser }}
                <span class="animate-wave text-lg origin-bottom-right inline-block">👋</span></span>
        </div>
    </div>
    <div class="relative" x-data="{ showNotif: false }" @click.away="showNotif = false">
        <button @click="showNotif = !showNotif"
            class="relative p-2 text-on-surface-variant hover:bg-surface-variant rounded-full transition-colors">
            <span class="material-symbols-outlined">notifications</span>
            @if($unreadCount > 0)
            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
            @endif
        </button>

        <!-- Notification Dropdown -->
        <div x-show="showNotif" x-transition
            class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-outline overflow-hidden z-[100]"
            style="display:none;">
            <div class="p-4 border-b border-outline flex justify-between items-center bg-surface">
                <h3 class="font-bold text-on-surface">Notifikasi</h3>
                <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded-md">{{ $unreadCount }} Baru</span>
            </div>
            <div class="max-h-80 overflow-y-auto">
                @forelse($unreadNotifications as $notif)
                    <div class="p-4 border-b border-outline hover:bg-surface transition-colors cursor-pointer {{ $notif->is_read ? 'opacity-60' : 'opacity-100' }}">
                        <p class="font-bold text-sm text-on-surface">{{ $notif->judul }}</p>
                        <p class="text-xs text-on-surface-variant mt-1 line-clamp-2">{{ $notif->pesan }}</p>
                        <p class="text-[10px] text-on-surface-variant mt-2 font-medium">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <p class="text-sm text-on-surface-variant">Belum ada notifikasi.</p>
                    </div>
                @endforelse
            </div>
            <div class="p-3 border-t border-outline text-center bg-surface">
                <form method="POST" action="{{ route('notifikasi.markAllRead') }}">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-primary hover:underline">Tandai semua dibaca</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="p-4 md:p-0 space-y-6 md:space-y-0 md:grid md:grid-cols-12 md:gap-8"
        x-data="{
            hasActiveOrder: {{ $pesananAktif ? 'true' : 'false' }},
            pesananAktifData: @js($pesananAktif ? [
                'id' => $pesananAktif->id,
                'status' => $pesananAktif->status,
                'kategori_sampah' => $pesananAktif->kategori_sampah,
                'tanggal' => $pesananAktif->tanggal_penjemputan ? $pesananAktif->tanggal_penjemputan->translatedFormat('l, d M Y') : '-',
                'total_harga' => $pesananAktif->total_harga_akhir,
                'riwayat' => $pesananAktif->riwayatStatus->map(fn($r) => [
                    'status' => $r->status,
                    'keterangan' => $r->keterangan,
                    'waktu' => $r->created_at ? $r->created_at->translatedFormat('d M Y, H:i') : '-',
                ]),
            ] : null),
            showHistory: false,
            showTrackingModal: false,
            showSelisihModal: false,
            isPayingSelisih: false,
            statusLabel(status) {
                return status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
            },
            paySelisih() {
                this.isPayingSelisih = true;
                setTimeout(() => {
                    document.getElementById('form-bayar-selisih').submit();
                }, 1500);
            }
        }">

        <!-- Left Column (Desktop) -->
        <div class="md:col-span-8 space-y-6 md:space-y-8">

            {{-- Banner Kondisional: Gagal Pickup --}}
            @if($pesananGagalPickup)
                <div class="bg-red-50 border border-red-200 rounded-3xl p-5 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                        <span class="material-symbols-outlined">door_front</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-red-800 text-sm md:text-base">Gagal Pickup: {{ $pesananGagalPickup->alasan_kendala ?? 'Pagar Tertutup' }}</h3>
                        <p class="text-xs md:text-sm text-red-700 mt-1">Petugas tidak dapat mengambil sampah Anda. Jadwal pengangkutan Anda dialihkan ke hari kerja berikutnya.</p>
                    </div>
                </div>
            @endif

            {{-- Banner Kondisional: Pembayaran Tambahan (hold_kapasitas) --}}
            @if($pesananHoldKapasitas)
                @php
                    $ukuranAktual = strtolower($pesananHoldKapasitas->ukuran_aktual_laporan_petugas ?? 'sedang');
                    $hargaAktual = $pengaturan->{'harga_kategori_' . $ukuranAktual} ?? 0;
                    
                    $ukuranAwal = strtolower($pesananHoldKapasitas->kategori_sampah ?? 'kecil');
                    $hargaAwal = $pengaturan->{'harga_kategori_' . $ukuranAwal} ?? 0;
                    
                    $selisihHitung = max(0, $hargaAktual - $hargaAwal);
                @endphp
                <div class="bg-amber-50 border border-amber-200 rounded-3xl p-5 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-amber-900 text-sm md:text-base">Perhatian! Pembayaran Tambahan Diperlukan</h3>
                        <p class="text-xs md:text-sm text-amber-800 mt-1">
                            Kapasitas aktual yang dilaporkan petugas adalah <b>{{ ucfirst($ukuranAktual) }}</b> (Rp{{ number_format($hargaAktual, 0, ',', '.') }}). 
                            Harga pesanan awal Anda: Rp{{ number_format($hargaAwal, 0, ',', '.') }}. 
                            Total selisih yang harus dibayar: <b>Rp{{ number_format($selisihHitung, 0, ',', '.') }}</b>.
                        </p>
                        <button @click="showSelisihModal = true"
                            class="mt-3 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 px-4 py-2 rounded-xl transition-colors shadow-sm">Bayar Sekarang</button>
                    </div>
                </div>
                
                <form id="form-bayar-selisih" action="{{ route('warga.pesanan.bayar_selisih', $pesananHoldKapasitas->id) }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endif

            <!-- Coin Balance Card -->
            <div
                class="bg-gradient-to-br from-amber-400 to-amber-500 rounded-3xl p-6 md:p-8 text-white shadow-xl shadow-amber-500/20 relative overflow-hidden transition-transform hover:scale-[1.01] duration-300 before:absolute before:inset-0 before:-translate-x-full before:bg-gradient-to-r before:from-transparent before:via-white/30 before:to-transparent before:animate-[shimmer_3s_infinite]">
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-amber-50 text-sm font-bold mb-1 opacity-90">Saldo Koin Eco</p>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[36px] md:text-[48px] text-amber-100 animate-pulse"
                                style="font-variation-settings: 'FILL' 1;">generating_tokens</span>
                            <span class="text-4xl md:text-5xl font-black tracking-tight drop-shadow-md">{{ number_format($saldoKoin) }}</span>
                        </div>
                    </div>
                    <button @click="showHistory = true"
                        class="bg-white/20 hover:bg-white/30 backdrop-blur-md transition-colors text-white text-xs md:text-sm font-bold px-4 py-2.5 md:px-6 md:py-3 rounded-xl md:rounded-2xl flex items-center gap-1 shadow-sm active:scale-95">
                        Riwayat <span class="material-symbols-outlined text-[16px] md:text-[20px]">chevron_right</span>
                    </button>
                </div>
                <!-- Decorative circles -->
                <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -left-4 -top-4 w-20 h-20 bg-white/20 rounded-full blur-xl"></div>
            </div>

            <!-- Desktop Only: Active Tracker moved up -->
            <template x-if="hasActiveOrder">
                <div @click="showTrackingModal = true"
                    class="hidden md:flex bg-primary/5 border border-primary/20 rounded-3xl p-6 items-center justify-between hover:border-primary/40 transition-colors cursor-pointer group">
                    <div class="flex items-center gap-4">
                        <div
                            class="relative w-14 h-14 rounded-2xl bg-primary/20 flex items-center justify-center text-primary shrink-0 group-hover:scale-110 transition-transform">
                            <div class="absolute inset-0 rounded-2xl bg-primary/30 animate-ping opacity-75"></div>
                            <span class="material-symbols-outlined text-[28px] relative z-10">local_shipping</span>
                        </div>
                        <div>
                            <p class="text-base font-bold text-primary">Pesanan Sedang Diproses</p>
                            @if($pesananAktif)
                            <p class="text-sm text-primary/80 mt-0.5 font-medium">Petugas sedang menuju lokasi Anda ({{ $pesananAktif->tanggal_penjemputan ? $pesananAktif->tanggal_penjemputan->translatedFormat('d F Y') : '-' }})</p>
                            @endif
                        </div>
                    </div>
                    <span
                        class="material-symbols-outlined text-primary text-[32px] group-hover:translate-x-1 transition-transform">chevron_right</span>
                </div>
            </template>


        </div>

        <!-- Right Column (Desktop) -->
        <div class="md:col-span-4 space-y-6 md:space-y-8">

            <!-- Mobile Only: Active Tracker -->
            <template x-if="hasActiveOrder">
                <div @click="showTrackingModal = true"
                    class="md:hidden bg-primary/10 border border-primary/20 rounded-2xl p-4 flex items-center justify-between cursor-pointer active:bg-primary/20 transition-colors">
                    <div class="flex items-center gap-3">
                        <div
                            class="relative w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                            <div class="absolute inset-0 rounded-full bg-primary/40 animate-ping opacity-75"></div>
                            <span class="material-symbols-outlined text-[20px] relative z-10">local_shipping</span>
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
                <div class="grid grid-cols-2 md:grid-cols-1 gap-x-4 gap-y-10 md:gap-8 pt-8 md:pt-4">
                    <!-- Pesan Pengangkutan Button -->
                    <a href="{{ route('warga.pesan.create') }}"
                        class="group relative overflow-visible bg-gradient-to-br from-primary/10 to-primary/5 border border-primary/20 rounded-[2rem] flex flex-col md:flex-row h-full shadow-sm hover:shadow-2xl hover:shadow-primary/30 hover:border-primary/50 transition-all duration-300 active:scale-95 md:hover:-translate-y-2">
                        <!-- Image Section -->
                        <div
                            class="w-full md:w-2/5 h-24 md:h-full min-h-[100px] md:min-h-[160px] relative shrink-0 flex items-end justify-center rounded-t-[2rem] md:rounded-l-[2rem] md:rounded-tr-none bg-primary/5">
                            <img src="{{ asset('images/pesan_3d.png') }}" alt="Pesan Pengangkutan"
                                class="h-[140%] md:h-[180%] object-contain absolute bottom-0 md:-bottom-12 drop-shadow-2xl group-hover:scale-104 group-hover:-translate-y-1 transition-transform duration-500 z-10 origin-bottom">
                        </div>
                        <!-- Text Section -->
                        <div
                            class="p-5 md:p-8 flex-1 text-center md:text-left flex flex-col justify-start md:justify-center relative z-20">
                            <span
                                class="text-base md:text-2xl font-black text-primary block leading-tight tracking-tight">Pesan<br
                                    class="md:hidden"> Pengangkutan</span>
                            <span class="hidden md:block text-sm text-primary/70 mt-2 font-medium leading-relaxed">Panggil
                                petugas untuk menjemput sampah rumah tangga Anda secara efisien.</span>
                        </div>
                    </a>

                    <!-- Lapor Sampah Liar Button -->
                    <a href="{{ route('warga.lapor.create') }}"
                        class="group relative overflow-visible bg-gradient-to-br from-orange-500/10 to-orange-500/5 border border-orange-500/20 rounded-[2rem] flex flex-col md:flex-row h-full shadow-sm hover:shadow-2xl hover:shadow-orange-500/30 hover:border-orange-500/50 transition-all duration-300 active:scale-95 md:hover:-translate-y-2">
                        <!-- Image Section -->
                        <div
                            class="w-full md:w-2/5 h-24 md:h-full min-h-[100px] md:min-h-[160px] relative shrink-0 flex items-end justify-center rounded-t-[2rem] md:rounded-l-[2rem] md:rounded-tr-none bg-orange-500/5">
                            <img src="{{ asset('images/lapor_3d.png') }}" alt="Lapor Sampah Liar"
                                class="h-[140%] md:h-[180%] object-contain absolute bottom-0 md:-bottom-12 drop-shadow-2xl group-hover:scale-104 group-hover:-translate-y-1 transition-transform duration-500 z-10 origin-bottom">
                        </div>
                        <!-- Text Section -->
                        <div
                            class="p-5 md:p-8 flex-1 text-center md:text-left flex flex-col justify-start md:justify-center relative z-20">
                            <span
                                class="text-base md:text-2xl font-black text-orange-600 block leading-tight tracking-tight">Lapor<br
                                    class="md:hidden"> Sampah Liar</span>
                            <span
                                class="hidden md:block text-sm text-orange-600/70 mt-2 font-medium leading-relaxed">Temukan
                                tumpukan liar? Foto dan laporkan untuk lingkungan yang lebih bersih.</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <!-- Koin History Modal -->
        <div x-show="showHistory" x-transition.opacity
            class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4"
            style="display:none;" @click.self="showHistory = false">
            <div x-show="showHistory" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden relative">

                <div class="p-5 border-b border-outline flex justify-between items-center bg-surface">
                    <h3 class="font-black text-lg text-on-surface">Riwayat Koin Eco</h3>
                    <button @click="showHistory = false"
                        class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-red-100 hover:text-red-600 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>

                <div class="max-h-[60vh] overflow-y-auto">
                    @forelse($riwayatKoin as $koin)
                        <div class="p-4 {{ !$loop->last ? 'border-b border-outline' : '' }} flex items-center gap-4 hover:bg-surface-variant transition-colors">
                            <div class="w-10 h-10 rounded-full {{ $koin->tipe_transaksi === 'masuk' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">{{ $koin->tipe_transaksi === 'masuk' ? 'add' : 'remove' }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-sm text-on-surface">
                                    @if($koin->sumber === 'pesanan') Pesanan {{ $koin->tipe_transaksi === 'masuk' ? 'Selesai' : 'Potongan' }} #{{ $koin->referensi_id }}
                                    @elseif($koin->sumber === 'laporan_liar') Laporan Disetujui
                                    @elseif($koin->sumber === 'sistem') Bonus Sistem
                                    @else Transaksi Koin
                                    @endif
                                </p>
                                <p class="text-xs text-on-surface-variant">{{ $koin->created_at->translatedFormat('d F Y') }}</p>
                            </div>
                            <span class="font-black {{ $koin->tipe_transaksi === 'masuk' ? 'text-green-600' : 'text-red-600' }}">{{ $koin->tipe_transaksi === 'masuk' ? '+' : '-' }}{{ $koin->jumlah }}</span>
                        </div>
                    @empty
                        <div class="p-6 text-center">
                            <p class="text-sm text-on-surface-variant">Belum ada riwayat koin.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Tracking Modal (Dynamic Timeline) -->
        <div x-show="showTrackingModal" x-transition.opacity
            class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4"
            style="display:none;" @click.self="showTrackingModal = false">
            <div x-show="showTrackingModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden relative max-h-[90vh] flex flex-col">

                <div class="p-5 border-b border-outline flex justify-between items-center bg-surface shrink-0">
                    <h3 class="font-black text-lg text-on-surface">Detail Lacak Pesanan</h3>
                    <button @click="showTrackingModal = false"
                        class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-red-100 hover:text-red-600 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto">
                    <template x-if="pesananAktifData">
                        <div>
                            <!-- Pesanan Info Card -->
                            <div class="flex items-center gap-4 mb-6 p-4 bg-primary/5 border border-primary/20 rounded-2xl">
                                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined">local_shipping</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-on-surface text-sm truncate" x-text="'Pesanan #' + pesananAktifData.id"></p>
                                    <p class="text-xs text-on-surface-variant" x-text="pesananAktifData.tanggal"></p>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-xs text-on-surface-variant">Total</p>
                                    <p class="font-black text-primary" x-text="'Rp' + Number(pesananAktifData.total_harga).toLocaleString('id-ID')"></p>
                                </div>
                            </div>

                            <!-- Dynamic Timeline from riwayatStatus -->
                            <div class="space-y-0 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-outline before:to-transparent">
                                <template x-for="(step, index) in pesananAktifData.riwayat" :key="index">
                                    <div class="relative flex items-start gap-4 pb-6">
                                        <!-- Timeline dot -->
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white shrink-0 shadow-sm z-10"
                                             :class="index === pesananAktifData.riwayat.length - 1 ? 'bg-primary text-white' : 'bg-green-500 text-white'">
                                            <span class="material-symbols-outlined text-[16px]" x-text="index === pesananAktifData.riwayat.length - 1 ? (step.status === 'selesai' ? 'check_circle' : 'radio_button_checked') : 'check'"></span>
                                        </div>
                                        <!-- Timeline content -->
                                        <div class="flex-1 p-4 rounded-xl border shadow-sm"
                                             :class="index === pesananAktifData.riwayat.length - 1 ? 'border-primary bg-primary/5' : 'border-outline bg-surface'">
                                            <h4 class="font-bold text-sm" :class="index === pesananAktifData.riwayat.length - 1 ? 'text-primary' : 'text-on-surface'" x-text="statusLabel(step.status)"></h4>
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
        </div>

        {{-- Selisih Payment Modal (hanya render jika ada pesanan hold_kapasitas) --}}
        @if($pesananHoldKapasitas)
        <div x-show="showSelisihModal" x-transition.opacity
            class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4"
            style="display:none;" @click.self="showSelisihModal = false">
            <div x-show="showSelisihModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative p-6 space-y-6 text-center">

                <h3 class="font-black text-xl text-on-surface">Pembayaran Selisih</h3>
                <p class="text-sm text-on-surface-variant">Scan QR Code di bawah ini untuk membayar tagihan selisih ukuran
                    pesanan.</p>

                <div
                    class="bg-white p-4 rounded-3xl border border-outline shadow-sm inline-block mx-auto relative overflow-hidden">
                    <img src="{{ asset('images/mock_qr.png') }}" alt="QRIS Mockup"
                        class="w-48 h-48 md:w-56 md:h-56 object-cover rounded-xl"
                        :class="isPayingSelisih ? 'opacity-50 blur-sm' : ''"
                        onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=SelisihPayment';">

                    <div x-show="isPayingSelisih" class="absolute inset-0 flex flex-col items-center justify-center">
                        <div
                            class="w-10 h-10 border-4 border-amber-500 border-t-transparent rounded-full animate-spin mb-2">
                        </div>
                        <span class="text-sm font-bold text-amber-500">Memverifikasi...</span>
                    </div>
                </div>

                <div class="bg-surface-variant p-4 rounded-2xl flex justify-between items-center text-left">
                    <div>
                        <p class="text-xs font-bold text-on-surface-variant mb-1">Total Bayar</p>
                        <p class="text-lg font-black text-primary">Rp{{ number_format($selisihHitung, 0, ',', '.') }}</p>
                    </div>
                    <span class="text-xs font-bold bg-white px-2 py-1 rounded shadow-sm">EcoTrash Pay</span>
                </div>

                <button @click="paySelisih()" :disabled="isPayingSelisih"
                    class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span x-show="!isPayingSelisih" class="material-symbols-outlined">qr_code_scanner</span>
                    <span x-text="isPayingSelisih ? 'Memproses...' : 'Cek Status Pembayaran'"></span>
                </button>
                <button @click="showSelisihModal = false" x-show="!isPayingSelisih"
                    class="w-full text-sm font-bold text-on-surface-variant py-2 hover:text-on-surface transition-colors">Nanti
                    Saja</button>
            </div>
        </div>
        @endif

    </div>
@endsection