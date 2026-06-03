<x-petugas-layout :hideNav="true">
    <div x-data="{ 
        laporanId: {{ $laporan->id }},
        showKendala: false,
        kendalaType: '',
        isDone: false,
        showConfirmSelesai: false,
        showModalTunda: false,
        imagePreview: null,
        fotoFile: null,
        alasanUtama: '',
        catatanTambahan: '',
        isLoading: false,
        errorMessage: '',
        justDelayed: false,
        status: '{{ $laporan->status }}' // 'disetujui' -> 'sedang_dibersihkan' -> 'selesai' / 'ditunda'
    }">
        
        <!-- MAIN CONTENT (Tampil jika belum selesai atau ditunda baru saja) -->
        <div x-show="status !== 'selesai' && (status !== 'ditunda' || !justDelayed)">
        <!-- Header -->
        <header class="bg-surface border-b border-outline px-4 pt-6 pb-4 sticky top-0 z-30 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.beranda') }}" class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-outline transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-lg font-black text-on-surface leading-tight">Laporan Liar</h1>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">#LAP-{{ str_pad($laporan->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </header>

        <div class="px-4 py-6 pb-40 space-y-6">
            
            <!-- Map Card -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="h-48 bg-surface-variant relative z-10">
                    <!-- Leaflet Map Container -->
                    <div id="map" class="w-full h-full"></div>
                </div>
                <div class="p-5">
                    <div class="mb-4">
                        <div class="mb-3">
                            <h2 class="text-base font-black text-on-surface leading-tight mb-1">{{ $laporan->alamat_lokasi ?? 'Lokasi Laporan' }}</h2>
                            <p class="text-xs font-bold text-on-surface-variant">{{ $laporan->komplek->nama_komplek ?? 'Lokasi tidak terdaftar' }}</p>
                        </div>
                        <a href="https://maps.google.com/?q={{ $laporan->lat }},{{ $laporan->lng }}" target="_blank" class="w-full bg-blue-50 border border-blue-200 hover:bg-blue-100 text-blue-700 font-bold py-3 px-4 rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-[20px]">map</span> Buka di Google Maps
                        </a>
                    </div>
                    <div class="bg-surface border border-outline rounded-2xl p-4">
                        <p class="text-xs font-medium text-on-surface-variant leading-relaxed">"{{ $laporan->deskripsi }}"</p>
                    </div>
                </div>
            </div>

            <!-- Info Pelapor -->
            <div class="glass-card rounded-3xl p-5">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-1">Info Pelapor</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-surface">{{ $laporan->warga->nama }}</p>
                        <p class="text-[10px] text-on-surface-variant">Dilaporkan {{ $laporan->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                </div>
                @if($laporan->koin_reward > 0)
                <div class="mt-3 flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded-xl p-3">
                    <span class="material-symbols-outlined text-yellow-600 text-[18px]">monetization_on</span>
                    <p class="text-xs font-bold text-yellow-700">Reward warga: {{ $laporan->koin_reward }} koin</p>
                </div>
                @endif
            </div>

            <!-- Foto dari Warga -->
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Foto dari Pelapor</p>
                <div class="w-full h-48 rounded-3xl overflow-hidden border border-outline shadow-sm">
                    <img src="{{ asset('storage/' . $laporan->foto_laporan_warga) }}" alt="Foto Bukti" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Kamera Evidence (Untuk Petugas) - Muncul saat pembersihan -->
            <div x-show="status === 'sedang_dibersihkan'" x-transition.opacity style="display: none;">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Foto Hasil Pembersihan</p>
                
                <label class="block w-full bg-surface border-2 border-dashed border-outline rounded-3xl p-8 text-center cursor-pointer hover:bg-primary/5 hover:border-primary/50 transition-colors active:scale-[0.98] overflow-hidden relative" :class="imagePreview ? 'p-0 border-solid' : ''">
                    <div x-show="!imagePreview">
                        <div class="w-16 h-16 rounded-full bg-primary/20 text-primary flex items-center justify-center mx-auto mb-3 shadow-sm">
                            <span class="material-symbols-outlined text-[32px]">photo_camera</span>
                        </div>
                        <p class="font-bold text-on-surface text-sm mb-1">Ambil Foto Hasil</p>
                        <p class="text-[10px] text-on-surface-variant">Klik untuk buka kamera</p>
                    </div>
                    <div x-show="imagePreview" style="display: none;" class="w-full h-48 relative">
                        <img :src="imagePreview" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <div class="bg-white/90 px-3 py-1.5 rounded-lg text-sm font-bold text-on-surface flex items-center gap-2 shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">edit</span> Ganti Foto
                            </div>
                        </div>
                    </div>
                    <input type="file" accept="image/*" capture="environment" class="hidden" @change="if($event.target.files.length) { imagePreview = URL.createObjectURL($event.target.files[0]); fotoFile = $event.target.files[0]; }">
                </label>
            </div>

            <!-- Error Message -->
            <div x-show="errorMessage" x-transition class="bg-red-50 border border-red-200 rounded-2xl p-4" style="display: none;">
                <p class="text-sm font-medium text-red-700" x-text="errorMessage"></p>
            </div>

        </div>

        <!-- Sticky Bottom Actions -->
        <div class="fixed bottom-0 w-full max-w-md mx-auto bg-surface border-t-2 border-outline p-4 pb-safe z-40 rounded-t-3xl shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
            <!-- State 1: Mulai Pembersihan (dari status disetujui atau ditunda) -->
            <button x-show="status === 'disetujui' || status === 'ditunda'" 
                    @click="
                        if (isLoading) return;
                        isLoading = true;
                        errorMessage = '';
                        axios.post('/petugas/laporan/' + laporanId + '/mulai')
                            .then(response => {
                                status = 'sedang_dibersihkan';
                            })
                            .catch(error => {
                                errorMessage = error.response?.data?.message || 'Gagal memulai pembersihan.';
                            })
                            .finally(() => {
                                isLoading = false;
                            });
                    " 
                    :disabled="isLoading"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="w-full bg-primary text-white font-bold py-4 mb-4 rounded-2xl transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 active:scale-[0.98]">
                <span x-show="!isLoading" class="material-symbols-outlined">cleaning_services</span>
                <span x-show="!isLoading">Mulai Pembersihan</span>
                <span x-show="isLoading" style="display: none;">
                    <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>

            <!-- State 2: Selesai / Tunda -->
            <div x-show="status === 'sedang_dibersihkan'" class="flex gap-3 mb-4" style="display: none;">
                <button @click="showModalTunda = true" :disabled="isLoading" class="flex-1 bg-surface-variant text-on-surface font-bold py-4 rounded-2xl transition-colors active:scale-[0.98]">Tunda</button>
                <button @click="showConfirmSelesai = true" :disabled="isLoading" class="flex-[2] bg-primary text-white font-bold py-4 rounded-2xl transition-colors shadow-lg shadow-primary/30 flex items-center justify-center gap-2 active:scale-[0.98]">
                    <span class="material-symbols-outlined">check_circle</span>
                    Tandai Selesai
                </button>
            </div>
        </div>

        </div>

        <!-- SUCCESS STATE UI (Tampil jika selesai) -->
        <div x-show="status === 'selesai'" x-transition.opacity.duration.300ms class="min-h-screen flex flex-col items-center justify-center px-6 py-12 text-center" style="display: none;">
            <div class="w-24 h-24 rounded-full bg-primary/20 text-primary flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-[48px]">check_circle</span>
            </div>
            <h2 class="text-2xl font-black text-on-surface mb-2">Pembersihan Selesai!</h2>
            <p class="text-on-surface-variant mb-8">Terima kasih atas kerja kerasmu. Tumpukan sampah di lokasi ini telah dibersihkan sepenuhnya.</p>
            
            <a href="{{ route('petugas.beranda') }}" class="w-full bg-primary text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 active:scale-[0.98]">
                Kembali ke Beranda
            </a>
        </div>

        <!-- TUNDA STATE UI -->
        <div x-show="status === 'ditunda' && justDelayed" x-transition.opacity.duration.300ms class="min-h-screen flex flex-col items-center justify-center px-6 py-12 text-center" style="display: none;">
            <div class="w-24 h-24 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-[48px]">hourglass_empty</span>
            </div>
            <h2 class="text-2xl font-black text-on-surface mb-2">Laporan Ditunda</h2>
            <p class="text-on-surface-variant mb-8">Pembersihan laporan ditunda dan dialihkan ke admin atau shift berikutnya.</p>
            
            <a href="{{ route('petugas.beranda') }}" class="w-full bg-surface border border-outline hover:bg-surface-variant text-on-surface font-bold py-4 rounded-2xl transition-all shadow-sm flex items-center justify-center gap-2 active:scale-[0.98]">
                Kembali ke Beranda
            </a>
        </div>

        <!-- Modal Penundaan -->
        <div x-show="showModalTunda" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
            <div x-show="showModalTunda" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showModalTunda = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
            <div x-show="showModalTunda" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="absolute bottom-0 w-full max-w-md left-1/2 -translate-x-1/2 bg-surface rounded-t-[2rem] shadow-2xl p-6 pb-safe border-t border-outline">
                <div class="w-12 h-1.5 bg-outline rounded-full mx-auto mb-6"></div>
                
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">hourglass_empty</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-on-surface">Tunda Pembersihan</h3>
                        <p class="text-xs font-medium text-on-surface-variant mt-0.5">Beritahu alasan penundaan ini</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2 px-1">Alasan Penundaan</label>
                        <select x-model="alasanUtama" class="w-full bg-surface border border-outline rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all mb-3 appearance-none">
                            <option value="">Pilih Alasan Utama...</option>
                            <option value="Butuh alat berat / bantuan ekstra">Butuh alat berat / bantuan ekstra</option>
                            <option value="Cuaca buruk / hujan badai">Cuaca buruk / hujan badai</option>
                            <option value="Akses ditutup sementara">Akses ditutup sementara</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <textarea x-model="catatanTambahan" rows="2" class="w-full bg-surface border border-outline rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-none" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>
                    
                    <button @click="
                        if (isLoading || !alasanUtama) return;
                        isLoading = true;
                        errorMessage = '';
                        axios.post('/petugas/laporan/' + laporanId + '/tunda', {
                            alasan_utama: alasanUtama,
                            catatan_tambahan: catatanTambahan
                        })
                        .then(response => {
                            showModalTunda = false;
                            justDelayed = true;
                            status = 'ditunda';
                        })
                        .catch(error => {
                            errorMessage = error.response?.data?.message || 'Gagal menunda pembersihan.';
                            showModalTunda = false;
                        })
                        .finally(() => {
                            isLoading = false;
                        });
                    " 
                    :disabled="isLoading || !alasanUtama"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading || !alasanUtama }"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-orange-500/30 transition-all flex items-center justify-center gap-2">
                        <span x-show="!isLoading" class="material-symbols-outlined text-[20px]">send</span>
                        <span x-show="!isLoading">Kirim & Tunda</span>
                        <span x-show="isLoading" style="display: none;">
                            <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                    <button @click="showModalTunda = false" class="w-full bg-surface border border-outline hover:bg-surface-variant text-on-surface font-bold py-3.5 rounded-xl transition-colors">Batal</button>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Selesai -->
        <div x-show="showConfirmSelesai" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="showConfirmSelesai" x-transition.opacity class="fixed inset-0 bg-black/50 transition-opacity" @click="showConfirmSelesai = false"></div>
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div x-show="showConfirmSelesai" x-transition.scale class="relative bg-surface rounded-3xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-sm">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 rounded-full bg-primary/20 text-primary flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-[32px]">task_alt</span>
                        </div>
                        <h3 class="text-lg font-black text-on-surface mb-2">Laporan Diselesaikan?</h3>
                        <p class="text-sm text-on-surface-variant mb-6">Pastikan area sudah bersih dan kamu telah mengunggah foto bukti pembersihan.</p>
                        <div x-show="!fotoFile" class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-4">
                            <p class="text-xs font-medium text-yellow-700">⚠️ Kamu belum mengunggah foto hasil pembersihan.</p>
                        </div>
                        <div class="flex gap-3">
                            <button @click="showConfirmSelesai = false" class="flex-1 py-3 rounded-xl font-bold text-on-surface bg-surface-variant transition-colors">Batal</button>
                            <button @click="
                                if (isLoading || !fotoFile) return;
                                isLoading = true;
                                errorMessage = '';
                                showConfirmSelesai = false;
                                
                                let formData = new FormData();
                                formData.append('foto_hasil', fotoFile);
                                
                                axios.post('/petugas/laporan/' + laporanId + '/selesai', formData, {
                                    headers: { 'Content-Type': 'multipart/form-data' }
                                })
                                .then(response => {
                                    status = 'selesai';
                                })
                                .catch(error => {
                                    errorMessage = error.response?.data?.message || 'Gagal menyelesaikan pembersihan.';
                                })
                                .finally(() => {
                                    isLoading = false;
                                });
                            " 
                            :disabled="isLoading || !fotoFile"
                            :class="{ 'opacity-50 cursor-not-allowed': isLoading || !fotoFile }"
                            class="flex-1 py-3 rounded-xl font-bold text-white bg-primary shadow-lg shadow-primary/30 transition-colors flex items-center justify-center gap-1">
                                <span x-show="!isLoading">Ya, Selesai</span>
                                <span x-show="isLoading" style="display: none;">
                                    <svg class="animate-spin h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Leaflet -->
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush
    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            setTimeout(() => {
                const lat = {{ $laporan->lat }};
                const lng = {{ $laporan->lng }};
                var map = L.map('map', {zoomControl: false}).setView([lat, lng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OSM'
                }).addTo(map);

                // Add Native Marker
                L.marker([lat, lng]).addTo(map);
            }, 100);
        });
    </script>
    @endpush
</x-petugas-layout>
