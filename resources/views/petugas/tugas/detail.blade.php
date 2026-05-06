<x-petugas-layout :hideNav="true">
    <div x-data="{ 
        showKendala: false,
        kendalaType: '',
        isDone: false,
        showConfirmSelesai: false,
        imagePreview: null,
        status: 'menunggu' // 'menunggu' -> 'diproses' -> 'selesai' -> 'dibatalkan'
    }">
        
        <!-- MAIN CONTENT (Tampil jika belum selesai/batal) -->
        <div x-show="status !== 'selesai' && status !== 'dibatalkan'">
            <!-- Header -->
            <header class="bg-surface border-b border-outline px-4 pt-6 pb-4 sticky top-0 z-30 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.beranda') }}" class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-outline transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-lg font-black text-on-surface leading-tight">Detail Tugas</h1>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">{{ $id ?? 'INV-1001' }}</p>
                </div>
            </div>
        </header>

        <div class="px-4 py-6 pb-40 space-y-6">
            
            <!-- Address Card -->
            <div class="glass-card rounded-3xl p-5">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">location_on</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-md inline-block mb-1">Angkut Sampah</p>
                        <h2 class="text-lg font-black text-on-surface leading-tight">Jl. Merdeka No. 45, Blok C</h2>
                        <p class="text-xs font-bold text-on-surface-variant mt-0.5 italic">{{ $detail_patokan ?? 'Pagar Hitam, Depan Warung' }}</p>
                        <p class="text-sm font-medium text-on-surface mt-2">Bpk. Budi Santoso</p>
                    </div>
                    <a href="tel:08123456789" class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 hover:bg-primary/20 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">call</span>
                    </a>
                </div>
                
                <div class="bg-orange-50/50 border border-orange-200 rounded-2xl p-4 flex items-start gap-2">
                    <span class="material-symbols-outlined text-orange-500 text-[18px] shrink-0 mt-0.5">description</span>
                    <div>
                        <p class="text-[10px] font-bold text-orange-600 uppercase tracking-wider mb-0.5">Catatan Pesanan</p>
                        <p class="text-xs font-bold text-on-surface-variant leading-relaxed">{{ $catatan_warga ?? 'Tolong panggil nomor rumah jika pagar dikunci. Anjing penjaga sudah diikat.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Konten Aktif (Muncul setelah di-proses) -->
            <div x-show="status === 'diproses'" x-transition.opacity class="space-y-6" style="display: none;">
                <!-- Kamera Evidance -->
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Foto Bukti Pengambilan</p>
                    
                    <label class="block w-full bg-surface border-2 border-dashed border-outline rounded-3xl p-8 text-center cursor-pointer hover:bg-primary/5 hover:border-primary/50 transition-colors active:scale-[0.98] overflow-hidden relative" :class="imagePreview ? 'p-0 border-solid' : ''">
                        <div x-show="!imagePreview">
                            <div class="w-16 h-16 rounded-full bg-primary/20 text-primary flex items-center justify-center mx-auto mb-3 shadow-sm">
                                <span class="material-symbols-outlined text-[32px]">photo_camera</span>
                            </div>
                            <p class="font-bold text-on-surface text-sm mb-1">Ambil Foto Bukti</p>
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
                        <input type="file" accept="image/*" capture="environment" class="hidden" @change="if($event.target.files.length) imagePreview = URL.createObjectURL($event.target.files[0])">
                    </label>
                </div>

                <!-- Tombol Kendala Lapangan -->
                <div class="grid grid-cols-2 gap-4">
                    <button @click="showKendala = true; kendalaType = 'beda_ukuran'" class="bg-surface border border-outline rounded-2xl p-4 flex flex-col items-center justify-center text-center gap-2 hover:bg-orange-50 hover:border-orange-200 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-surface-variant group-hover:bg-orange-100 flex items-center justify-center text-on-surface-variant group-hover:text-orange-500 transition-colors">
                            <span class="material-symbols-outlined">straighten</span>
                        </div>
                        <span class="text-[10px] font-bold text-on-surface">Beda Ukuran</span>
                    </button>

                    <button @click="showKendala = true; kendalaType = 'terkunci'" class="bg-surface border border-outline rounded-2xl p-4 flex flex-col items-center justify-center text-center gap-2 hover:bg-orange-50 hover:border-orange-200 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-surface-variant group-hover:bg-orange-100 flex items-center justify-center text-on-surface-variant group-hover:text-orange-500 transition-colors">
                            <span class="material-symbols-outlined">lock</span>
                        </div>
                        <span class="text-[10px] font-bold text-on-surface">Pagar Tertutup</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sticky Bottom Actions -->
        <div class="fixed bottom-0 w-full max-w-md mx-auto bg-surface border-t-2 border-outline p-4 pb-safe z-40 rounded-t-3xl shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
            <!-- State 1: Start Process -->
            <button x-show="status === 'menunggu'" @click="status = 'diproses'" class="w-full bg-primary text-white font-bold py-4 mb-4 rounded-2xl transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 active:scale-[0.98]">
                <span class="material-symbols-outlined">directions_car</span>
                Proses Pesanan (Otw)
            </button>
            
            <!-- State 2: Finish Button (Replacing Swipe) -->
            <button x-show="status === 'diproses'" @click="showConfirmSelesai = true" class="w-full bg-primary text-white font-bold py-4 mb-4 rounded-2xl transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 active:scale-[0.98]" style="display: none;">
                <span class="material-symbols-outlined">check_circle</span>
                Selesaikan Pesanan
            </button>
        </div>

        </div>

        <!-- SUCCESS STATE UI (Tampil jika selesai) -->
        <div x-show="status === 'selesai'" x-transition.opacity.duration.300ms class="min-h-screen flex flex-col items-center justify-center px-6 py-12 text-center" style="display: none;">
            <div class="w-24 h-24 rounded-full bg-primary/20 text-primary flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-[48px]">check_circle</span>
            </div>
            <h2 class="text-2xl font-black text-on-surface mb-2">Pesanan Selesai!</h2>
            <p class="text-on-surface-variant mb-8">Kerja bagus! Sampah warga berhasil diangkut. Lanjut ke tugas berikutnya.</p>
            
            <a href="{{ route('petugas.komplek.warga', 1) }}" class="w-full bg-primary text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 active:scale-[0.98]">
                Kembali ke Daftar Warga
            </a>
        </div>

        <!-- CANCEL STATE UI (Tampil jika dibatalkan) -->
        <div x-show="status === 'dibatalkan'" x-transition.opacity.duration.300ms class="min-h-screen flex flex-col items-center justify-center px-6 py-12 text-center" style="display: none;">
            <div class="w-24 h-24 rounded-full bg-red-100 text-red-600 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-[48px]">cancel</span>
            </div>
            <h2 class="text-2xl font-black text-on-surface mb-2">Tugas Dibatalkan</h2>
            <p class="text-on-surface-variant mb-8">Laporan kendalamu telah dikirimkan ke Admin. Lanjut ke tugas berikutnya.</p>
            
            <a href="{{ route('petugas.komplek.warga', 1) }}" class="w-full bg-red-50 border border-red-200 hover:bg-red-100 text-red-600 font-bold py-4 rounded-2xl transition-all shadow-sm flex items-center justify-center gap-2 active:scale-[0.98]">
                Kembali ke Daftar Warga
            </a>
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
                        <h3 class="text-lg font-black text-on-surface mb-2">Selesaikan Pesanan?</h3>
                        <p class="text-sm text-on-surface-variant mb-6">Pastikan kamu sudah mengangkut semua sampah milik warga ini dan mengambil foto bukti.</p>
                        <div class="flex gap-3">
                            <button @click="showConfirmSelesai = false" class="flex-1 py-3 rounded-xl font-bold text-on-surface bg-surface-variant transition-colors">Batal</button>
                            <button @click="showConfirmSelesai = false; status = 'selesai'" class="flex-1 py-3 rounded-xl font-bold text-white bg-primary shadow-lg shadow-primary/30 transition-colors">Ya, Selesai</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <x-petugas.modal-kendala />

    </div>
</x-petugas-layout>
