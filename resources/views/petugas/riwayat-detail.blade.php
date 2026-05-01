<x-petugas-layout :hideNav="true">
    <div>
        <!-- Header -->
        <header class="bg-surface border-b border-outline px-4 pt-6 pb-4 sticky top-0 z-30 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.riwayat') }}" class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-outline transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-lg font-black text-on-surface leading-tight">Detail Riwayat</h1>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">{{ $id ?? 'INV-0998' }}</p>
                </div>
            </div>
            <!-- Status Badge -->
            <div class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                Selesai
            </div>
        </header>

        <div class="px-4 py-6 pb-20 space-y-6">
            
            <!-- Information Card -->
            <div class="glass-card rounded-3xl p-5">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">location_on</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-on-surface-variant bg-surface px-2 py-0.5 rounded-md inline-block mb-1 border border-outline">Pesanan Pengangkutan</p>
                        <h2 class="text-lg font-black text-on-surface leading-tight">Kav 4, Blok B</h2>
                        <p class="text-sm font-medium text-on-surface-variant mt-1">Komp. Permata Hijau</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between border-t border-outline pt-4 mt-4">
                    <div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Waktu Selesai</p>
                        <p class="text-sm font-bold text-on-surface mt-0.5">01 Mei 2026, 07:45 WIB</p>
                    </div>
                </div>
            </div>

            <!-- Foto Bukti -->
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Foto Bukti</p>
                <div class="w-full h-48 rounded-3xl overflow-hidden border border-outline shadow-sm relative group">
                    <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?auto=format&fit=crop&w=600&q=80" alt="Foto Bukti" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Catatan Tugas</p>
                <div class="bg-surface border border-outline rounded-2xl p-4 flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">task_alt</span>
                    <div>
                        <p class="text-sm font-bold text-on-surface mb-1">Tugas Diselesaikan</p>
                        <p class="text-xs font-medium text-on-surface-variant leading-relaxed">Semua sampah telah diangkut ke armada dengan aman. Tidak ada kendala lapangan.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-petugas-layout>
