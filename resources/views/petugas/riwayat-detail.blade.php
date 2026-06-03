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
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">
                        @if($type === 'pesanan')
                            {{ $item->id }}
                        @else
                            LAP-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                        @endif
                    </p>
                </div>
            </div>
            <!-- Status Badge -->
            @php
                $statusConfig = match($item->status) {
                    'selesai' => ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'icon' => 'check_circle', 'label' => 'Selesai'],
                    'hold_kapasitas' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'icon' => 'warning', 'label' => 'Hold Kapasitas'],
                    'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'icon' => 'cancel', 'label' => 'Ditolak'],
                    default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'info', 'label' => ucfirst($item->status)],
                };
            @endphp
            <div class="px-3 py-1 rounded-full {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} text-xs font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">{{ $statusConfig['icon'] }}</span>
                {{ $statusConfig['label'] }}
            </div>
        </header>

        <div class="px-4 py-6 pb-20 space-y-6">
            
            <!-- Information Card -->
            <div class="glass-card rounded-3xl p-5">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">{{ $type === 'pesanan' ? 'local_shipping' : 'location_on' }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-on-surface-variant bg-surface px-2 py-0.5 rounded-md inline-block mb-1 border border-outline">
                            {{ $type === 'pesanan' ? 'Pesanan Pengangkutan' : 'Laporan Sampah Liar' }}
                        </p>
                        <h2 class="text-lg font-black text-on-surface leading-tight">
                            @if($type === 'pesanan')
                                {{ $item->blok_nomor_rumah ?? $item->nama_alamat_snapshot ?? '-' }}
                            @else
                                {{ $item->alamat_lokasi ?? ($item->lat && $item->lng ? $item->lat . ', ' . $item->lng : 'Lokasi tidak tersedia') }}
                            @endif
                        </h2>
                        <p class="text-sm font-medium text-on-surface-variant mt-1">{{ $item->komplek->nama ?? '-' }}</p>
                    </div>
                </div>

                <!-- Detail Info -->
                <div class="space-y-3 border-t border-outline pt-4 mt-4">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Pelapor / Pemesan</p>
                        <p class="text-sm font-bold text-on-surface">{{ $item->warga->nama ?? '-' }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">
                            {{ $item->status === 'selesai' ? 'Waktu Selesai' : 'Terakhir Diupdate' }}
                        </p>
                        <p class="text-sm font-bold text-on-surface">{{ $item->updated_at->translatedFormat('d M Y, H:i') }} WIB</p>
                    </div>
                    @if($type === 'pesanan')
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Kategori Sampah</p>
                            <p class="text-sm font-bold text-on-surface capitalize">{{ $item->kategori_sampah ?? '-' }}</p>
                        </div>
                        @if($item->koin_didapat > 0)
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Koin Didapat</p>
                            <p class="text-sm font-bold text-primary">+{{ $item->koin_didapat }} koin</p>
                        </div>
                        @endif
                    @else
                        @if($item->koin_reward > 0)
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Koin Reward</p>
                            <p class="text-sm font-bold text-primary">+{{ $item->koin_reward }} koin</p>
                        </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Foto Bukti -->
            @php
                $fotoBukti = $type === 'pesanan' ? $item->foto_bukti_selesai : $item->foto_bukti_selesai_petugas;
            @endphp
            @if($fotoBukti)
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Foto Bukti</p>
                <div class="w-full h-48 rounded-3xl overflow-hidden border border-outline shadow-sm relative group">
                    <img src="{{ asset('storage/' . $fotoBukti) }}" alt="Foto Bukti" class="w-full h-full object-cover">
                </div>
            </div>
            @endif

            <!-- Foto Kendala (jika ada) -->
            @if($type === 'pesanan' && $item->foto_kendala)
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Foto Kendala</p>
                <div class="w-full h-48 rounded-3xl overflow-hidden border border-outline shadow-sm relative group">
                    <img src="{{ asset('storage/' . $item->foto_kendala) }}" alt="Foto Kendala" class="w-full h-full object-cover">
                </div>
            </div>
            @endif

            <!-- Catatan / Kendala -->
            @if($type === 'pesanan' && $item->alasan_kendala)
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Catatan Kendala</p>
                <div class="bg-surface border border-outline rounded-2xl p-4 flex items-start gap-3">
                    <span class="material-symbols-outlined text-orange-500 text-[20px] shrink-0 mt-0.5">warning</span>
                    <div>
                        <p class="text-sm font-bold text-on-surface mb-1">Kendala Ditemukan</p>
                        <p class="text-xs font-medium text-on-surface-variant leading-relaxed">{{ $item->alasan_kendala }}</p>
                    </div>
                </div>
            </div>
            @elseif($type === 'laporan' && $item->deskripsi)
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Deskripsi Laporan</p>
                <div class="bg-surface border border-outline rounded-2xl p-4 flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">description</span>
                    <div>
                        <p class="text-sm font-bold text-on-surface mb-1">Deskripsi</p>
                        <p class="text-xs font-medium text-on-surface-variant leading-relaxed">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Riwayat Status (pesanan only) -->
            @if($type === 'pesanan' && $item->riwayatStatus && $item->riwayatStatus->count() > 0)
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Riwayat Status</p>
                <div class="space-y-3">
                    @foreach($item->riwayatStatus as $riwayat)
                    <div class="bg-surface border border-outline rounded-2xl p-4 flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">task_alt</span>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-bold text-on-surface capitalize">{{ str_replace('_', ' ', $riwayat->status) }}</p>
                                <p class="text-[10px] text-on-surface-variant">{{ $riwayat->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}</p>
                            </div>
                            <p class="text-xs font-medium text-on-surface-variant leading-relaxed">{{ $riwayat->keterangan }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @elseif($item->status === 'selesai')
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Catatan Tugas</p>
                <div class="bg-surface border border-outline rounded-2xl p-4 flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">task_alt</span>
                    <div>
                        <p class="text-sm font-bold text-on-surface mb-1">Tugas Diselesaikan</p>
                        <p class="text-xs font-medium text-on-surface-variant leading-relaxed">Tugas telah diselesaikan dengan baik oleh petugas.</p>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-petugas-layout>
