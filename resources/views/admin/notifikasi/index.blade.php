@extends('layouts.admin')

@section('title', 'Semua Notifikasi')
@section('subtitle', 'Pantau aktivitas terbaru dan pemberitahuan sistem.')

@section('content')
<div x-data="{ activeTab: 'semua' }">
    <div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden flex flex-col">
        <!-- Header & Tabs -->
        <div class="p-4 border-b border-outline flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex p-1 bg-surface-dim rounded-lg w-fit">
                <button @click="activeTab = 'semua'" :class="activeTab === 'semua' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant'" class="px-4 py-1.5 rounded-md text-sm transition-all">Semua</button>
                <button @click="activeTab = 'unread'" :class="activeTab === 'unread' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant'" class="px-4 py-1.5 rounded-md text-sm transition-all flex items-center gap-2">
                    Belum Dibaca
                    <span class="inline-flex items-center justify-center w-5 h-5 bg-red-500 text-white text-[10px] rounded-full">2</span>
                </button>
                <button @click="activeTab = 'penting'" :class="activeTab === 'penting' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant'" class="px-4 py-1.5 rounded-md text-sm transition-all">Penting</button>
            </div>
            <button @click="$dispatch('show-toast', { message: '✅ Semua notifikasi ditandai telah dibaca', type: 'success' })" class="text-sm text-primary font-bold hover:bg-primary/5 px-3 py-2 rounded-lg transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">done_all</span> Tandai Semua Dibaca
            </button>
        </div>

        <!-- Notification List -->
        <div class="divide-y divide-outline">
            <!-- Notif 1 -->
            <div class="p-4 flex items-start gap-4 hover:bg-surface-dim transition-colors bg-primary/5 group">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                    <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-sm font-bold text-on-surface">Pesanan Penjemputan Baru</h4>
                        <span class="text-xs text-on-surface-variant whitespace-nowrap">2 menit lalu</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">Budi Santoso (Komplek Bunga Asri) baru saja membuat pesanan penjemputan sampah rutin.</p>
                    <div class="flex items-center gap-3 mt-3">
                        <a href="{{ route('admin.operasional.index') }}" class="text-xs font-bold text-primary hover:underline">Lihat Detail</a>
                        <button class="text-xs font-bold text-on-surface-variant hover:text-on-surface">Sembunyikan</button>
                    </div>
                </div>
                <div class="w-2 h-2 bg-primary rounded-full mt-1.5 shrink-0"></div>
            </div>

            <!-- Notif 2 -->
            <div class="p-4 flex items-start gap-4 hover:bg-surface-dim transition-colors bg-primary/5 group">
                <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600 shrink-0">
                    <span class="material-symbols-outlined text-[20px]">report</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-sm font-bold text-on-surface">Laporan Sampah Liar Masuk</h4>
                        <span class="text-xs text-on-surface-variant whitespace-nowrap">15 menit lalu</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">Siti Aminah melaporkan tumpukan sampah liar di area Lahan Blok C. Segera verifikasi!</p>
                    <div class="flex items-center gap-3 mt-3">
                        <a href="{{ route('admin.laporan.index') }}" class="text-xs font-bold text-primary hover:underline">Verifikasi Sekarang</a>
                        <button class="text-xs font-bold text-on-surface-variant hover:text-on-surface">Sembunyikan</button>
                    </div>
                </div>
                <div class="w-2 h-2 bg-primary rounded-full mt-1.5 shrink-0"></div>
            </div>

            <!-- Notif 3 -->
            <div class="p-4 flex items-start gap-4 hover:bg-surface-dim transition-colors group">
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 shrink-0">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-sm font-bold text-on-surface">Laporan Tugas Petugas</h4>
                        <span class="text-xs text-on-surface-variant whitespace-nowrap">1 jam lalu</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">Jajang Suryana telah menyelesaikan seluruh penjemputan di Komplek Bunga Asri (12 resi).</p>
                    <div class="flex items-center gap-3 mt-3">
                        <a href="{{ route('admin.operasional.index') }}" class="text-xs font-bold text-primary hover:underline">Cek Log</a>
                    </div>
                </div>
            </div>

            <!-- Notif 4 -->
            <div class="p-4 flex items-start gap-4 hover:bg-surface-dim transition-colors group">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 shrink-0">
                    <span class="material-symbols-outlined text-[20px]">warning</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-sm font-bold text-on-surface">Peringatan: Petugas Berhalangan</h4>
                        <span class="text-xs text-on-surface-variant whitespace-nowrap">3 jam lalu</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">Asep Sunandar melaporkan berhalangan hadir. Area Komplek Cemara Indah belum tercover.</p>
                    <div class="flex items-center gap-3 mt-3">
                        <a href="{{ route('admin.operasional.index') }}" class="text-xs font-bold text-red-600 hover:underline">Tugaskan Pengganti</a>
                    </div>
                </div>
            </div>

            <!-- Notif 5 -->
            <div class="p-4 flex items-start gap-4 hover:bg-surface-dim transition-colors group">
                <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface-variant shrink-0">
                    <span class="material-symbols-outlined text-[20px]">article</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-sm font-bold text-on-surface">Sistem: Artikel Diterbitkan</h4>
                        <span class="text-xs text-on-surface-variant whitespace-nowrap">Kemarin, 14:00</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">Artikel edukasi "Daur Ulang Plastik yang Benar" telah berhasil diterbitkan ke halaman warga.</p>
                    <div class="flex items-center gap-3 mt-3">
                        <a href="{{ route('admin.edukasi.index') }}" class="text-xs font-bold text-primary hover:underline">Lihat Artikel</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State (Conditional) -->
        <div x-show="activeTab === 'penting'" class="py-20 flex flex-col items-center text-center px-4" style="display: none;">
            <div class="w-20 h-20 rounded-full bg-surface-dim flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[40px] text-on-surface-variant opacity-30">notifications_off</span>
            </div>
            <h4 class="font-bold text-on-surface">Tidak Ada Notifikasi Penting</h4>
            <p class="text-sm text-on-surface-variant mt-1">Hanya pemberitahuan mendesak yang akan muncul di sini.</p>
        </div>

        <!-- Footer / Pagination -->
        <div class="p-4 border-t border-outline flex items-center justify-between bg-surface-dim/30">
            <p class="text-xs text-on-surface-variant">Menampilkan 5 dari 24 notifikasi</p>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 border border-outline rounded-lg text-xs font-bold text-on-surface hover:bg-white transition-colors">Muat Lebih Banyak</button>
            </div>
        </div>
    </div>
</div>
@endsection
