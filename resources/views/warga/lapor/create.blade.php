@extends('layouts.warga')

@section('title', 'Lapor Sampah Liar')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map { height: 100%; width: 100%; z-index: 10; }
    /* Desktop map rounding */
    @media (min-width: 768px) { #map { border-radius: 1.5rem; } }
</style>
@endpush

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('warga.dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-surface-variant text-on-surface-variant transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <span class="font-bold text-on-surface">Lapor Sampah Liar</span>
</div>
@endsection

@section('content')
<div class="h-[calc(100vh-60px)] md:h-[calc(100vh-8rem)] flex flex-col md:flex-row relative md:gap-8" x-data="{
    fotoPreview: null,
    deskripsi: '',
    showForm: window.innerWidth >= 768, /* Auto show form sidebar on desktop */
    handleFile(e) {
        if(e.target.files.length > 0){
            this.fotoPreview = URL.createObjectURL(e.target.files[0]);
        }
    },
    init() {
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) this.showForm = true;
        });
    }
}">
    <!-- Left Area: Map -->
    <div class="flex-1 relative bg-surface-dim md:bg-transparent h-full md:rounded-3xl md:overflow-hidden md:border md:border-outline md:shadow-sm">
        <div id="map"></div>
        <div class="absolute inset-0 pointer-events-none flex items-center justify-center z-20 pb-10">
            <!-- Map Center Marker -->
            <span class="material-symbols-outlined text-[56px] text-red-500 drop-shadow-xl" style="font-variation-settings: 'FILL' 1;">location_on</span>
        </div>
        
        <!-- UI Over Map (Mobile Top, Desktop Bottom Right) -->
        <div class="absolute top-4 left-4 right-4 md:top-auto md:bottom-6 md:left-auto md:right-6 z-20 pointer-events-auto flex flex-col items-end gap-3">
            
            <button @click="map.setView([-6.200000, 106.816666], 15)" class="bg-white/95 backdrop-blur-md text-primary font-bold p-3 rounded-full shadow-lg border border-outline flex items-center justify-center hover:bg-surface-variant transition-colors group tooltip-trigger relative">
                <span class="material-symbols-outlined group-hover:scale-110 transition-transform">my_location</span>
                <span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-surface-variant text-on-surface text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Lokasi Saat Ini</span>
            </button>

            <div class="flex items-start gap-3 bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-lg md:max-w-sm border border-outline w-full transition-transform hover:scale-[1.02]">
                <span class="material-symbols-outlined text-primary text-[28px]">info</span>
                <div>
                    <p class="text-sm md:text-base font-bold text-on-surface">Tentukan Lokasi Akurat</p>
                    <p class="text-xs md:text-sm text-on-surface-variant mt-1">Geser peta untuk memastikan pin berada tepat di lokasi tumpukan sampah liar.</p>
                </div>
            </div>
        </div>

        <!-- FAB Lanjut (Mobile Only) -->
        <div class="fixed bottom-[calc(env(safe-area-inset-bottom)+5.5rem)] left-1/2 -translate-x-1/2 z-[55] pointer-events-auto w-[90%] max-w-sm md:hidden" x-show="!showForm" x-transition>
            <button @click="showForm = true" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-xl shadow-primary/30 hover:bg-primary-dark transition-transform active:scale-95 flex justify-center items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">my_location</span>
                Gunakan Lokasi Ini
            </button>
        </div>
    </div>

    <!-- Right Area: Form Panel (Bottom Sheet on Mobile, Sidebar on Desktop) -->
    <div class="md:relative md:w-96 md:flex-shrink-0 md:h-full z-[100] md:z-10 fixed inset-0 pointer-events-none flex flex-col justify-end md:justify-start"
         :class="{'md:pointer-events-auto': true}">
         
        <!-- Mobile Overlay -->
        <div x-show="showForm" x-transition.opacity class="absolute inset-0 bg-black/50 md:hidden pointer-events-auto backdrop-blur-sm" @click="showForm = false" style="display:none;"></div>
        
        <!-- Form Container -->
        <div x-show="showForm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full md:translate-y-0 md:translate-x-8 md:opacity-0"
             x-transition:enter-end="translate-y-0 md:translate-x-0 md:opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 md:translate-x-0 md:opacity-100"
             x-transition:leave-end="translate-y-full md:translate-y-0 md:translate-x-8 md:opacity-0"
             class="bg-white rounded-t-3xl md:rounded-3xl w-full max-w-md md:max-w-none mx-auto md:w-full pointer-events-auto flex flex-col shadow-[0_-10px_40px_rgba(0,0,0,0.2)] md:shadow-lg md:border md:border-outline relative max-h-[85vh] md:max-h-full md:h-full"
             style="display:none;">
            
            <!-- Mobile pull indicator -->
            <div class="w-12 h-1.5 bg-surface-variant rounded-full mx-auto my-3 md:hidden"></div>
            
            <div class="px-6 pb-6 md:p-8 overflow-y-auto flex-1 flex flex-col gap-6 md:gap-8 pt-2 md:pt-8">
                <div>
                    <h3 class="font-bold text-on-surface text-xl md:text-2xl mb-1">Detail Laporan</h3>
                    <p class="text-sm text-on-surface-variant">Sertakan foto bukti agar petugas mudah menemukan titik sampah.</p>
                </div>

                <!-- Foto Upload -->
                <div>
                    <input type="file" id="foto" accept="image/*" class="hidden" @change="handleFile">
                    
                    <template x-if="!fotoPreview">
                        <label for="foto" class="w-full h-40 md:h-48 border-2 border-dashed border-primary/40 rounded-2xl bg-primary/5 flex flex-col items-center justify-center gap-3 cursor-pointer hover:bg-primary/10 transition-colors text-primary group">
                            <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[28px]">add_a_photo</span>
                            </div>
                            <span class="text-sm font-bold text-primary">Unggah Foto Lokasi</span>
                        </label>
                    </template>

                    <template x-if="fotoPreview">
                        <div class="relative w-full h-48 md:h-56 rounded-2xl overflow-hidden border border-outline shadow-sm group">
                            <img :src="fotoPreview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button @click="fotoPreview = null" class="w-12 h-12 bg-white/20 text-white flex items-center justify-center rounded-full backdrop-blur-md hover:bg-red-500 transition-colors">
                                    <span class="material-symbols-outlined text-[24px]">delete</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-3">Keterangan / Deskripsi</label>
                    <textarea x-model="deskripsi" class="w-full border rounded-xl p-4 md:p-5 text-sm md:text-base focus:ring-2 outline-none transition-all bg-surface hover:bg-white" :class="deskripsi.length > 0 && deskripsi.length < 10 ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : 'border-outline focus:border-primary focus:ring-primary/20'" rows="4" placeholder="Jelaskan secara singkat. Contoh: Sampah dibungkus karung putih di sebelah tiang listrik pinggir jalan..."></textarea>
                    <p x-show="deskripsi.length > 0 && deskripsi.length < 10" class="text-xs text-red-500 mt-2 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span> Deskripsi minimal 10 karakter.</p>
                </div>

                <div class="mt-auto pt-4 pb-4 md:pb-0">
                    <button @click="window.location.href='{{ route('warga.lapor.berhasil') }}'" :disabled="!fotoPreview || deskripsi.length < 10" :class="(fotoPreview && deskripsi.length >= 10) ? 'bg-orange-500 hover:bg-orange-600 shadow-xl shadow-orange-500/30' : 'bg-surface-variant text-on-surface-variant cursor-not-allowed'" class="w-full text-white font-bold py-4 md:py-5 rounded-xl md:rounded-2xl transition-all text-lg flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">send</span> Kirim Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map', {zoomControl: !L.Browser.mobile}).setView([-6.200000, 106.816666], 15);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19
        }).addTo(map);
        
        // Trigger resize calculation after map container might change on desktop load
        setTimeout(() => map.invalidateSize(), 100);
    });
</script>
@endpush
