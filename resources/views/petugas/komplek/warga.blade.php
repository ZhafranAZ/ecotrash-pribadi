<x-petugas-layout>
    <!-- Header -->
    <header class="bg-surface border-b border-outline px-4 pt-6 pb-4 sticky top-0 z-30">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('petugas.beranda') }}" class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-outline transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-black text-on-surface leading-tight">Perumahan Asri Indah</h1>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Kec. Bojongsoang</p>
            </div>
        </div>
    </header>

    <div class="px-4 py-6 pb-24 space-y-4">
        
        <!-- Action Button -->
        <div class="mb-2">
            <a href="https://maps.google.com/?q=Perumahan+Asri+Indah" target="_blank" class="w-full bg-blue-50 border border-blue-200 hover:bg-blue-100 text-blue-700 font-bold py-3.5 px-4 rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2 text-sm">
                <span class="material-symbols-outlined text-[20px]">map</span> Buka di Google Maps
            </a>
        </div>

        <div class="flex items-center justify-between mb-4 px-1">
            <h2 class="text-lg font-black text-on-surface">Daftar Titik Penjemputan</h2>
            <span class="text-xs font-bold text-on-surface-variant">8 Titik tersisa</span>
        </div>

        <div class="space-y-4">
            <x-petugas.task-card 
                id="INV-1001" 
                type="angkut" 
                time="08:00" 
                address="Jl. Merdeka No. 45, Blok C"
                note="Tolong panggil nomor rumah jika pagar dikunci."
            />

            <x-petugas.task-card 
                id="INV-1002" 
                type="angkut" 
                time="08:15" 
                address="Blok A No. 12"
            />

            <x-petugas.task-card 
                id="INV-1003" 
                type="angkut" 
                time="08:30" 
                address="Blok D No. 8"
                note="Ada tambahan 2 kantong kresek di depan."
            />
        </div>
        
    </div>
</x-petugas-layout>
