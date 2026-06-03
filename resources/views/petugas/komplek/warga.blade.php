<x-petugas-layout>
    <!-- Header -->
    <header class="bg-surface border-b border-outline px-4 pt-6 pb-4 sticky top-0 z-30">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('petugas.beranda') }}" class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-outline transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-black text-on-surface leading-tight">{{ $komplek->nama_komplek }}</h1>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tugas Hari Ini</p>
            </div>
        </div>
    </header>

    <div class="px-4 py-6 pb-24 space-y-4">
        
        <!-- Action Button -->
        <div class="mb-2">
            <a href="https://maps.google.com/?q={{ urlencode($komplek->nama_komplek) }}" target="_blank" class="w-full bg-blue-50 border border-blue-200 hover:bg-blue-100 text-blue-700 font-bold py-3.5 px-4 rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2 text-sm">
                <span class="material-symbols-outlined text-[20px]">map</span> Buka di Google Maps
            </a>
        </div>

        <div class="flex items-center justify-between mb-4 px-1">
            <h2 class="text-lg font-black text-on-surface">Daftar Titik Penjemputan</h2>
            <span class="text-xs font-bold text-on-surface-variant">{{ $pesanans->count() }} Titik tersisa</span>
        </div>

        <div class="space-y-4">
            @forelse($pesanans as $pesanan)
            <x-petugas.task-card 
                id="{{ $pesanan->id }}" 
                type="angkut" 
                time="{{ $pesanan->created_at->format('H:i') }}" 
                address="{{ $pesanan->nama_alamat_snapshot }}, {{ $pesanan->blok_nomor_rumah }}"
                :note="$pesanan->catatan_warga"
                kategori="{{ $pesanan->kategori_sampah }}"
                nama_warga="{{ $pesanan->warga->nama }}"
            />
            @empty
            <div class="glass-card rounded-3xl p-8 text-center">
                <div class="w-16 h-16 rounded-full bg-surface-variant flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined text-[32px] text-on-surface-variant">check_circle</span>
                </div>
                <p class="text-sm font-bold text-on-surface">Semua tugas sudah selesai!</p>
                <p class="text-xs text-on-surface-variant mt-1">Tidak ada titik penjemputan yang tersisa.</p>
            </div>
            @endforelse
        </div>
        
    </div>
</x-petugas-layout>
