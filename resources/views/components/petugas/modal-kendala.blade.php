<div x-show="showKendala" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
    <!-- Backdrop -->
    <div x-show="showKendala" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="showKendala = false"
         class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Bottom Sheet -->
    <div x-show="showKendala"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="absolute bottom-0 w-full max-w-md left-1/2 -translate-x-1/2 bg-surface rounded-t-[2rem] shadow-2xl p-6 pb-safe border-t border-outline">
        
        <!-- Drag Handle Indicator -->
        <div class="w-12 h-1.5 bg-outline rounded-full mx-auto mb-6"></div>

        <template x-if="kendalaType === 'beda_ukuran'">
            <div x-data="{ localPreview: null }">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">straighten</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-on-surface">Ukuran Berbeda</h3>
                        <p class="text-xs font-medium text-on-surface-variant mt-0.5">Sampah melebihi pesanan</p>
                    </div>
                </div>

                <div class="bg-orange-50 border border-orange-200 rounded-2xl p-4 mb-6">
                    <p class="text-sm font-bold text-orange-800 mb-1">Peringatan</p>
                    <p class="text-xs text-orange-600 leading-relaxed">Pengguna mendaftar untuk pengangkutan Kecil, tapi sampah di lapangan berskala Sedang/Besar.</p>
                </div>

                <div class="space-y-4">
                    <!-- Photo Evidence -->
                    <div>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2 px-1">Foto Bukti (Wajib)</p>
                        <label class="block w-full bg-surface border-2 border-dashed border-outline rounded-2xl text-center cursor-pointer hover:bg-surface-variant transition-colors overflow-hidden relative" :class="localPreview ? 'p-0 border-solid' : 'p-6'">
                            <div x-show="!localPreview">
                                <span class="material-symbols-outlined text-on-surface-variant text-[28px] mb-2">add_a_photo</span>
                                <p class="font-bold text-on-surface text-sm">Ambil Foto Kondisi Asli</p>
                            </div>
                            <div x-show="localPreview" style="display: none;" class="w-full h-40 relative">
                                <img :src="localPreview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                    <div class="bg-white/90 px-3 py-1.5 rounded-lg text-sm font-bold text-on-surface flex items-center gap-2 shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">edit</span> Ganti Foto
                                    </div>
                                </div>
                            </div>
                            <input type="file" accept="image/*" capture="environment" class="hidden" @change="if($event.target.files.length) localPreview = URL.createObjectURL($event.target.files[0])">
                        </label>
                    </div>
                    
                    <button @click="showKendala = false; status = 'dibatalkan'" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">send</span>
                        Kirim Laporan & Tunda
                    </button>
                    <button @click="showKendala = false" class="w-full bg-surface border border-outline hover:bg-surface-variant text-on-surface font-bold py-3.5 rounded-xl transition-colors">Batal</button>
                </div>
            </div>
        </template>

        <template x-if="kendalaType === 'terkunci'">
            <div x-data="{ localPreview: null }">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">lock</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-on-surface">Pagar Tertutup</h3>
                        <p class="text-xs font-medium text-on-surface-variant mt-0.5">Tidak bisa masuk ke lokasi</p>
                    </div>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6">
                    <p class="text-sm font-bold text-red-800 mb-1">Tindakan</p>
                    <p class="text-xs text-red-600 leading-relaxed">Pastikan Anda sudah mencoba menelepon warga atau memanggil selama minimal 5 menit.</p>
                </div>

                <div class="space-y-4">
                    <!-- Photo Evidence -->
                    <div>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2 px-1">Foto Kondisi (Wajib)</p>
                        <label class="block w-full bg-surface border-2 border-dashed border-outline rounded-2xl text-center cursor-pointer hover:bg-surface-variant transition-colors overflow-hidden relative" :class="localPreview ? 'p-0 border-solid' : 'p-6'">
                            <div x-show="!localPreview">
                                <span class="material-symbols-outlined text-on-surface-variant text-[28px] mb-2">add_a_photo</span>
                                <p class="font-bold text-on-surface text-sm">Ambil Foto Pagar</p>
                            </div>
                            <div x-show="localPreview" style="display: none;" class="w-full h-40 relative">
                                <img :src="localPreview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                    <div class="bg-white/90 px-3 py-1.5 rounded-lg text-sm font-bold text-on-surface flex items-center gap-2 shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">edit</span> Ganti Foto
                                    </div>
                                </div>
                            </div>
                            <input type="file" accept="image/*" capture="environment" class="hidden" @change="if($event.target.files.length) localPreview = URL.createObjectURL($event.target.files[0])">
                        </label>
                    </div>
                    
                    <button @click="showKendala = false; status = 'dibatalkan'" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-red-600/30 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                        Batalkan Pengangkutan
                    </button>
                    <button @click="showKendala = false" class="w-full bg-surface border border-outline hover:bg-surface-variant text-on-surface font-bold py-3.5 rounded-xl transition-colors">Batal</button>
                </div>
            </div>
        </template>
        
    </div>
</div>
