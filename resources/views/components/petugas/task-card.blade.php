@props(['id', 'type', 'time', 'address', 'note' => null])

<a href="{{ route('petugas.tugas.detail', ['type' => $type, 'id' => $id]) }}" class="block glass-card rounded-3xl p-5 active:scale-[0.98] transition-transform">
    <div class="flex items-start gap-4">
        <!-- Time Marker -->
        <div class="flex flex-col items-center shrink-0">
            <span class="text-sm font-black text-on-surface">{{ $time }}</span>
            <div class="w-1.5 h-1.5 rounded-full bg-primary my-1"></div>
            <div class="w-px h-12 bg-outline"></div>
        </div>

        <!-- Card Content -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-md uppercase tracking-wider">
                    Angkut Sampah
                </span>
                <span class="text-xs font-bold text-on-surface-variant">{{ $id }}</span>
            </div>
            
            <h3 class="text-base font-bold text-on-surface mb-1 truncate">{{ $address }}</h3>
            
            @if($note)
            <div class="flex items-start gap-1 text-orange-500 mb-3">
                <span class="material-symbols-outlined text-[14px] shrink-0 mt-0.5">info</span>
                <p class="text-xs font-medium leading-tight line-clamp-2">{{ $note }}</p>
            </div>
            @else
            <div class="mb-3"></div>
            @endif

            <!-- Action Button -->
            <button class="w-full bg-surface-variant hover:bg-primary hover:text-white border border-outline text-on-surface font-bold text-sm py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">directions_car</span>
                Mulai Jalan
            </button>
        </div>
    </div>
</a>
